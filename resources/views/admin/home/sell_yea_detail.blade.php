@extends('layouts.admin.app')

@section('content')
    <div class="admin-content">
        <div class="admin-content-body">
            <div class="page-header">
                <ol class="am-breadcrumb am-breadcrumb-slash">
                    <li><a href="/admin">当月卖课收入</a></li>
                    <li class="am-active">收入明细</li>
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
                                    <th class="table-title">会员名称</th>
                                    <th class="table-title">购买课程</th>
                                    <th class="table-title">购买课时</th>
                                    <th class="table-type">价格</th>
                                    <th class="table-author am-hide-sm-only">购买时间</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($customers as $customer)
                                    @foreach($customer->sell_courses as $item)
                                        <tr>
                                            <td>{{$item->id}}</td>
                                            <td><a href="JavaScript:;">{{$item->customer->username}}</a></td>
                                            <td>{{$item->course->name}}</td>
                                            <td class="am-hide-sm-only">{{$item->c_hour}}节</td>
                                            <td class="am-hide-sm-only">{{$item->c_price}}</td>
                                            <td class="am-hide-sm-only">{{$item->paid_at}}</td>
                                        </tr>
                                    @endforeach
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
@stop
