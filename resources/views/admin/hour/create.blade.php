@extends('layouts.admin.app')

@section('content')
    <div class="admin-content">
        <div class="admin-content-body">
            <div class="page-header">
                <ol class="am-breadcrumb am-breadcrumb-slash">
                    <li><a href="/admin/courses/{{$url}}">课时列表</a></li>
                    <li class="am-active">新增课时</li>
                </ol>
            </div>

            <div class="page-body">

                @include('layouts.shared._flash')

                <form class="am-form am-form-horizontal" method="post" action="{{ route('admin.hours.store') }}">
                    @csrf

                    <div class="am-form-group">
                        <label for="name" class="am-u-sm-12 am-u-md-3 am-form-label">所属课程</label>
                        <div class="am-u-sm-12 am-u-md-5 am-u-end">
                            <select data-am-selected="{btnWidth: '100%', btnSize: 'sm', maxHeight: 360, searchBox: 1}"
                                    name="course_id" style="display: none;">

                                @foreach($courses as $course)
                                    <option value="{{$course->id}}"
                                            @if($course->id == $url) selected @endif>{{$course->name}}</option>
                                @endforeach

                            </select>
                        </div>

                        <div class="am-u-sm-12 am-u-md-4 am-u-end">
                            <p style="color: #f4645f"> * 默认已选中当前课程</p>
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="name" class="am-u-sm-12 am-u-md-3 am-form-label">课时名称</label>
                        <div class="am-u-sm-12 am-u-md-5 am-u-end">
                            <input type="text" name="c_name" placeholder="输入课时名称" value="{{ old('c_name') }}">
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="name" class="am-u-sm-12 am-u-md-3 am-form-label">课时单价</label>
                        <div class="am-u-sm-12 am-u-md-5 am-u-end">
                            <input type="text" name="price" placeholder="输入课时单价" value="{{ old('price') }}">
                        </div>
                    </div>

                    <div class="am-form-group">
                        <div class="am-u-sm-12 am-u-md-9 am-u-md-offset-3">
                            <button type="button" onclick="javascript :history.back(-1);"
                                    class="am-btn am-btn-default am-btn-sm am-radius">返 回
                            </button>
                            <button type="submit" onclick="location.href='/admin/hours'"
                                    class="am-btn am-btn-primary am-btn-sm am-radius">保 存
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @include('layouts.shared._footer')
    </div>
@stop
