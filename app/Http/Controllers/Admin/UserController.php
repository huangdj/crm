<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\Checkout;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserValidate;
use App\Models\Record;
use App\Models\CourseProperty;
use App\Http\Requests\KpiValidate;

class UserController extends Controller
{
    private $month;

    public function __construct()
    {
        view()->share([
            '_user' => 'am-active',
        ]);
        $this->month = date('m', time()); // 当月日期
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $where = function ($query) use ($request) {
            if ($request->has('realname') && $request->master_no == "") {
                $query->where('realname', $request->realname);
            }

            if ($request->has('master_no') && $request->realname == "") {
                $query->where('master_no', $request->master_no);
            }
        };
        $users = User::where($where)->where('is_master', true)->orderBy('id', 'desc')->paginate(env('pageSize'));
        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserValidate $request)
    {
        User::create([
            'master_no' => $request->master_no,
            'name' => $request->name,
            'realname' => $request->realname,
            'base_salary' => $request->base_salary,
            'task' => $request->task,
            'password' => bcrypt($request->input('password')),
        ]);
        return redirect()->to('/admin/users')->with('success', '新增成功');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::with('customers')->where('is_master', true)->find($id);
        // 当前教练当月上课收入
        $month_records = Record::where('user_id', $id)->whereNotNull('buy_course_id')->whereMonth('created_at', $this->month)->get();
        $month_total = 0;
        foreach ($month_records as $k => $v) {
            $month_total += CourseProperty::where('customer_id', $v->customer_id)->where('course_id', $v->buy_course_id)->value('c_price');
        }
        // 查出当前教练KPI指标
        $kpi = Achievement::where('user_id', $id)->get();

        // 根据不同层次的指标计算上课提成
        foreach ($kpi as $v) {
            if ($month_total > $v->start && $month_total < $v->end) {
                $month_total = $month_total * $v->percent / 100;
            }
        }

        // 当前教练当月卖课收入
        $sell_total = 0;
        foreach ($user->customers as $key => $value) {
            $sell_courses = CourseProperty::where('customer_id', $value->id)->whereMonth('paid_at', $this->month)->get();
            foreach ($sell_courses as $k => $v) {
                $sell_total += $v->c_hour * $v->c_price;
            }
        }
        // 根据不同层次的指标计算卖课提成
        if ($sell_total < $user->task) {
            $sell_total = ($sell_total * 0.3);
        } elseif ($sell_total >= $user->task && $sell_total < 80000) {
            $sell_total = ($sell_total * 0.35);
        } else {
            $sell_total = ($sell_total * 0.38);
        }

        return view('admin.user.show', compact('user', 'month_total', 'sell_total'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserValidate $request, $id)
    {
        User::where('id', $id)->update([
            'master_no' => $request->master_no,
            'realname' => $request->realname,
            'base_salary' => $request->base_salary,
            'task' => $request->task,
        ]);
        return redirect()->to('/admin/users')->with('success', '编辑成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function dismiss(Request $request)
    {
        User::where('id', $request->id)->update(['is_job' => false]);
        return response()->json(['status' => 1, 'msg' => '您已解雇该教练！']);
    }


    /***
     * 复职
     * @param Request $request
     */
    public function res_dismiss(Request $request)
    {
        User::where('id', $request->id)->update(['is_job' => true]);
        return response()->json(['status' => 1, 'msg' => '欢迎回来！']);
    }


    /***
     * 多选删除
     * @param Request $request
     */
    public function destroy_checked(Request $request)
    {
        User::destroy($request->checked_id);
        return response()->json(['status' => 1, 'msg' => '删除成功']);
    }


    /***
     * KPI设置
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function kpi($id)
    {
        $user = User::with('achievements')->find($id);
        return view('admin.user.kpi', compact('user'));
    }


    /***
     * 保存KPI设置
     * @param Request $request
     * @param $id
     */
    public function kpi_update(KpiValidate $request, $id)
    {
        $user = User::find($id);
        $proper_starts = $request->start;
        $proper_ends = $request->end;
        $proper_percents = $request->percent;

        $user->achievements()->create([
            'start' => end($proper_starts),
            'end' => end($proper_ends),
            'percent' => end($proper_percents),
        ]);

        return redirect(route('admin.users.index'))->with('success', '设置成功~');
    }

    /***
     * 删除KPI
     * @param Request $request
     */
    public function del_one(Request $request)
    {
        Achievement::destroy($request->id);
    }
}
