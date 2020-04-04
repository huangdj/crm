@extends('layouts.admin.app')

@section('content')
    <div class="admin-content">
        <div class="admin-content-body">
            <div class="page-header">
                <ol class="am-breadcrumb am-breadcrumb-slash">
                    <li><a href="/admin/courses">课程管理</a></li>
                    <li class="am-active">课时列表</li>
                </ol>
            </div>

            <div class="page-body">

                <div class="am-g">
                    <div class="am-u-sm-12">
                        <div class="am-btn-toolbar">
                            <div class="">
                                <button type="button"
                                        onclick="location.href='/admin/courses/{{$course->id}}/hours/create'"
                                        class="am-btn am-btn-primary"><span class="am-icon-plus"></span>
                                    新增课时
                                </button>
                                <button type="button" onclick="location.href='/admin/courses'"
                                        class="am-btn am-btn-default">
                                    <span class="am-icon-share-square-o"></span> 返回课程列表
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
                                    <th class="table-id">ID</th>
                                    <th class="table-title">课时名称</th>
                                    <th class="table-type">单价(元)</th>
                                    <th class="table-date am-hide-sm-only">购买量</th>
                                    <th class="table-set">操作</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($hours as $hour)
                                    <tr>
                                        <td>{{$hour->id}}</td>
                                        <td><a href="JavaScript:;">{{$hour->c_name}}</a></td>
                                        <td>{{$hour->price}}</td>
                                        <td class="am-hide-sm-only">{{$hour->buy_num}}</td>
                                        <td>
                                            <a href="/admin/courses/{{$course->id}}/hours/edit/{{$hour->id}}">编辑</a>
                                            <div class="divider divider-vertical"></div>
                                            <a href="{{ route('admin.hours.destroy', $hour->id) }}"
                                               data-method="delete" data-token="{{csrf_token()}}"
                                               data-confirm="是否确定要删除?">删除</a>
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