<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Hour;
use Illuminate\Http\Request;
use App\Http\Requests\CourseValidate;

class CourseController extends Controller
{
    public function __construct()
    {
        view()->share(['_course' => 'am-active']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::all_courses();
        return view('admin.course.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.course.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseValidate $request)
    {
        Course::create($request->only('name', 'image'));
        return redirect()->to('/admin/courses')->with('success', '新增课程成功');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $course = Course::find($id);
        $hours = Hour::where('course_id', $id)->get();
        return view('admin.hour.index', compact('hours', 'course'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $course = Course::find($id);
        return view('admin.course.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(CourseValidate $request, $id)
    {
        Course::where('id', $id)->update($request->only('name', 'image'));
        return redirect()->to('/admin/courses')->with('success', '编辑课程成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Course::destroy($id);
        return back()->with('success', '删除课程成功');
    }

    /***
     * 多选删除
     * @param Request $request
     */
    public function destroy_checked(Request $request)
    {
        Course::destroy($request->checked_id);
        \DB::table('hours')->whereIn('course_id',$request->checked_id)->delete();
        return response()->json(['status' => 1, 'msg' => '删除课程成功']);
    }
}
