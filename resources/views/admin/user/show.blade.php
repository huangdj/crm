@extends('layouts.admin.app')

@section('content')
    <div class="admin-content">
        <div class="admin-content-body">
            <div class="page-header">
                <ol class="am-breadcrumb am-breadcrumb-slash">
                    <li><a href="{{ route('admin.users.index') }}">教练管理</a></li>
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
                            <input type="text" value="{{ $user->realname }}" readonly>
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="name" class="am-u-sm-12 am-u-md-3 am-form-label">基本工资</label>
                        <div class="am-u-sm-12 am-u-md-5 am-u-end">
                            <input type="text" name="base_salary" id="base_salary" value="{{ $user->base_salary }}"
                                   readonly>
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="name" class="am-u-sm-12 am-u-md-3 am-form-label">指标提成</label>
                        <div class="am-u-sm-12 am-u-md-5 am-u-end">
                            <input type="text" name="task" id="task" value="{{ $sell_total }}">
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="name" class="am-u-sm-12 am-u-md-3 am-form-label">上课提成</label>
                        <div class="am-u-sm-12 am-u-md-5 am-u-end">
                            <input type="text" name="total_hours" id="total_hours" value="{{ $month_total }}">
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="name" class="am-u-sm-12 am-u-md-3 am-form-label">实发金额</label>
                        <div class="am-u-sm-12 am-u-md-5 am-u-end">
                            <input type="text" name="amount" id="amount" placeholder="实发金额" value="">
                        </div>
                        <div class="am-u-sm-12 am-u-md-4 am-u-end">
                            <p style="color: #f4645f"> * 鼠标点击此框，自动计算实发金额</p>
                        </div>
                    </div>

                    <div class="am-form-group">
                        <div class="am-u-sm-12 am-u-md-9 am-u-md-offset-3">
                            <button type="button" onclick="location.href='/admin/users'"
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
@stop

@section('js')
    <script>
        $(function () {
            $("#amount").click(function () {
                var total = (parseInt($("#base_salary").val()) + parseInt($("#task").val()) + parseInt($("#total_hours").val())).toFixed(2);
                $("#amount").val(total);
            })
        })
    </script>
@endsection
