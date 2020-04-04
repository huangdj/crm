@extends('layouts.admin.app')

@section('css')
    <link rel="stylesheet" href="/vendor/daterangepicker/daterangepicker.css">
@endsection

@section('content')
    <div class="admin-content">
        <div class="admin-content-body">
            <div class="page-header">
                <ol class="am-breadcrumb am-breadcrumb-slash">
                    <li><a href="{{ route('admin.customers.index') }}">办卡会员</a></li>
                    <li class="am-active">开始办卡</li>
                </ol>
            </div>

            <div class="page-body">

                @include('layouts.shared._flash')

                <form class="am-form am-form-horizontal" method="post"
                      action="{{ route('admin.customers.update', $customer->id) }}">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="type_id[]" value="1">
                    <div class="am-form-group">
                        <label for="name" class="am-u-sm-12 am-u-md-3 am-form-label">会员姓名</label>
                        <div class="am-u-sm-12 am-u-md-5 am-u-end">
                            <input type="text" name="username" value="{{ $customer->username }}">
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="name" class="am-u-sm-12 am-u-md-3 am-form-label">分配教练</label>
                        <div class="am-u-sm-12 am-u-md-5 am-u-end">
                            <select data-am-selected="{btnWidth: '100%', btnSize: 'sm', maxHeight: 360}" name="user_id">
                                <option value="">请选择</option>
                                @foreach($users as $user)
                                    <option value="{{$user->id}}"
                                            @if($customer->user_id == $user->id) selected @endif>{{$user->realname}}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="name" class="am-u-sm-12 am-u-md-3 am-form-label">手机号</label>
                        <div class="am-u-sm-12 am-u-md-5 am-u-end">
                            <input type="text" name="mobile" value="{{ $customer->mobile }}">
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="name" class="am-u-sm-12 am-u-md-3 am-form-label">生日</label>
                        <div class="am-u-sm-12 am-u-md-5 am-u-end">
                            <input type="text" name="birthday" value="{{ $customer->birthday }}">
                        </div>
                    </div>

                    <hr style="border:1px dotted #1f99b0;">

                    <div class="am-form-group">
                        <label for="name" class="am-u-sm-12 am-u-md-3 am-form-label">会员周期</label>
                        <div class="am-u-sm-12 am-u-md-5 am-u-end">
                            <select data-am-selected="{btnWidth: '100%', btnSize: 'sm', maxHeight: 360}"
                                    name="cycle_id">
                                <option value="">请选择</option>
                                <option value="1" @if($customer->cycle_id == 1) selected @endif>三个月</option>
                                <option value="2" @if($customer->cycle_id == 2) selected @endif>半年</option>
                                <option value="3" @if($customer->cycle_id == 3) selected @endif>一年</option>
                                <option value="4" @if($customer->cycle_id == 4) selected @endif>两年</option>
                                <option value="5" @if($customer->cycle_id == 5) selected @endif>三年</option>
                            </select>
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="name" class="am-u-sm-12 am-u-md-3 am-form-label">有效日期</label>
                        <div class="am-u-sm-12 am-u-md-5 am-u-end">
                            <input type="text" name="expired_at" id="created_at" value="{{$customer->expired_at}}">
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="name" class="am-u-sm-12 am-u-md-3 am-form-label">办卡价格</label>
                        <div class="am-u-sm-12 am-u-md-5 am-u-end">
                            <input type="text" name="card_price" value="{{ $customer->card_price }}">
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

@section('js')
    <script src="/vendor/daterangepicker/moment.min.js"></script>
    <script src="/vendor/daterangepicker/daterangepicker.js"></script>
    <script>
        $(function () {
            $("#created_at").daterangepicker({
                autoUpdateInput: false,
                locale: {
                    "applyLabel": "确定",
                    "cancelLabel": "取消",
                    'daysOfWeek': ['一', '二', '三', '四', '五', '六', '日'],
                    'monthNames': ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
                },

            }, function (startDate, endDate, label) {  //匿名函数
                this.element[0].value = startDate.format('YYYY-MM-DD') + ' ~ ' + endDate.format('YYYY-MM-DD');
            });
        })
    </script>
@endsection
