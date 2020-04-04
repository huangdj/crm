<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseProperty;
use App\Models\Customer;
use App\Models\Record;
use App\User;
use Illuminate\Http\Request;
use Auth;
use Carbon;

class HomeController extends Controller
{
    private $today;
    private $month;
    private $year;

    public function __construct()
    {
        view()->share([
            '_admin' => 'am-active',
        ]);

        $this->today = date('Y-m-d', time()); // 当天日期
        $this->month = date('m', time()); // 当月日期
        $this->year = date('Y', time()); // 当年年份
    }

    /***
     * 后台首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->user()->is_master) {
            $count = [];

            // 今日上课收入
            $today_records = Record::where('user_id', $request->user()->id)->whereDate('created_at', $this->today)->where('status', 1)->get();

            $today_total = 0;
            foreach ($today_records as $k => $v) {
                // 课时费总计--只有购课课程才有课时费，所以只需要计算购课会员的
                if ($v->buy_course_id) {
                    $today_total += CourseProperty::where('course_id', $v->buy_course_id)->where('customer_id', $v->customer_id)->value('c_price');
                }
            }

            // 今日卖课收入
            $customers = Customer::where('user_id', $request->user()->id)->get(); // 先找到当前用户对应的所有会员
            $day_sell = 0;
            foreach ($customers as $key => $value) {
                $buy = CourseProperty::where('customer_id', $value->id)->whereDate('paid_at', $this->today)->get();
                foreach ($buy as $k => $v) {
                    $day_sell += $v->c_price * $v->c_hour;
                }
            }

            // 当月上课收入
            $month_records = Record::where('user_id', $request->user()->id)->whereMonth('created_at', $this->month)->where('status', 1)->get();
            $month_total = 0;
            foreach ($month_records as $k => $v) {
                if ($v->buy_course_id) {
                    $month_total += CourseProperty::where('course_id', $v->buy_course_id)->where('customer_id', $v->customer_id)->value('c_price');
                }
            }

            // 当月卖课收入
            $month_sell = 0;
            foreach ($customers as $key => $value) {
                $buy = CourseProperty::where('customer_id', $value->id)->whereMonth('paid_at', $this->month)->get();
                foreach ($buy as $k => $v) {
                    $month_sell += $v->c_price * $v->c_hour;
                }
            }

            // 全年上课收入
            $year_records = Record::where('user_id', $request->user()->id)->whereNotNull('buy_course_id')->whereYear('created_at', $this->year)->where('status', 1)->get();
            $year_total = 0;
            foreach ($year_records as $k => $v) {
                if ($v->buy_course_id) {
                    $year_total += CourseProperty::where('course_id', $v->buy_course_id)->where('customer_id', $v->customer_id)->value('c_price');
                }
            }

            // 全年卖课收入
            $year_sell = 0;
            foreach ($customers as $key => $value) {
                $buy = CourseProperty::where('customer_id', $value->id)->whereYear('paid_at', $this->year)->get();
                foreach ($buy as $k => $v) {
                    $year_sell += $v->c_price * $v->c_hour;
                }
            }

            // 截止今日，当前教练总收入(办卡用户总额+卖课用户总额+上课提成总额)
            $sell_total = 0;
            $cards_total = Customer::where('user_id', $request->user()->id)->sum('card_price'); // 办卡收入
            foreach ($customers as $value) {
                $buy = CourseProperty::where('customer_id', $value->id)->get();
                foreach ($buy as $k => $v) {
                    $sell_total += $v->c_price * $v->c_hour;  // 卖课收入
                }
            }

            // 上课收入
            $class = Record::where('user_id', $request->user()->id)->whereNotNull('buy_course_id')->where('status', 1)->get();
            $class_total = 0;
            foreach ($class as $k => $v) {
                if ($v->buy_course_id) {
                    $class_total += CourseProperty::where('course_id', $v->buy_course_id)->where('customer_id', $v->customer_id)->value('c_price');
                }
            }
            $amount_total = $cards_total + $sell_total + $class_total;

            $count['today_total'] = number_format($today_total, 2);
            $count['month_total'] = number_format($month_total, 2);
            $count['year_total'] = number_format($year_total, 2);

            $count['day_sell'] = number_format($day_sell, 2);
            $count['month_sell'] = number_format($month_sell, 2);
            $count['year_sell'] = number_format($year_sell, 2);

            $count['amount_total'] = number_format($amount_total, 2);

            return view('admin.home.index', compact('count'));
        } else {
            $users = User::with('customers')->where('is_master', true)->get();
            // 今日生日会员数量
            $today = Carbon\Carbon::today()->format('m-d');
            $birthday_count = Customer::where('birthday', $today)->count();

            // 今日上课收入
            $all_today = Record::whereDate('created_at', $this->today)->where('status', 1)->get();
            $count = [];
            $today_income = 0;
            foreach ($all_today as $k => $v) {
                // 课时费总计
                if ($v->buy_course_id) {
                    $today_income += CourseProperty::where('customer_id', $v->customer_id)->where('course_id', $v->buy_course_id)->value('c_price');
                }
            }

            // 今日卖课收入
            $sell_day_total = 0;
            foreach ($users as $key => $value) {
                foreach ($value->customers as $k => $v) {
                    $sell_courses = CourseProperty::where('customer_id', $v->id)->whereDate('paid_at', $this->today)->get();
                    foreach ($sell_courses as $m => $n) {
                        $sell_day_total += $n->c_hour * $n->c_price;
                    }
                }
            }

            // 当月上课收入
            $all_month = Record::whereMonth('created_at', $this->month)->where('status', 1)->get();
            $month_income = 0;
            foreach ($all_month as $k => $v) {
                // 课时费总计
                if ($v->buy_course_id) {
                    $month_income += CourseProperty::where('customer_id', $v->customer_id)->where('course_id', $v->buy_course_id)->value('c_price');
                }
            }

            // 当月卖课收入
            $sell_month_total = 0;
            foreach ($users as $key => $value) {
                foreach ($value->customers as $k => $v) {
                    $sell_courses = CourseProperty::where('customer_id', $v->id)->whereMonth('paid_at', $this->month)->get();
                    foreach ($sell_courses as $m => $n) {
                        $sell_month_total += $n->c_hour * $n->c_price;
                    }
                }
            }

            // 全年上课收入
            $all_year = Record::whereYear('created_at', $this->year)->where('status', 1)->get();
            $year_income = 0;
            foreach ($all_year as $k => $v) {
                // 课时费总计
                if ($v->buy_course_id) {
                    $year_income += CourseProperty::where('customer_id', $v->customer_id)->where('course_id', $v->buy_course_id)->value('c_price');
                }
            }

            // 全年卖课收入
            $sell_year_total = 0;
            foreach ($users as $key => $value) {
                foreach ($value->customers as $k => $v) {
                    $sell_courses = CourseProperty::where('customer_id', $v->id)->whereYear('paid_at', $this->year)->get();
                    foreach ($sell_courses as $m => $n) {
                        $sell_year_total += $n->c_hour * $n->c_price;
                    }
                }
            }

            // 截止今日，平台总收入(办卡用户总额+购课用户总额)
            $buy_total = 0;
            $cards_total = Customer::sum('card_price');
            $buy_data = CourseProperty::all();
            foreach ($buy_data as $v) {
                $buy_total += $v->c_price * $v->c_hour;
            }
            $amount_total = $cards_total + $buy_total;

            $count['today_income'] = number_format($today_income, 2);
            $count['month_income'] = number_format($month_income, 2);
            $count['year_income'] = number_format($year_income, 2);
            $count['sell_day_total'] = number_format($sell_day_total, 2);
            $count['sell_month_total'] = number_format($sell_month_total, 2);
            $count['sell_year_total'] = number_format($sell_year_total, 2);
            $count['amount_total'] = number_format($amount_total, 2);
            return view('admin.home.index', compact('birthday_count', 'count'));
        }
    }

    /***
     * 教练后台--今日上课明细
     */
    public function today_detail(Request $request)
    {
        $today_records = Record::with('customer', 'course')->whereNotNull('buy_course_id')->where('user_id', $request->user()->id)->whereDate('created_at', $this->today)->where('status', 1)->orderBy('created_at', 'desc')->paginate(env('pageSize'));
        foreach ($today_records as $k => $v) {
            $today_records[$k]['today_price'] = CourseProperty::where('customer_id', $v->customer_id)->where('course_id', $v->buy_course_id)->first();
        }
        return view('admin.home.today_detail', compact('today_records'));
    }

