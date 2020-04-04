<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Advert;
use App\User;
use Illuminate\Http\Request;
use App\Models\CourseProperty;
use App\Models\RelationProperty;
use App\Models\Record;

class HomeController extends Controller
{
    private $today;

    public function __construct()
    {
        $this->today = date('Y-m-d', time()); // 当天日期
    }

    /***
     * 会员首页
     * 当前台会员登录成功后，跳转到此页面
     * 查出当前会员购买和赠送的所有课程
     */
    public function index()
    {
        // 获取当前登录的会员
        $customer = auth('customers')->user();

        // 查出所有广告
        $adverts = Advert::all();

        // 查出所有教练
        $users = User::where('is_master', true)->get();
        // 查出当前会员购买的课程
        $buy_records = CourseProperty::with('course')->where('customer_id', auth('customers')->user()->id)->paginate(env('pageSize'));

        // 查出当前会员赠送的课程
        $relation_records = RelationProperty::with('course')->where('customer_id', auth('customers')->user()->id)->paginate(env('pageSize'));

        $records = Record::with('user', 'course', 'relation_course')->where('customer_id', auth('customers')->user()->id)->where('status', 1)->orderBy('created_at', 'desc')->paginate(2);
        foreach ($records as $k => $v) {
            if ($v->buy_course_id) {
                // 当前购课课程单价
                $records[$k]['surplus_price'] = CourseProperty::where('customer_id', $v->customer_id)->where('course_id', $v->buy_course_id)->value('c_price');
            }
        }

        return compact('customer', 'adverts', 'users', 'buy_records', 'relation_records', 'records');
    }

    /***
     * 当前会员的上课记录
     * @param Request $request
     */
    public function record(Request $request)
    {
        $page = $request->page ? $request->page : 1;
        $num = 2;
        $records = Record::with('user', 'course', 'relation_course')->where('customer_id', auth('customers')->user()->id)
            ->where('status', 1)->skip($page)->limit($page, $num)->orderBy('created_at', 'desc')->paginate(2);
        foreach ($records as $k => $v) {
            if ($v->buy_course_id) {
                // 当前购课课程单价
                $records[$k]['surplus_price'] = CourseProperty::where('customer_id', $v->customer_id)->where('course_id', $v->buy_course_id)->value('c_price');
            }
        }
        return $records;
    }

    /***
     * 前台--开始上课接口
     * 每个会员每天每个课程只能上一节课
     * 前端需传 user_id，buy_course_id 或 relation_course_id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function begin(Request $request)
    {
        if (!$request->user_id) {
            return response()->json(['success' => false, 'message' => '请选择教练！']);
        }

        if (!$request->buy_course_id && !$request->relation_course_id) {
            return response()->json(['success' => false, 'message' => '请选择课程！']);
        }

        if ($request->buy_course_id) {
            $result1 = Record::with('course')->where('customer_id', $request->customer_id)->where('buy_course_id', $request->buy_course_id)->whereDate('created_at', $this->today)->first();
            if ($result1) {
                return response()->json(['success' => false, 'message' => '今天已经上过' . $result1->course->name . '啦~']);
            } else {
                $record1 = Record::with('course')->where('customer_id', $request->customer_id)->where('buy_course_id', $request->buy_course_id)->orderBy('created_at', 'desc')->first();
                $res = CourseProperty::where('customer_id', $request->customer_id)->where('course_id', $request->buy_course_id)->first();

                if (!$record1) {
                    Record::create([
                        'user_id' => $request->user_id,
                        'customer_id' => $request->customer_id,
                        'buy_course_id' => $request->buy_course_id,
                        'buy_type_id' => 2,
                        'surplus_hour' => $res['c_hour'],
                    ]);
                    return response()->json(['success' => true, 'message' => '上课信息已提交~']);
                } else {
                    if ($res->c_hour < 0) {
                        return response()->json(['success' => false, 'message' => $record1->course->name . '已上完啦~']);
                    } else {
                        Record::create([
                            'user_id' => $request->user_id,
                            'customer_id' => $request->customer_id,
                            'buy_course_id' => $request->buy_course_id,
                            'buy_type_id' => 2,
                            'surplus_hour' => $record1['surplus_hour'],
                        ]);

                        return response()->json(['success' => true, 'message' => '上课信息已提交~']);
                    }

                }
            }
        } elseif ($request->relation_course_id) {
            $result2 = Record::with('relation_course')->where('customer_id', $request->customer_id)->where('relation_course_id', $request->relation_course_id)->whereDate('created_at', $this->today)->first();
            if ($result2) {
                return response()->json(['success' => false, 'message' => '今天已经上过' . $result2->relation_course->name . '啦~']);
            } else {
                $record2 = Record::with('relation_course')->where('customer_id', $request->customer_id)->where('relation_course_id', $request->relation_course_id)->orderBy('created_at', 'desc')->first();
                $info = RelationProperty::where('customer_id', $request->customer_id)->where('course_id', $request->relation_course_id)->first();
                if (!$record2) {
                    Record::create([
                        'user_id' => $request->user_id,
                        'customer_id' => $request->customer_id,
                        'relation_course_id' => $request->relation_course_id,
                        'relation_type_id' => 3,
                        'surplus_hour' => $info['g_hour'],
                    ]);
                    return response()->json(['success' => true, 'message' => '上课信息已提交~']);

                } else {
                    if ($info->g_hour < 0) {
                        return response()->json(['success' => false, 'message' => $record2->relation_course->name . '已上完啦~']);
                    }
                    Record::create([
                        'user_id' => $request->user_id,
                        'customer_id' => $request->customer_id,
                        'relation_course_id' => $request->relation_course_id,
                        'relation_type_id' => 3,
                        'surplus_hour' => $record2['surplus_hour'],
                    ]);

                    return response()->json(['success' => true, 'message' => '上课信息已提交~']);

                }
            }
        }
    }
}
