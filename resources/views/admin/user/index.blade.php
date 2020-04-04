@extends('layouts.admin.app')

@section('content')
    <div class="admin-content">
        <div class="admin-content-body">
            <div class="page-header">
                <ol class="am-breadcrumb am-breadcrumb-slash">
                    <li><a href="/admin/users">教练管理</a></li>
                    <li class="am-active">教练列表</li>
                </ol>
            </div>

            <div class="page-body">

                <div class="am-g">
                    <form action="" class="am-form am-form-horizontal">

                        <div class="am-u-sm-12 am-u-md-4">
                            <div class="am-form-group">
                                <label for="title" class="am-u-sm-3 am-form-label">姓名</label>
                                <div class="am-u-sm-9">
                                    <input type="text" name="realname" placeholder="请输入真实姓名">
                                </div>
                            </div>
                        </div>

                        <div class="am-u-sm-12 am-u-md-4">
                            <div class="am-form-group">
                                <label for="username" class="am-u-sm-3 am-form-label">工号</label>
                                <div class="am-u-sm-9">
                                    <input type="text" name="master_no" placeholder="请输入工号">
                                </div>
                            </div>
                        </div>

                        <div class="am-u-sm-12 am-u-md-4">
                            <div class="am-form-group search-buttons">
                                <button class="am-btn am-btn-primary" type="submit">查 询</button>
                                <button class="am-btn am-btn-default" onclick="location.href='/admin/users'"
                                        type="button">重 置
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="am-g">
                    <div class="am-u-sm-12">
                        <div class="am-btn-toolbar">
                            <div class="">
                                <button type="button" onclick="location.href='/admin/users/create'"
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
                                    <th class="table-id">ID</th>
                                    <th class="table-title">工号</th>
                                    <th class="table-type">真实姓名</th>
                                    <th class="table-date am-hide-sm-only">底薪</th>
                                    {{--<th class="table-author am-hide-sm-only">提成/月</th>--}}
                                    <th class="table-author am-hide-sm-only">登录账号</th>
                                    <th class="table-author am-hide-sm-only">状态</th>
                                    <th class="table-author am-hide-sm-only">入职日期</th>
                                    <th class="table-set">操作</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($users as $user)
                                    <tr data-id="{{$user->id}}">
                                        <td><input type="checkbox" value="{{$user->id}}" class="checked_id"
                                                   name="checked_id[]"/></td>
                                        <td>{{$user->id}}</td>
                                        <td><a href="JavaScript:;">{{$user->master_no}}</a></td>
                                        <td>{{$user->realname}}</td>
                                        <td class="am-hide-sm-only">{{$user->base_salary}}</td>
                                        {{--<td class="am-hide-sm-only">{{$user->percent}}</td>--}}
                                        <td class="am-hide-sm-only">{{$user->name}}</td>
                                        <td class="am-hide-sm-only">
                                            @if($user->is_job)
                                                <a href="javascript:;">在职</a>
                                            @else
                                                <a href="javascript:;" style="color: #b91d19">离职</a>
                                            @endif
                                        </td>
                                        <td class="am-hide-sm-only">{{$user->created_at->format('Y年m月d日')}}</td>
                                        <td>
                                            <a href="{{ route('admin.users.edit', $user->id) }}">编辑</a>
                                            <div class="divider divider-vertical"></div>
                                            @if($user->is_job)
                                                <a href="javascript:;" class="dismiss">解雇</a>
                                            @else
                                                <a href="javascript:;" class="res_dismiss">复职</a>
                                            @endif
                                            <div class="divider divider-vertical"></div>
                                            <a href="{{ route('admin.users.kpi', $user->id) }}">KPI设置</a>
                                            <div class="divider divider-vertical"></div>
                                            <a href="{{ route('admin.users.show', $user->id) }}">工资结算</a>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                            <div class="am-cf">
                                共 {{$users->total()}} 条记录
                                <div class="am-fr">
                                    {!! $users->appends(Request::all())->links() !!}
                                </div>
                            </div>
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
                if (confirm('此操作不可恢复，请慎重！')) {
                    var checked_id = $('.checked_id:checked').serialize();
                    $.ajax({
                        type: 'DELETE',
                        url: "{{route('admin.users.destroy_checked')}}",
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

            // 解雇
            $('.dismiss').click(function () {
                if (confirm('是否确定要解雇该教练？')) {
                    var id = $(this).parents('tr').data('id');
                    $.ajax({
                        type: 'PATCH',
                        url: "{{ route('admin.users.dismiss') }}",
                        data: {id: id, is_job: 1},
                        success: function (data) {
                            if (data.status == 1) {
                                alert(data.msg);
                                window.location.reload();
                            }
                        }
                    })
                }
            })

            // 复职
            $('.res_dismiss').click(function () {
                if (confirm('是否确定要恢复该教练职位？')) {
                    var id = $(this).parents('tr').data('id');
                    $.ajax({
                        type: 'PATCH',
                        url: "{{ route('admin.users.res_dismiss') }}",
                        data: {id: id, is_job: 0},
                        success: function (data) {
                            if (data.status == 1) {
                                alert(data.msg);
                                window.location.reload();
                            }
                        }
                    })
                }
            })
        })
    </script>
@endsection