    /***
     * 教练后台--今日卖课明细
     */
    public function sell_day_detail(Request $request)
    {
        $user = User::with('customers')->find($request->user()->id);
        $customers = $user->customers;
        foreach ($customers as $key => $value) {
            $customers[$key]['sell_courses'] = CourseProperty::with('customer','course')->where('customer_id', $value->id)->whereDate('paid_at', $this->today)->orderBy('paid_at', 'desc')->get();
        }

        return view('admin.home.sell_day_detail', compact('customers'));
    }


    /***
     * 教练后台--当月上课明细
     */
    public function month_detail(Request $request)
    {
        $month_records = Record::with('customer', 'course')->whereNotNull('buy_course_id')->where('user_id', $request->user()->id)->whereMonth('created_at', $this->month)->where('status', 1)->orderBy('created_at', 'desc')->paginate(env('pageSize'));
        foreach ($month_records as $k => $v) {
            $month_records[$k]['today_price'] = CourseProperty::where('customer_id', $v->customer_id)->where('course_id', $v->buy_course_id)->first();
        }
        return view('admin.home.month_detail', compact('month_records'));
    }


    /***
     * 教练后台--当月卖课明细
     */
    public function sell_mon_detail(Request $request)
    {
        $user = User::with('customers')->find($request->user()->id);
        $customers = $user->customers;
        foreach ($customers as $key => $value) {
            $customers[$key]['sell_courses'] = CourseProperty::with('customer','course')->where('customer_id', $value->id)->whereMonth('paid_at', $this->month)->orderBy('paid_at', 'desc')->get();
        }

        return view('admin.home.sell_mon_detail', compact('customers'));
    }


