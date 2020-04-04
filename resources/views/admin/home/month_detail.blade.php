@extends('layouts.admin.app')

@section('content')
    <div class="admin-content">
        <div class="admin-content-body">
            <div class="page-header">
                <ol class="am-breadcrumb am-breadcrumb-slash">
                    <li><a href="/admin">当月收入</a></li>
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
                                    <th class="table-title">课程名称</th>
                                    <th class="table-type">价格</th>
                                    <th class="table-author am-hide-sm-only">上课时间</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($month_records as $item)
                                    <tr>
                                        <td>{{$item->id}}</td>
                                        <td><a href="JavaScript:;">{{$item->customer->username}}</a></td>
                                        <td>{{$item->course->name}}</td>
                                        <td class="am-hide-sm-only">{{$item->today_price->c_price}}</td>
                                        <td class="am-hide-sm-only">{{$item->updated_at}}</td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>

                            <div class="am-cf">
                                共 {{$month_records->total()}} 条记录
                                <div class="am-fr">
                                    {!! $month_records->appends(Request::all())->links() !!}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.shared._footer')

    </div>
@stop
