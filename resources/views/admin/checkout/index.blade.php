@extends('layouts.admin.app')

@section('content')
    <div class="admin-content">
        <div class="admin-content-body">
            <div class="page-header">
                <ol class="am-breadcrumb am-breadcrumb-slash">
                    <li><a href="/admin/checkout">工资结算</a></li>
                    <li class="am-active">结算记录</li>
                </ol>
            </div>

            <div class="page-body">

                @if(!$checkouts->isEmpty())
                    <div class="am-g">
                        <div class="am-u-sm-12">
                            <div class="am-btn-toolbar">
                                <div class="">
                                    <button type="button"
                                            onclick="if(confirm('是否确定导出工资条？')) location.href='/admin/checkout/export';else return false;"
                                            class="am-btn am-btn-primary"><span class="am-icon-download"></span>
                                        导出工资
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="am-g am-g-collapse">
                    <div class="am-u-sm-12">
                        <form class="am-form">
                            <table class="am-table am-table-hover table-main">
                                <thead>
                                <tr>
                                    <th class="table-id">ID</th>
                                    <th class="table-title">教练工号</th>
                                    <th class="table-title">教练姓名</th>
                                    <th class="table-type">基本工资</th>
                                    <th class="table-date am-hide-sm-only">业务提成</th>
                                    <th class="table-date am-hide-sm-only">上课提成</th>
                                    <th class="table-author am-hide-sm-only">实发金额</th>
                                    <th class="table-author am-hide-sm-only">结算日期</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($checkouts as $checkout)
                                    <tr>
                                        <td>{{$checkout->id}}</td>
                                        <td><a href="JavaScript:;">{{$checkout->user->master_no}}</a></td>
                                        <td>{{$checkout->user->realname}}</td>
                                        <td class="am-hide-sm-only">{{$checkout->base_salary}}</td>
                                        <td class="am-hide-sm-only">{{$checkout->task}}</td>
                                        <td class="am-hide-sm-only">{{$checkout->total_hours}}</td>
                                        <td class="am-hide-sm-only"
                                            style="color: #f4645f;font-weight: bold">{{$checkout->amount}}</td>
                                        <td class="am-hide-sm-only">{{$checkout->created_at}}</td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                            <div class="am-cf">
                                共 {{$checkouts->total()}} 条记录
                                <div class="am-fr">
                                    {!! $checkouts->appends(Request::all())->links() !!}
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