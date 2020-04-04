@extends('layouts.admin.app')

@section('content')
    <div class="admin-content">
        <div class="admin-content-body">
            <div class="page-header">
                <ol class="am-breadcrumb am-breadcrumb-slash">
                    <li><a href="/admin/courses">课程列表</a></li>
                    <li class="am-active">编辑课程</li>
                </ol>
            </div>

            <div class="page-body">

                @include('layouts.shared._flash')

                <form class="am-form am-form-horizontal" method="post" action="{{ route('admin.courses.update', $course->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="am-form-group">
                        <label for="name" class="am-u-sm-12 am-u-md-3 am-form-label">课程名称</label>
                        <div class="am-u-sm-12 am-u-md-5 am-u-end">
                            <input type="text" name="name" placeholder="输入课程名称" value="{{ $course->name }}">
                        </div>
                    </div>

                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-12 am-u-md-3 am-form-label">
                            缩略图
                        </div>

                        <div class="am-u-sm-12 am-u-md-5 am-u-end">
                            <div class="am-form-group am-form-file">
                                <button type="button" class="am-btn am-btn-success am-btn-sm">
                                    <i class="am-icon-cloud-upload" id="loading"></i> 上传缩略图
                                </button>
                                {{--<span style="margin-left: 50px;color: #f4645f;">请上传宽高：1248 * 488 的图片</span>--}}
                                <input type="file" id="image_upload">
                                <input type="hidden" name="image">
                            </div>

                            <hr data-am-widget="divider" style="" class="am-divider am-divider-dashed am-no-layout">

                            <div>
                                <img src="{{ $course->image }}" id="img_show" style="max-height: 80px;margin-bottom: 10px;">
                            </div>
                        </div>
                    </div>

                    <div class="am-form-group">
                        <div class="am-u-sm-12 am-u-md-9 am-u-md-offset-3">
                            <button type="button" onclick="location.href='/admin/courses'"
                                    class="am-btn am-btn-default am-btn-sm am-radius">返 回
                            </button>
                            <button type="submit" class="am-btn am-btn-primary am-btn-sm am-radius">保 存
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @include('layouts.shared._footer')
    </div>
@stop

@section('js')
    <script src="/vendor/html5-fileupload/jquery.html5-fileupload.js"></script>
    <script src="/js/upload.js"></script>
@endsection
