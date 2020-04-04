@extends('layouts.admin.app')

@section('content')
    <div class="admin-content">
        <div class="admin-content-body">
            <div class="page-header">
                <ol class="am-breadcrumb am-breadcrumb-slash">
                    <li><a href="/admin/courses">课程管理</a></li>
                    <li class="am-active">课程列表</li>
                </ol>
            </div>

            <div class="page-body">

                <div class="am-g">
                    <div class="am-u-sm-12">
                        <div class="am-btn-toolbar">
                            <div class="">
                                <button type="button" onclick="location.href='/admin/courses/create'"
                                        class="am-btn am-btn-primary"><span class="am-icon-plus"></span>
                                    新增
                                </button>
                                <button type="button" class="am-btn am-btn-default" id="destroy_checked">
                                    <span class="am-icon-trash-o"></span> 删除
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="am-g am-g-collapse">
                    <div class="am-u-sm-12">
                        <form class="am-form">
                            <table class="am-table am-table-hover table-main">
                                <thead>
                                <tr>
                                    <th class="table-check"><input type="checkbox" id="checked"/></th>
                                    <th class="table-title">ID</th>
                                    <th class="table-title">课程名称</th>
                                    <th class="table-title">缩略图</th>
                                    {{--<th class="table-type">总价格(元)</th>--}}
                                    {{--<th class="table-date am-hide-sm-only">总课时(节)</th>--}}
                                    <th class="table-set">操作</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($courses as $course)
                                    <tr>
                                        <td><input type="checkbox" value="{{$course->id}}" class="checked_id"
                                                   name="checked_id[]"/></td>
                                        <td>{{$course->id}}</td>
                                        <td><a href="JavaScript:;">{{$course->name}}</a></td>
                                        <td><img src="{{$course->image}}" alt="" class="thumb"></td>
                                        {{--<td>{{$course->hour_price}}</td>--}}
                                        {{--<td class="am-hide-sm-only">{{$course->hour_count}}</td>--}}
                                        <td>
                                            <a href="{{ route('admin.courses.edit', $course->id) }}">编辑</a>
                                            <div class="divider divider-vertical"></div>
                                            <a href="{{ route('admin.courses.destroy', $course->id) }}"
                                               data-method="delete" data-token="{{csrf_token()}}"
                                               data-confirm="是否确定要删除?">删除</a>
                                            {{--<div class="divider divider-vertical"></div>--}}
                                            {{--<a href="{{ route('admin.courses.show', $course->id) }}">课时</a>--}}
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.shared._footer')

    </div>

    @include('layouts.shared._flash')
@stop

@section('js')
    <script>
        $(function () {
            // 全选、反选
            $("#checked").click(function () {
                $(':checkbox').prop("checked", this.checked);
            })

            // 多选删除
            $("#destroy_checked").click(function () {
                var length = $('.checked_id:checked').length;
                if (length == 0) {
                    alert('您至少要选中一条数据');
                    return false;
                }
                if (confirm('此操作将删除对应课时，请慎重！')) {
                    var checked_id = $('.checked_id:checked').serialize();
                    $.ajax({
                        type: 'DELETE',
                        url: "{{route('admin.courses.destroy_checked')}}",
                        data: checked_id,
                        success: function (data) {
                            if (data.status == 1) {
                                alert(data.msg);
                                $('.checked_id:checked').each(function () {
                                    $(this).parents('tr').remove();
                                })
                            }
                        }
                    })
                }
            })
        })
    </script>
@endsection