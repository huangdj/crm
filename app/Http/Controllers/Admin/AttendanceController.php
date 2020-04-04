<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AttendanceController extends Controller
{
    private $today;
    private $monthStart;
    private $monthEnd;

    public function __construct()
    {
        $this->today = date('Y-m-d', time()); // 当天日期
        $this->monthStart = date('Y-m-d', strtotime(date('Y-m-01') . ' -1 day'));  // 获取上一月第一天
        $this->monthEnd = date('Y-m-d', strtotime(date('Y-m-01') . ' -1 month'));  // 获取上一月最后一天

        view()->share([
            '_attendances' => 'am-active'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 只查上一个月的考勤记录
        $attendances = Attendance::with('user')->orderBy('userCheckTime', 'desc')->paginate(env('pageSize'));

        $users = User::where('is_master', true)->get();
        foreach ($users as $k => $v) {
            $late_num = Attendance::where('userId', $v->id)->where('timeResult', 'Late')->count();// 迟到
            $notSigned = Attendance::where('userId', $v->id)->where('timeResult', 'NotSigned')->count(); // 未打卡
            $users[$k]['late_num'] = $late_num;
            $users[$k]['notSigned_num'] = $notSigned;
        }
        return view('admin.attendance.index', compact('attendances', 'users'));
    }

    /**
     * 导入考勤
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        $result = $request->data;
        // 当日数据已导出不能再导出了，即不能重复导出当日数据
        $data = Attendance::whereDate('userCheckTime', $this->today)->get();
        if (!$data->isEmpty()) {
            return response()->json(['status' => false, 'message' => '今日考勤已导出,请勿重复操作']);
        }
        foreach ($result as $k => $v) {
            \DB::table('attendances')->insertOrIgnore([
                'userId' => $v['userId'],
                'timeResult' => $v['timeResult'],
                'userCheckTime' => $v['userCheckTime'],
                'sourceType' => $v['sourceType'],
            ]);
        }
        return response()->json(['status' => true, 'message' => '导出成功']);
    }
}
