<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseProperty;
use App\Models\Customer;
use App\Models\CustomerType;
use App\Models\Type;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\CustomerValidate;
use App\Http\Requests\CardValidate;
use DB;
use Hash;
use App\Models\Record;
use App\Models\Course;
use App\Models\RelationProperty;
use App\Http\Requests\BuyValidate;
use App\Http\Requests\RelationValidate;
use Carbon\Carbon;

class CustomerController extends Controller
{
    private $today;

    public function __construct()
    {
        view()->share([
            '_customer' => 'am-active',
            'courses' => Course::all_courses(),
            'types' => Type::all(),
            'users' => User::where('is_master', true)->get(),
        ]);

        $this->today = date('Y-m-d', time()); // 当天日期
    }


    /**
     * 后台--会员管理--会员列表
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $where = function ($query) use ($request) {
            if ($request->has('mobile') && $request->user_id == '-1') {
                $query->where('mobile', $request->mobile);
            }

            if ($request->has('user_id') && $request->user_id != "" && $request->mobile == "") {
                $result = User::where('id', $request->user_id)->get();
                $query->whereIn('user_id', $result);
            }
        };
        $customers = Customer::with('user', 'types')->where($where)->orderBy('created_at', 'desc')->paginate(env('pageSize'));
//        foreach ($customers as $k => $v) {
//            $time = explode(' ', $v['expired_at']);
//            $customers[$k]['start_time'] = $time[0];
//            $customers[$k]['end_time'] = isset($time[2]) ? $time[2] : '';
//        }

//        return $customers;
        return view('admin.customer.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.customer.create');
    }

    /**
     * 后台--会员管理--会员列表--录入会员
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerValidate $request)
    {
        Customer::create([
            'username' => $request->username,
            'user_id' => $request->user_id,
            'mobile' => $request->mobile,
            'birthday' => $request->birthday,
            'password' => Hash::make($request->password),
        ]);
        return redirect(route('admin.customers.index'))->with('success', '录入成功');
    }


    /**
     * 后台--会员管理--会员列表--办卡
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customer::find($id);
        return view('admin.customer.edit', compact('customer'));
    }

    /***
     * 后台--会员列表--办卡
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(CardValidate $request, $id)
    {
        $customer = Customer::find($id);
        $customer->update([
            'username' => $request->username,
            'user_id' => $request->user_id,
            'mobile' => $request->mobile,
            'birthday' => $request->birthday,
            'cycle_id' => $request->cycle_id,
            'expired_at' => $request->expired_at,
            'card_price' => $request->card_price,
            'card_at' => Carbon::now(),
        ]);
        $customer->types()->syncWithoutDetaching($request->type_id);
        return redirect(route('admin.customers.index'))->with('success', '办卡成功');
    }

    /***
     * 购课
     * @param $id
     */
    public function buy($id)
    {
        $customer = Customer::with('user', 'course_properties')->find($id);
        return view('admin.customer.buy', compact('customer'));
    }

