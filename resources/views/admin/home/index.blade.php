@extends('layouts.admin.app')

@section('content')
    <div class="admin-content">
        <div class="admin-content-body">

            <div class="page-header">
                <ol class="am-breadcrumb am-breadcrumb-slash">
                    <li><a href="/admin">首页</a></li>
                    <li class="am-active">Dashboard</li>
                </ol>

            </div>

            <div class="page-body">
                <ul class="am-avg-sm-1 am-avg-md-4 am-margin am-padding am-text-center admin-content-list">
                    @if(Auth::user()->is_master)
                        <h1>{{getTime()}}，{{ Auth::user()->realname }}，今天是{{date('Y年m月d日')}}，祝您开心每一天！</h1>
                        <h1 style="color: #f4645f;">截止今日，您的总收入共计：{{ $count['amount_total'] }} 元</h1>
                    @else
                        <h1>{{getTime()}}，{{ Auth::user()->name }}，今天是{{date('Y年m月d日')}}，祝您开心每一天！</h1>
                        <h1 style="color: #f4645f;">截止今日，平台销售课程总收入：{{ $count['amount_total'] }} 元</h1>
                    @endif
                </ul>

                @if(Auth::user()->is_master)
                    <ul class="am-avg-sm-1 am-avg-md-3 am-margin am-padding am-text-center admin-content-list ">
                        <li>
                            <a href="{{ route('admin.today_detail') }}" class="am-text-success"><span
                                        class="am-icon-btn am-icon-money"></span><br/>今日上课收入<br/>{{ $count['today_total'] }}
                                元</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.month_detail') }}" class="am-text-warning"><span
                                        class="am-icon-btn am-icon-money"></span><br/>当月上课收入<br/>{{ $count['month_total'] }}
                                元
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.year_detail') }}" class="am-text-danger"><span
                                        class="am-icon-btn am-icon-money"></span><br/>全年上课收入<br/>{{ $count['year_total'] }}
                                元
                            </a>
                        </li>
                    </ul>

                    <ul class="am-avg-sm-1 am-avg-md-3 am-margin am-padding am-text-center admin-content-list ">
                        <li>
                            <a href="{{ route('admin.sell_day_detail') }}" class="am-text-success"><span
                                        class="am-icon-btn am-icon-money"></span><br/>今日卖课收入<br/>{{ $count['day_sell'] }}
                                元</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.sell_mon_detail') }}" class="am-text-warning"><span
                                        class="am-icon-btn am-icon-money"></span><br/>当月卖课收入<br/>{{ $count['month_sell'] }}
                                元
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.sell_yea_detail') }}" class="am-text-danger"><span
                                        class="am-icon-btn am-icon-money"></span><br/>全年卖课收入<br/>{{ $count['year_sell'] }}
                                元
                            </a>
                        </li>
                    </ul>
                @else
                    <ul class="am-avg-sm-1 am-avg-md-3 am-margin am-padding am-text-center admin-content-list">
                        <li>
                            <a href="/admin/birthday" class="am-text-success"><span
                                        class="am-icon-btn am-icon-gift"></span><br/>今日生日会员<br/>{{$birthday_count}}</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.users.index') }}" class="am-text-danger"><span
                                        class="am-icon-btn am-icon-user-md"></span><br/>全部教练列表<br/>{{ App\User::where('is_master', true)->count() }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.courses.index') }}" class="am-text-secondary"><span
                                        class="am-icon-btn am-icon-book"></span><br/>全部课程列表<br/>{{ App\Models\Course::count() }}
                            </a>
                        </li>
                    </ul>

                    <ul class="am-avg-sm-1 am-avg-md-3 am-margin am-padding am-text-center admin-content-list ">
                        <li>
                            <a href="{{ route('admin.all_today_detail') }}" class="am-text-success"><span
                                        class="am-icon-btn am-icon-money"></span><br/>今日上课明细<br/>{{$count['today_income']}}
                                元</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.all_month_detail') }}" class="am-text-warning"><span
                                        class="am-icon-btn am-icon-money"></span><br/>当月上课明细<br/>{{$count['month_income']}}
                                元
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.all_year_detail') }}" class="am-text-danger"><span
                                        class="am-icon-btn am-icon-money"></span><br/>全年上课明细<br/>{{$count['year_income']}}
                                元
                            </a>
                        </li>
                    </ul>

                    <ul class="am-avg-sm-1 am-avg-md-3 am-margin am-padding am-text-center admin-content-list ">
                        <li>
                            <a href="{{ route('admin.sell_today_detail') }}" class="am-text-success"><span
                                        class="am-icon-btn am-icon-money"></span><br/>今日卖课收入<br/>{{$count['sell_day_total']}}
                                元</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.sell_month_detail') }}" class="am-text-warning"><span
                                        class="am-icon-btn am-icon-money"></span><br/>当月卖课收入<br/>{{$count['sell_month_total']}}
                                元
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.sell_year_detail') }}" class="am-text-danger"><span
                                        class="am-icon-btn am-icon-money"></span><br/>全年卖课收入<br/>{{$count['sell_year_total']}}
                                元
                            </a>
                        </li>
                    </ul>

                    <div class="am-g">
                        <div class="am-u-md-12">
                            <div id="day_count" style="width: 100%;height:400px;margin-top: 20px;"></div>
                        </div>

                        <div class="am-u-md-12">
                            <div id="month_count" style="width: 100%;height:400px;margin-top: 20px;"></div>
                        </div>

                        <div class="am-u-md-12">
                            <div id="year_count" style="width: 100%;height:400px;margin-top: 20px;"></div>
                        </div>
                    </div>
                @endif

            </div>
        </div>

        @include('layouts.shared._footer')
    </div>
@endsection

@section('js')
    <script src="/vendor/echarts/echarts.min.js"></script>
    <script src="/vendor/echarts/macarons.js"></script>
    <script src="/vendor/echarts/vintage.js"></script>

    <script src="/js/visualization/day_count.js"></script>
    <script src="/js/visualization/month_count.js"></script>
    <script src="/js/visualization/year_count.js"></script>
@endsection
