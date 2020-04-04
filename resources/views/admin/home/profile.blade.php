@extends('layouts.admin.app')

@section('content')
    <div class="admin-content">
        <div class="admin-content-body">
            <div class="page-header">
                <ol class="am-breadcrumb am-breadcrumb-slash">
                    <li><a href="/admin">首页</a></li>
                    <li class="am-active">账户设置</li>
                </ol>
            </div>

            <div class="page-body">
                <div class="am-g">
                    <div class="am-u-sm-12 am-u-md-4 am-u-md-push-8"></div>

                    <div class="am-u-sm-12 am-u-md-8 am-u-md-pull-4">
                        <form class="am-form am-form-horizontal" action="{{ route('admin.update_profile') }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="am-form-group">
                                <label for="user-name" class="am-u-sm-3 am-form-label">用户名</label>
                                <div class="am-u-sm-9">
                                    <input type="text" name="name" value="{{ Auth::user()->name }}">
                                </div>
                            </div>

                            <div class="am-form-group">
                                <label for="user-QQ" class="am-u-sm-3 am-form-label">原始密码</label>
                                <div class="am-u-sm-9">
                                    <input type="password" name="oldpassword" placeholder="输入你的原始密码">
                                </div>
                            </div>

                            <div class="am-form-group">
                                <label for="user-QQ" class="am-u-sm-3 am-form-label">新密码</label>
                                <div class="am-u-sm-9">
                                    <input type="password" name="password" placeholder="输入你的新密码">
                                </div>
                            </div>

                            <div class="am-form-group">
                                <label for="user-QQ" class="am-u-sm-3 am-form-label">确认新密码</label>
                                <div class="am-u-sm-9">
                                    <input type="password" name="newpassword" placeholder="再次输入你的新密码">
                                </div>
                            </div>

                            <div class="am-form-group">
                                <div class="am-u-sm-9 am-u-sm-push-3">
                                    <button type="submit" class="am-btn am-btn-primary">保存修改</button>
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