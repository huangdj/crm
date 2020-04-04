<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\Record;
use App\Models\Course;
use App\Models\CourseProperty;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    private $today;
    private $month;
    private $year;

    public function __construct()
    {
        $this->today = date('Y-m-d', time()); // 当天日期
        $this->month = date('m', time()); // 当月日期
        $this->year = date('Y', time()); // 当年年份
    }

    /***
     * 所有教练每日课时费统计
     */
    public function day_income()
    {
        $masters = User::where('is_master', true)->get();
        $data = [];
        $data2 = [];
        foreach ($masters as $key => $value) {
            $day_records = Record::where('user_id', $value->id)->whereDate('created_at', $this->today)->where('status', 1)->get();
            $day_total = 0;
            foreach ($day_records as $k => $v) {
                if ($v->buy_course_id) {
                    $day_total += CourseProperty::where('customer_id', $v->customer_id)->where('course_id', $v->buy_course_id)->value('c_price');
                }
            }

            $data[] = ['value' => $day_total, 'name' => $value->realname];
            $data2[] = $value->realname;
            $data3 = date('Y年m月d日', time());
        }

        return compact('data', 'data2', 'data3');
    }

    /***
     * 所有教练每月课时费统计
     */
    public function month_income()
    {
        $masters = User::with('customers')->where('is_master', true)->get();
        $data = [];
        $data2 = [];
        foreach ($masters as $key => $value) {
            $month_records = Record::where('user_id', $value->id)->whereMonth('created_at', $this->month)->where('status', 1)->get();
            $month_total = 0;
            foreach ($month_records as $k => $v) {
                if ($v->buy_course_id) {
                    $month_total += CourseProperty::where('customer_id', $v->customer_id)->where('course_id', $v->buy_course_id)->value('c_price');
                }
            }

            $data[] = ['value' => $month_total, 'name' => $value->realname];
            $data2[] = $value->realname;
        }

        // 这里最好改为 switch case 更为妥善
        if ($this->month == '01') {
            $data3 = "一月";
        } elseif ($this->month == '02') {
            $data3 = "二月";
        } elseif ($this->month == '03') {
            $data3 = "三月";
        } elseif ($this->month == '04') {
            $data3 = "四月";
        } elseif ($this->month == '05') {
            $data3 = "五月";
        } elseif ($this->month == '06') {
            $data3 = "六月";
        } elseif ($this->month == '07') {
            $data3 = "七月";
        } elseif ($this->month == '08') {
            $data3 = "八月";
        } elseif ($this->month == '09') {
            $data3 = "九月";
        } elseif ($this->month == '10') {
            $data3 = "十月";
        } elseif ($this->month == '11') {
            $data3 = "十一月";
        } elseif ($this->month == '12') {
            $data3 = "十二月";
        }

        return compact('data', 'data2', 'data3');
    }

    /***
     * 所有教练全年课时费统计
     */
    public function year_income()
    {
        $masters = User::where('is_master', true)->get();
        $data = [];
        $data2 = [];
        foreach ($masters as $key => $value) {
            $year_records = Record::where('user_id', $value->id)->whereYear('created_at', $this->year)->where('status', 1)->get();
            $year_total = 0;
            foreach ($year_records as $k => $v) {
                if ($v->buy_course_id) {
                    $year_total += CourseProperty::where('customer_id', $v->customer_id)->where('course_id', $v->buy_course_id)->value('c_price');
                }
            }

            $data[] = ['value' => $year_total, 'name' => $value->realname];
            $data2[] = $value->realname;
            $data3 = date('Y年', time());;
        }

        return compact('data', 'data2', 'data3');
    }

    public function get_courses()
    {
        $courses = Course::all()->toJson();
        return $courses;
    }

    public function get_tests()
    {
        $tests = DB::table('tests')->orderBy('userCheckTime', 'desc')->get();
        return response()->json($tests);
    }


}