    /***
     * 教练后台--全年上课明细
     */
    public function year_detail(Request $request)
    {
        $year_records = Record::with('customer', 'course')->whereNotNull('buy_course_id')->where('user_id', $request->user()->id)->whereYear('created_at', $this->year)->where('status', 1)->orderBy('created_at', 'desc')->paginate(env('pageSize'));
        foreach ($year_records as $k => $v) {
            $year_records[$k]['today_price'] = CourseProperty::where('customer_id', $v->customer_id)->where('course_id', $v->buy_course_id)->first();
        }
        return view('admin.home.year_detail', compact('year_records'));
    }

    /***
     * 教练后台--当月卖课明细
     */
    public function sell_yea_detail(Request $request)
    {
        $user = User::with('customers')->find($request->user()->id);
        $customers = $user->customers;
        foreach ($customers as $key => $value) {
            $customers[$key]['sell_courses'] = CourseProperty::with('customer','course')->where('customer_id', $value->id)->whereYear('paid_at', $this->year)->orderBy('paid_at', 'desc')->get();
        }

        return view('admin.home.sell_yea_detail', compact('customers'));
    }

    /***
     * 当天生日会员
     */
    public function birthday()
    {
        $today = Carbon\Carbon::today()->format('m-d');
        $customers = Customer::where('birthday', $today)->paginate(env('pageSize'));
        return view('admin.home.birthday', compact('customers'));
    }

