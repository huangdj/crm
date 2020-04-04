@extends('layouts.admin.app')

@section('content')
    <div class="admin-content">
        <div class="admin-content-body">
            <div class="page-header">
                <ol class="am-breadcrumb am-breadcrumb-slash">
                    <li><a href="{{ route('admin.checkout.index') }}">工资管理</a></li>
                    <li class="am-active">工资结算</li>
                </ol>
            </div>

            <div class="page-body">

                @include('layouts.shared._flash')

                <form class="am-form am-form-horizontal" method="post" action="{{ route('admin.checkout.store') }}">
                    @csrf

                    <div class="am-form-group">
                        <label for="name" class="am-u-sm-12 am-u-md-3 am-form-label">教练姓名</label>
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
                        <label for="name" class="am-u-sm-12 am-u-md-3 am-form-label">基本工资</label>
                        <div class="am-u-sm-12 am-u-md-5 am-u-end">
                            <input type="text" name="base_salary" placeholder="输入基本工资" value="{{ old('base_salary') }}">
                        </div>

                        <div class="am-u-sm-12 am-u-md-3 am-u-end">
                            <a href="javascript:;" data-am-modal="{target: '#base_salary'}">查看</a>
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="name" class="am-u-sm-12 am-u-md-3 am-form-label">业务提成</label>
                        <div class="am-u-sm-12 am-u-md-5 am-u-end">
                            <input type="text" name="percent" placeholder="输入业务提成" value="{{ old('percent') }}">
                        </div>
                        <div class="am-u-sm-12 am-u-md-3 am-u-end">
                            <a href="javascript:;" data-am-modal="{target: '#percent'}">查看</a>
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="name" class="am-u-sm-12 am-u-md-3 am-form-label">总课时费(本月)</label>
                        <div class="am-u-sm-12 am-u-md-5 am-u-end">
                            <input type="text" name="total_hours" placeholder="总课时费(本月)"
                                   value="{{ old('total_hours') }}">
                        </div>

                        <div class="am-u-sm-12 am-u-md-3 am-u-end">
                            <a href="javascript:;" data-am-modal="{target: '#total_hours'}">查看</a>
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="name" class="am-u-sm-12 am-u-md-3 am-form-label">实发金额</label>
                        <div class="am-u-sm-12 am-u-md-5 am-u-end">
                            <input type="text" name="amount" placeholder="输入实发金额" value="{{ old('amount') }}">
                        </div>
                    </div>

                    <div class="am-form-group">
                        <div class="am-u-sm-12 am-u-md-9 am-u-md-offset-3">
                            <button type="button" onclick="location.href='/admin/checkout'"
                                    class="am-btn am-btn-default am-btn-sm am-radius">返 回
                            </button>
                            <button type="submit"
                                    class="am-btn am-btn-primary am-btn-sm am-radius">保 存
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @include('layouts.shared._footer')
    </div>

    <!--教练基础工资列表-->
    <div class="am-modal am-modal-no-btn" id="base_salary">
        <div class="am-modal-dialog">
            <div class="am-modal-hd">教练基础工资列表
                <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
            </div>

            <div class="am-g am-g-collapse">
                <div class="am-u-sm-12">
                    <form class="am-form">
                        <table class="am-table am-table-hover table-main">
                            <thead>
                            <tr>
                                <th class="table-title" style="text-align: center">工号</th>
                                <th class="table-type" style="text-align: center">真实姓名</th>
                                <th class="table-date am-hide-sm-only" style="text-align: center">基础工资</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{$user->master_no}}</td>
                                    <td><a href="JavaScript:;">{{$user->realname}}</a></td>
                                    <td class="am-hide-sm-only" style="color: #f4645f">{{$user->base_salary}}</td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--教练业务提成列表-->
    <div class="am-modal am-modal-no-btn" id="percent">
        <div class="am-modal-dialog">
            <div class="am-modal-hd">教练业务提成列表
                <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
            </div>

            <div class="am-g am-g-collapse">
                <div class="am-u-sm-12">
                    <form class="am-form">
                        <table class="am-table am-table-hover table-main">
                            <thead>
                            <tr>
                                <th class="table-title" style="text-align: center">工号</th>
                                <th class="table-type" style="text-align: center">真实姓名</th>
                                <th class="table-date am-hide-sm-only" style="text-align: center">业务提成</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{$user->master_no}}</td>
                                    <td><a href="JavaScript:;">{{$user->realname}}</a></td>
                                    <td class="am-hide-sm-only" style="color: #f4645f">{{$user->percent}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