    /***
     * 更新购课
     * @param BuyValidate $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function buy_update(BuyValidate $request, $id)
    {
        //1. 更新基础数据
        $customer = Customer::find($id);
        $customer->update($request->only('username', 'user_id', 'mobile', 'birthday'));
        // 先去中间表查当前会员的类型是否存在，如果不存在则插入
        $type = CustomerType::where('customer_id', $id)->get()->toArray();

        $proper_courses = $request->course_id;
        $proper_hours = $request->c_hour;
        $proper_prices = $request->c_price;
        if (!in_array($request->type_id[0], $type)) {
            //2. 同步数据到类型表
            $customer->types()->syncWithoutDetaching($request->type_id);

            CourseProperty::create([
                'customer_id' => $id,
                'course_id' => end($proper_courses),
                'c_hour' => end($proper_hours),
                'c_price' => end($proper_prices),
                'paid_at' => Carbon::now(),
            ]);
        }
//        else {
//            //接收过来的三个数组重新组装成json格式
//            $count = count($proper_ids);
//            return $count;
//            for ($i = 0; $i < $count; $i++) {
//                $array[] = ['course_id' => $proper_courses[$i], 'c_hour' => $proper_hours[$i], 'c_price' => $proper_prices[$i], 'pid' => $proper_ids[$i]];
//            }
//
//            return $array;
//
//            if (count($proper_ids) == count($proper_courses)) {
//                //通过循环更新
//                foreach ($array as $k => $v) {
//                    CourseProperty::where('id', $v['pid'])->update([
//                        'customer_id' => $id,
//                        'course_id' => $v['course_id'],
//                        'c_hour' => $v['c_hour'],
//                        'c_price' => $v['c_price'],
//                    ]);
//                }
//            }
//        }

        return redirect(route('admin.customers.index'))->with('success', '编辑成功');
    }

    /***
     * 赠课
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function relation($id)
    {
        $relation = Customer::with('relation_properties')->find($id);
        return view('admin.customer.relation', compact('relation'));
    }

    /***
     * 更新赠课
     * 已购买的课程不能赠送
     * @param Request $request
     * @param $id
     */
    public function relation_update(RelationValidate $request, $id)
    {
        // 已购买的课程不能赠送
        $buy_courses = CourseProperty::where('customer_id', $id)->whereIn('course_id', $request->course_id)->first();
        if ($buy_courses) {
            return back()->with('error', '该课程已购买，不能赠送');
            return;
        }
        $customer = Customer::find($id);
        $customer->update($request->only('username', 'user_id', 'mobile', 'birthday'));

        // 先去中间表查当前会员的类型是否存在，如果不存在则插入
        $type = CustomerType::where('customer_id', $id)->get()->toArray();

        $proper_courses = $request->course_id;
        $proper_hours = $request->g_hour;

        if (!in_array($request->type_id[0], $type)) {
            //2. 同步数据到类型表
            $customer->types()->syncWithoutDetaching($request->type_id);

            RelationProperty::create([
                'customer_id' => $id,
                'course_id' => end($proper_courses),
                'g_hour' => end($proper_hours),
                'paid_at' => Carbon::now(),
            ]);
        }
        return redirect(route('admin.customers.index'))->with('success', '编辑成功');
    }

    /***
     * 编辑会员---删除购买课程
     * @param Request $request
     */
    public function del_one(Request $request)
    {
        CourseProperty::destroy($request->id);
    }

    /***
     * 删除赠送课程,当该用户的赠送课程删完后，清除类型表的类型
     * @param Request $request
     */
    public function del_relation(Request $request)
    {
        RelationProperty::destroy($request->id);
        $res = RelationProperty::where('customer_id', $request->cid)->first();
        if (!$res) {
            CustomerType::where('customer_id', $request->cid)->where('type_id', $request->tid)->delete();
        }
    }

    /**
     * 教练后台--会员列表--开始上课
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // 当前会员购买课程记录
        $buy_records = CourseProperty::with('course')->where('customer_id', $id)->paginate(env('pageSize'));

        // 当前会员赠送课程记录
        $relation_records = RelationProperty::with('course')->where('customer_id', $id)->paginate(env('pageSize'));

        $customer = Customer::find($id);

        // 当前会员上课记录
        $records = Record::with('course', 'relation_course')->where('customer_id', $id)->orderBy('created_at', 'desc')->paginate(env('pageSize'));
//        return $records;
        foreach ($records as $k => $v) {
            if ($v->buy_course_id) {
                // 当前购课课程单价
                $records[$k]['surplus_price'] = CourseProperty::where('customer_id', $v->customer_id)->where('course_id', $v->buy_course_id)->value('c_price');
            }
        }
        return view('admin.customer.show', compact('buy_records', 'relation_records', 'customer', 'records'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Customer::destroy($id);
        CourseProperty::where('customer_id', $id)->delete();
        CustomerType::where('customer_id', $id)->delete();
        RelationProperty::where('customer_id', $id)->delete();
        Record::where('customer_id', $id)->delete();
        return back()->with('success', '删除成功');
    }
}
