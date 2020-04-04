@extends('layouts.admin.app')

@section('content')
    <div class="admin-content">
        <div class="admin-content-body">
            <div class="page-header">
                <ol class="am-breadcrumb am-breadcrumb-slash">
                    <li><a href="/admin/customers">会员管理</a></li>
                    <li class="am-active">会员列表</li>
                </ol>
            </div>

            <div class="page-body">

                <div class="am-g">
                    <form action="" class="am-form am-form-horizontal">

                        <div class="am-u-sm-12 am-u-md-4">
                            <div class="am-form-group">
                                <label for="title" class="am-u-sm-3 am-form-label">按手机号</label>
                                <div class="am-u-sm-9">
                                    <input type="text" name="mobile" placeholder="请输入手机号"
                                           value="{{Request::input('mobile')}}">
                                </div>
                            </div>
                        </div>

                        <div class="am-u-sm-12 am-u-md-4">
                            <div class="am-form-group">
                                <label for="name" class=" am-u-md-3 am-form-label">按教练名</label>
                                <div class="am-u-sm-9">
                                    <select data-am-selected="{btnWidth: '100%', btnSize: 'sm', maxHeight: 360, searchBox: 1}"
                                            name="user_id" style="display: none;">
                                        <option value="-1">所有教练</option>
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}"
                                                    @if($user->id == Request::input('user_id')) selected @endif>{{$user->realname}}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="am-u-sm-12 am-u-md-4">
                            <div class="am-form-group search-buttons">
                                <button class="am-btn am-btn-primary" type="submit">查 询</button>
                                <button class="am-btn am-btn-default" type="button"
                                        onclick="location.href='/admin/customers'">重 置
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="am-g">
                    <div class="am-u-sm-12">
                        <div class="am-btn-toolbar">
                            <div class="">
                                <button type="button" onclick="location.href='/admin/customers/create'"
                                        class="am-btn am-btn-primary"><span class="am-icon-plus"></span>
                                    录入会员
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
                                    <th class="table-title">会员姓名</th>
                                    <th class="table-title">所属教练</th>
                                    <th class="table-type">会员手机号</th>
                                    <th class="table-date am-hide-sm-only">生日</th>
                                    <th class="table-date am-hide-sm-only">会员类型</th>
                                    <th class="table-author am-hide-sm-only">创建日期</th>
                                    <th class="table-set">操作</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($customers as $customer)
                                    <tr>
                                        <td>{{$customer->id}}</td>
                                        <td><a href="JavaScript:;">{{$customer->username}}</a></td>
                                        <td>
                                            @if($customer->user)
                                                <a href="JavaScript:;">{{$customer->user->realname}}</a>
                                            @else
                                                <a href="JavaScript:;">暂无</a>
                                            @endif
                                        </td>
                                        <td>{{$customer->mobile}}</td>
                                        <td class="am-hide-sm-only">{{$customer->birthday}}</td>
                                        @if($customer->types->isEmpty())
                                            <td class="am-hide-sm-only">暂无类型</td>
                                        @else
                                            <td class="am-hide-sm-only">{{ $customer->types->implode('type_name', ', ') }}</td>
                                        @endif

                                        <td class="am-hide-sm-only">{{$customer->created_at->format('Y年m月d日')}}</td>
                                        <td>
                                            <a href="{{ route('admin.customers.edit', $customer->id) }}">办卡</a>
                                            <div class="divider divider-vertical"></div>
                                            <a href="{{ route('admin.customers.buy', $customer->id) }}">购课</a>
                                            <div class="divider divider-vertical"></div>
                                            <a href="{{ route('admin.customers.relation', $customer->id) }}">赠课</a>
                                            <div class="divider divider-vertical"></div>
                                            <a href="{{ route('admin.customers.show', $customer->id) }}">详情</a>
                                            @if(!Auth::user()->is_master)
                                                <div class="divider divider-vertical"></div>
                                                <a href="{{ route('admin.customers.destroy', $customer->id) }}"
                                                   data-method="delete" data-token="{{csrf_token()}}"
                                                   data-confirm="此操作不可恢复，请慎重！">删除</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                            <div class="am-cf">
                                共 {{$customers->total()}} 条记录
                                <div class="am-fr">
                                    {!! $customers->appends(Request::all())->links() !!}
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