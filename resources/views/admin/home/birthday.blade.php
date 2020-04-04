@extends('layouts.admin.app')

@section('content')
    <div class="admin-content">
        <div class="admin-content-body">
            <div class="page-header">
                <ol class="am-breadcrumb am-breadcrumb-slash">
                    <li><a href="/admin">首页</a></li>
                    <li class="am-active">会员列表</li>
                </ol>
            </div>

            <div class="page-body">

                <div class="am-g am-g-collapse">
                    <div class="am-u-sm-12">
                        <form class="am-form">
                            <table class="am-table am-table-hover table-main">
                                <thead>
                                <tr>
                                    <th class="table-id">ID</th>
                                    <th class="table-title">会员姓名</th>
                                    <th class="table-type">会员手机</th>
                                    <th class="table-date am-hide-sm-only">会员生日</th>
                                    <th class="table-author am-hide-sm-only">创建日期</th>
                                    <th class="table-set">操作</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($customers as $customer)
                                    <tr>
                                        <td>{{$customer->id}}</td>
                                        <td><a href="JavaScript:;">{{$customer->username}}</a></td>
                                        <td>{{$customer->mobile}}</td>
                                        <td class="am-hide-sm-only">{{$customer->birthday}}</td>
                                        <td class="am-hide-sm-only">{{$customer->created_at}}</td>
                                        <td>
                                            <a href="">发送祝福</a>
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