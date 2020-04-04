<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Hour;
use Illuminate\Http\Request;
use App\Http\Requests\HourValidate;

class HourController extends Controller
{
    function __construct()
    {
        view()->share(['courses' => Course::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $url = request()->course_id;  // 获取上一层路由参数，用于新增课时页面选中当前课程名称
        return view('admin.hour.create', compact('url'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(HourValidate $request)
    {
        Hour::create($request->only('c_name', 'course_id', 'price'));
        return redirect(route('admin.courses.show', $request->course_id))->with('success', '新增课时成功');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $hour = Hour::find(request()->id);
        return view('admin.hour.edit', compact('hour'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Hour::where('id', $id)->update($request->only('c_name', 'course_id', 'price'));
        return redirect(route('admin.courses.show', $request->course_id))->with('success', '编辑课时成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Hour::destroy($id);
        return back()->with('success', '删除课时成功');
    }
}
