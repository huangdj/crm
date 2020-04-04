@extends('layouts.admin.app')

@section('css')
    <style>
        .am-icon-shopping-cart, .am-icon-hand-peace-o, .am-icon-video-camera {
            color: #f4645f;
        }
    </style>
@endsection

@section('content')
    <div class="admin-content">
        <div class="admin-content-body">
            <div class="page-header">
                <ol class="am-breadcrumb am-breadcrumb-slash">
                    <li><a href="/admin/customers">会员管理</a></li>
                    <li class="am-active">会员详情</li>
                </ol>
            </div>

            {{--<div class="page-body">--}}
                {{--<h2>完善信息，开始上课啦~</h2>--}}
                {{--@include('layouts.shared._flash')--}}

                {{--<form class="am-form am-form-horizontal" method="post" action="{{ route('admin.customers.begin') }}">--}}
                    {{--@csrf--}}

                    {{--<div class="am-form-group">--}}
                        {{--<label for="name" class="am-u-sm-12 am-u-md-3 am-form-label">会员姓名</label>--}}
                        {{--<div class="am-u-sm-12 am-u-md-5 am-u-end">--}}
                            {{--<input type="text" value="{{ $customer->username }}" readonly>--}}
                            {{--<input type="hidden" name="customer_id" value="{{ $customer->id }}">--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="am-form-group">--}}
                        {{--<label for="name" class="am-u-sm-12 am-u-md-3 am-form-label">主讲教练</label>--}}
                        {{--<div class="am-u-sm-12 am-u-md-5 am-u-end">--}}
                            {{--<input type="text" value="{{ Auth::user()->realname }}" readonly>--}}
                            {{--<input type="hidden" name="user_id" value="{{ Auth::user()->id }}">--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="am-form-group">--}}
                        {{--<label for="name" class="am-u-sm-12 am-u-md-3 am-form-label">购课课程</label>--}}
                        {{--<div class="am-u-sm-12 am-u-md-5 am-u-end">--}}
                            {{--<select data-am-selected="{btnWidth: '100%', btnSize: 'sm', maxHeight: 360}"--}}
                                    {{--name="buy_course_id">--}}
                                {{--<option value="">请选择</option>--}}
                                {{--@foreach($buy_records as $course)--}}
                                    {{--<option value="{{$course->course->id}}">{{$course->course->name}}</option>--}}
                                {{--@endforeach--}}

                            {{--</select>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="am-form-group">--}}
                        {{--<label for="name" class="am-u-sm-12 am-u-md-3 am-form-label">赠课课程</label>--}}
                        {{--<div class="am-u-sm-12 am-u-md-5 am-u-end">--}}
                            {{--<select data-am-selected="{btnWidth: '100%', btnSize: 'sm', maxHeight: 360}"--}}
                                    {{--name="relation_course_id">--}}
                                {{--<option value="">请选择</option>--}}
                                {{--@foreach($relation_records as $relation)--}}
                                    {{--<option value="{{$relation->course->id}}">{{$relation->course->name}}</option>--}}
                                {{--@endforeach--}}

                            {{--</select>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="am-form-group">--}}
                        {{--<div class="am-u-sm-12 am-u-md-9 am-u-md-offset-3">--}}
                            {{--<button type="submit" class="am-btn am-btn-primary am-btn-sm am-radius">保 存--}}
                            {{--</button>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</form>--}}
            {{--</div>--}}

            <div class="page-body">
                <div class="am-g">
                    <div class="am-u-sm-12 am-u-sm-centered">
                        <h2><span class="am-icon-shopping-cart"></span> 购买记录</h2>
                        <div class="am-g am-g-collapse">
                            <div class="am-u-sm-12">
                                <form class="am-form">
                                    <table class="am-table am-table-hover table-main">
                                        <thead>
                                        <tr>
                                            <th class="table-title">课程名</th>
                                            <th class="table-title">课时数</th>
                                            <th class="table-title">课程单价</th>
                                            <th class="table-type">总金额</th>
                                            <th class="table-date am-hide-sm-only">购买日期</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($buy_records as $vo)
                                            <tr>
                                                <td><a href="#">{{$vo->course->name}}</a></td>
                                                <td>{{$vo->c_hour}}节</td>
                                                <td>{{$vo->c_price}}元</td>
                                                <td>{{number_format($vo->c_price * $vo->c_hour, 2)}}元</td>
                                                <td class="am-hide-sm-only">{{$vo->paid_at->format('Y-m-d H:i:s')}}</td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                    <div class="am-cf">
                                        共 {{ $buy_records->total() }} 条记录
                                        <div class="am-fr">
                                            {!! $buy_records->appends(Request::all())->links() !!}
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>

            <div class="page-body">
                <div class="am-g">
                    <div class="am-u-sm-12 am-u-sm-centered">
                        <h2><span class="am-icon-hand-peace-o"></span> 赠送记录</h2>
                        <div class="am-g am-g-collapse">
                            <div class="am-u-sm-12">
                                <form class="am-form">
                                    <table class="am-table am-table-hover table-main">
                                        <thead>
                                        <tr>
                                            <th class="table-title">课程名</th>
                                            <th class="table-title">课时数</th>
                                            <th class="table-date am-hide-sm-only">赠送日期</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($relation_records as $relation)
                                            <tr>
                                                <td><a href="#">{{$relation->course->name}}</a></td>
                                                <td>{{$relation->g_hour}}节</td>
                                                <td class="am-hide-sm-only">{{$relation->paid_at->format('Y-m-d H:i:s')}}</td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                    <div class="am-cf">
                                        共 {{ $relation_records->total() }} 条记录
                                        <div class="am-fr">
                                            {!! $relation_records->appends(Request::all())->links() !!}
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="page-body">
                <div class="am-g">
                    <div class="am-u-sm-12 am-u-sm-centered">
                        <h2><span class="am-icon-video-camera"></span> 上课记录</h2>
                        <div class="am-g am-g-collapse">
                            <div class="am-u-sm-12">
                                <form class="am-form">
                                    <table class="am-table am-table-hover table-main">
                                        <thead>
                                        <tr>
                                            <th class="table-title">课程名称</th>
                                            <th class="table-type">课程类型</th>
                                            <th class="table-type">课时价格</th>
                                            <th class="table-author am-hide-sm-only">剩余课时</th>
                                            <th class="table-date am-hide-sm-only">上课日期</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($records as $record)
                                            @if($record->buy_type_id == 2)
                                                <tr>
                                                    <td><a href="#">{{$record->course->name}}</a></td>
                                                    <td><a href="#">购课课程</a></td>
                                                    <td class="am-hide-sm-only">{{$record->surplus_price}}元</td>
                                                    <td class="am-hide-sm-only">{{$record->surplus_hour}}节</td>
                                                    <td class="am-hide-sm-only">{{$record->created_at}}</td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td><a href="#">{{$record->relation_course->name}}</a></td>
                                                    <td><a href="#">赠课课程</a></td>
                                                    <td class="am-hide-sm-only">免费</td>
                                                    <td class="am-hide-sm-only">{{$record->surplus_hour}}节</td>
                                                    <td class="am-hide-sm-only">{{$record->created_at}}</td>
                                                </tr>
                                            @endif
                                        @endforeach

                                        </tbody>
                                    </table>

                                    <div class="am-cf">
                                        共 {{ $records->total() }} 条记录
                                        <div class="am-fr">
                                            {!! $records->appends(Request::all())->links() !!}
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.shared._footer')

    </div>
@stop