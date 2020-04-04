@extends('layouts.admin.app')

@section('content')
    <div class="admin-content">
        <div class="admin-content-body">
            <div class="page-header">
                <ol class="am-breadcrumb am-breadcrumb-slash">
                    <li><a href="{{ route('admin.customers.index') }}">会员管理</a></li>
                    <li class="am-active">录入会员</li>
                </ol>
            </div>

            <div class="page-body">

                @include('layouts.shared._flash')

                <form class="am-form am-form-horizontal" method="post" action="{{ route('admin.customers.store') }}">
                    @csrf

                    <div class="am-form-group">
                        <label for="name" class="am-u-sm-12 am-u-md-3 am-form-label">会员姓名</label>
                        <div class="am-u-sm-12 am-u-md-5 am-u-end">
                            <input type="text" name="username" placeholder="输入会员姓名" value="{{ old('username') }}">
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="name" class="am-u-sm-12 am-u-md-3 am-form-label">分配教练</label>
                        <div class="am-u-sm-12 am-u-md-5 am-u-end">
                            <select data-am-selected="{btnWidth: '100%', btnSize: 'sm', maxHeight: 360}" name="user_id">
                                <option value="">请选择</option>
                                @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->realname}}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="name" class="am-u-sm-12 am-u-md-3 am-form-label">手机号</label>
                        <div class="am-u-sm-12 am-u-md-5 am-u-end">
                            <input type="text" name="mobile" placeholder="输入手机号" value="{{ old('mobile') }}">
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="name" class="am-u-sm-12 am-u-md-3 am-form-label">生日</label>
                        <div class="am-u-sm-12 am-u-md-5 am-u-end">
                            <input type="text" name="birthday" placeholder="如：02-03" value="{{ old('birthday') }}">
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="name" class="am-u-sm-12 am-u-md-3 am-form-label">密码</label>
                        <div class="am-u-sm-12 am-u-md-5 am-u-end">
                            <input type="text" placeholder="默认：123456" readonly>
                            <input type="hidden" name="password" value="123456">
                        </div>
                    </div>

                    <div class="am-form-group">
                        <div class="am-u-sm-12 am-u-md-9 am-u-md-offset-3">
                            <button type="button" onclick="location.href='/admin/customers'"
                                    class="am-btn am-btn-default am-btn-sm am-radius">返 回
                            </button>
                            <button type="submit" class="am-btn am-btn-primary am-btn-sm am-radius">保 存</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @include('layouts.shared._footer')
    </div>
@stop