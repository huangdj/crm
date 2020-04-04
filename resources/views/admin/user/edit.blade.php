@extends('layouts.admin.app')

@section('content')
    <div class="admin-content">
        <div class="admin-content-body">
            <div class="page-header">
                <ol class="am-breadcrumb am-breadcrumb-slash">
                    <li><a href="{{ route('admin.users.index') }}">教练管理</a></li>
                    <li>编辑教练</li>
                </ol>
            </div>

            <div class="page-body">

                @include('layouts.shared._flash')

                <form class="am-form am-form-horizontal" method="post"
                      action="{{ route('admin.users.update', $user->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="am-form-group">
                        <label for="name" class="am-u-sm-12 am-u-md-3 am-form-label">教练工号</label>
                        <div class="am-u-sm-12 am-u-md-5 am-u-end">
                            <input type="text" name="master_no" value="{{ $user->master_no }}">
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="name" class="am-u-sm-12 am-u-md-3 am-form-label">真实姓名</label>
                        <div class="am-u-sm-12 am-u-md-5 am-u-end">
                            <input type="text" name="realname" value="{{ $user->realname }}">
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="name" class="am-u-sm-12 am-u-md-3 am-form-label">每月底薪</label>
                        <div class="am-u-sm-12 am-u-md-5 am-u-end">
                            <input type="text" name="base_salary" value="{{ $user->base_salary }}">
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="name" class="am-u-sm-12 am-u-md-3 am-form-label">业务指标</label>
                        <div class="am-u-sm-12 am-u-md-5 am-u-end">
                            <input type="text" name="task" value="{{ $user->task }}">
                        </div>
                    </div>

                    <div class="am-form-group">
                        <div class="am-u-sm-12 am-u-md-9 am-u-md-offset-3">
                            <button type="button" onclick="location.href='/admin/users'"
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
