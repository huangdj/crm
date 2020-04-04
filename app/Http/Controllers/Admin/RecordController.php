<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Record;
use App\Models\CourseProperty;

class RecordController extends Controller
{
    public function __construct()
    {
        view()->share([
            '_record' => 'am-active',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $records = Record::with('customer', 'course', 'relation_course')->where('user_id', $request->user()->id)->orderBy('status')->orderBy('created_at', 'desc')->paginate(env('pageSize'));
        foreach ($records as $k => $v) {
            if ($v->buy_course_id) {
                // 当前购课课程单价
                $records[$k]['hour_price'] = CourseProperty::where('customer_id', $v->customer_id)->where('course_id', $v->buy_course_id)->value('c_price');
            }
        }
        return view('admin.record.index', compact('records'));
    }

    /***
     * 确认上课
     * @param Request $request
     */
    public function makeSure(Request $request)
    {
        $record = Record::find($request->id);
        $record->status = !$record->status;
        $record->surplus_hour = ($record->surplus_hour - 1);
        $record->save();
        return response()->json(['status' => 1, 'msg' => '上课成功']);
    }

}
