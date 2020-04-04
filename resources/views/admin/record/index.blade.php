@extends('layouts.admin.app')

@section('css')
    <style>
        .makeSure {
            color: #f37b1d;
        }
    </style>
@endsection

@section('content')
    <div class="admin-content">
        <div class="admin-content-body">
            <div class="page-header">
                <ol class="am-breadcrumb am-breadcrumb-slash">
                    <li><a href="/admin/records">上课管理</a></li>
                    <li class="am-active">上课记录</li>
                </ol>
            </div>

            <div class="page-body">
                <div class="am-g am-g-collapse">
                    <div class="am-u-sm-12">
                        <form class="am-form">
                            <table class="am-table am-table-hover table-main">
                                <thead>
                                <tr>
                                    <th class="table-title">编号</th>
                                    <th class="table-title">会员姓名</th>
                                    <th class="table-title">手机号</th>
                                    <th class="table-title">课程名称</th>
                                    <th class="table-type">课程类型</th>
                                    <th class="table-type">课时价格</th>
                                    <th class="table-author am-hide-sm-only">剩余课时</th>
                                    <th class="table-date am-hide-sm-only">提交日期</th>
                                    <th class="table-set">操作</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($records as $record)
                                    @if($record->buy_type_id == 2)
                                        <tr data-id="{{$record->id}}">
                                            <td>{{$record->id}}</td>
                                            <td>{{$record->customer->username}}</td>
                                            <td>{{$record->customer->mobile}}</td>
                                            <td><a href="#">{{$record->course->name}}</a></td>
                                            <td><a href="#">购课课程</a></td>
                                            <td class="am-hide-sm-only">{{$record->hour_price}}元</td>
                                            <td class="am-hide-sm-only">{{$record->surplus_hour}}节</td>
                                            <td class="am-hide-sm-only">{{$record->created_at}}</td>
                                            <td class="am-hide-sm-only">
                                                @if(!$record->status)
                                                    <a href="javascript:;" class="makeSure">确认上课？</a>
                                                @else
                                                    <a href="javascript:;" style="color:#5eb95e">已上课！</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @else
                                        <tr data-id="{{$record->id}}">
                                            <td>{{$record->id}}</td>
                                            <td><a href="#">{{$record->customer->username}}</a></td>
                                            <td>{{$record->customer->mobile}}</td>
                                            <td><a href="#">{{$record->relation_course->name}}</a></td>
                                            <td><a href="#">赠送课程</a></td>
                                            <td class="am-hide-sm-only">免费</td>
                                            <td class="am-hide-sm-only">{{$record->surplus_hour}}节</td>
                                            <td class="am-hide-sm-only">{{$record->created_at}}</td>
                                            <td class="am-hide-sm-only">
                                                @if(!$record->status)
                                                    <a href="javascript:;" class="makeSure">确认上课？</a>
                                                @else
                                                    <a href="javascript:;" style="color:#5eb95e">已上课！</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach

                                </tbody>
                            </table>

                            <div class="am-cf">
                                共 {{$records->total()}} 条记录
                                <div class="am-fr">
                                    {!! $records->appends(Request::all())->links() !!}
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

@section('js')
    <script>
        $(function () {
            $('.makeSure').click(function () {
                if (confirm('是否确定要上课？')) {
                    var id = $(this).parents('tr').data('id');
                    var _this = $(this);
                    $.ajax({
                        type: "PATCH",
                        url: "{{ route('admin.records.makeSure') }}",
                        data: {id: id},
                        success: function (data) {
                            if (data.status == 1) {
                                alert(data.msg);
                                window.location.reload()
                            }
                        }
                    })
                }
            })
        })
    </script>
@endsection