    /***
     * 管理员后台--今日上课收入明细
     */
    public function all_today_detail()
    {
        $all_today_records = Record::with('user', 'customer', 'course')->whereNotNull('buy_course_id')->whereDate('created_at', $this->today)->where('status', 1)->orderBy('created_at', 'desc')->paginate(env('pageSize'));
        foreach ($all_today_records as $k => $v) {
            $all_today_records[$k]['today_price'] = CourseProperty::where('customer_id', $v->customer_id)->where('course_id', $v->buy_course_id)->first();
        }
        return view('admin.home.all_today_detail', compact('all_today_records'));
    }

    /***
     * 管理员后台--今日卖课明细
     */
    public function sell_today_detail()
    {
        $sell_today_records = CourseProperty::with('course')->whereDate('paid_at', $this->today)->orderBy('paid_at', 'desc')->paginate(env('pageSize'));
        foreach ($sell_today_records as $key => $value) {
            $sell_today_records[$key]['customer'] = Customer::with('user')->where('id', $value->customer_id)->first();
        }
        return view('admin.home.sell_today_detail', compact('sell_today_records'));
    }

    /***
     * 管理员后台--当月上课收入明细
     */
    public function all_month_detail()
    {
        $all_month_records = Record::with('user', 'customer', 'course')->whereNotNull('buy_course_id')->whereMonth('created_at', $this->month)->where('status', 1)->orderBy('created_at', 'desc')->paginate(env('pageSize'));
        foreach ($all_month_records as $k => $v) {
            $all_month_records[$k]['today_price'] = CourseProperty::where('customer_id', $v->customer_id)->where('course_id', $v->buy_course_id)->first();
        }

        return view('admin.home.all_month_detail', compact('all_month_records'));
    }

    /***
     * 管理员后台--当月卖课明细
     */
    public function sell_month_detail()
    {
        $sell_month_records = CourseProperty::with('course')->whereMonth('paid_at', $this->month)->orderBy('paid_at', 'desc')->paginate(env('pageSize'));
        foreach ($sell_month_records as $key => $value) {
            $sell_month_records[$key]['customer'] = Customer::with('user')->where('id', $value->customer_id)->first();
        }
        return view('admin.home.sell_month_detail', compact('sell_month_records'));
    }


    /***
     * 管理员后台--全年上课收入明细
     */
    public function all_year_detail()
    {
        $all_year_records = Record::with('user', 'customer', 'course', 'hour')->whereNotNull('buy_course_id')->whereYear('created_at', $this->year)->where('status', 1)->orderBy('created_at', 'desc')->paginate(env('pageSize'));
        foreach ($all_year_records as $k => $v) {
            $all_year_records[$k]['today_price'] = CourseProperty::where('customer_id', $v->customer_id)->where('course_id', $v->buy_course_id)->first();
        }
        return view('admin.home.all_year_detail', compact('all_year_records'));
    }

    /***
     * 管理员后台--全年卖课明细
     */
    public function sell_year_detail()
    {
        $sell_year_records = CourseProperty::with('course')->whereYear('paid_at', $this->year)->orderBy('paid_at', 'desc')->paginate(env('pageSize'));
        foreach ($sell_year_records as $key => $value) {
            $sell_year_records[$key]['customer'] = Customer::with('user')->where('id', $value->customer_id)->first();
        }
        return view('admin.home.sell_year_detail', compact('sell_year_records'));
    }

    /***
     * 账户设置
     */
    public function profile()
    {
        return view('admin.home.profile');
    }

    /***
     * 修改账户
     */
    public function update_profile(Request $request)
    {
        $user = Auth::user();

        if (!\Hash::check($request->oldpassword, $user->password)) {
            return back()->with('error', '原始密码输入错误~');
        }

        if ($request->password == '') {
            return back()->with('error', '请输入新密码~');
        }

        if ($request->password != $request->newpassword) {
            return back()->with('error', '两次新密码输入不一致~');
        }

        $user->name = $request->name;
        $user->password = bcrypt($request->input('password'));
        $user->save();
        $request->session()->invalidate(); //修改密码后，清除session，退到登录页面

        return redirect(route('login'))->with('success', '您已成功修改密码,请重新登录~');
    }
}
