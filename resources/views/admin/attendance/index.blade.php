@extends('layouts.admin.app')

@section('content')
    <div class="admin-content">
        <div class="admin-content-body">
            <div class="page-header">
                <ol class="am-breadcrumb am-breadcrumb-slash">
                    <li><a href="/admin/attendances">考勤管理</a></li>
                    <li class="am-active">考勤记录</li>
                </ol>
            </div>

            <div class="page-body">

                @include('layouts.shared._flash')

                <div class="am-g">
                    <div class="am-u-sm-12">
                        <div class="am-btn-toolbar">
                            <div class="">
                                <button type="button"
                                        class="am-btn am-btn-primary import_file"><span class="am-icon-download"></span>
                                    导入考勤
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                @if($attendances->isEmpty())
                    <div class="am-g">
                        <div class="am-u-sm-12">
                            <h2 class="am-text-center am-text-xxxl am-margin-top-lg">暂时没有数据</h2>
                            <p class="am-text-center">点击上面的按钮导入考勤即可查看</p>
                            <pre class="page-404">
          .----.
       _.'__    `.
   .--($)($$)---/#\
 .' @          /###\
 :         ,   #####
  `-..__.-' _.-\###/
        `;_:    `"'
      .'"""""`.
     /,  哦豁 ,\\
    //  Not Found!  \\
    `-._______.-'
    ___`. | .'___
   (______|______)
        </pre>
                        </div>
                    </div>
                @else
                    <div class="am-g am-g-collapse">
                        <div class="am-u-sm-12">
                            <form class="am-form">
                                <table class="am-table am-table-hover table-main">
                                    <thead>
                                    <tr>
                                        <th class="table-id">ID</th>
                                        <th class="table-title">教练工号</th>
                                        <th class="table-title">教练姓名</th>
                                        <th class="table-type">打卡结果</th>
                                        <th class="table-date am-hide-sm-only">打卡时间</th>
                                        <th class="table-date am-hide-sm-only">数据来源</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($attendances as $attendance)
                                        <tr>
                                            <td>{{$attendance->id}}</td>
                                            <td><a href="JavaScript:;">{{$attendance->user->master_no}}</a></td>
                                            <td>{{$attendance->user->realname}}</td>
                                            <td class="am-hide-sm-only">
                                                @if($attendance->timeResult == "Normal")
                                                    <span style="color: #5eb95e;">正常</span>
                                                @elseif($attendance->timeResult == "Late")
                                                    <span style="color: #f4645f;">迟到</span>
                                                @else
                                                    <span style="color: #08c">未打卡</span>
                                                @endif
                                            </td>
                                            <td class="am-hide-sm-only">{{$attendance->userCheckTime}}</td>
                                            <td class="am-hide-sm-only">
                                                @if($attendance->sourceType == "DING_ATM")
                                                    <span style="color: #5eb95e;">钉钉考勤机</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                                <div class="am-cf">
                                    共 {{$attendances->total()}} 条记录
                                    <div class="am-fr">
                                        {!! $attendances->appends(Request::all())->links() !!}
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <hr style="border:1px dotted #1f99b0;">

                    <p style="color: #f4645f;">截止今日：{{date('m')}}月{{date('d')}}号考勤结果</p>

                    @foreach($users as $user)
                        <p style="color: #1f99b0">{{$user->realname}} 迟到：{{$user->late_num}}次,
                            未打卡：{{$user->notSigned_num}}次</p>
                    @endforeach
                @endif
            </div>
        </div>

        @include('layouts.shared._footer')

    </div>

@stop

@section('js')
    <script>
        $(function () {
            $('.import_file').click(function () {
                if (confirm('是否确定导入考勤?')) {
                    $.get('/api/get_tests', function (data) {
                        $.ajax({
                            type: 'POST',
                            url: "/admin/attendances/import",
                            data: {data:data},
                            success: function (e) {
                                if (e.status == 0) {
                                    alert(e.message);
                                    return false;
                                } else {
                                    alert(e.message);
                                    window.location.reload()
                                }
                            }
                        })
                    })
                }
            })
        })
    </script>
@endsection