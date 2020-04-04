@extends('layouts.admin.app')


@section('content')
    <div class="admin-content">
        <div class="admin-content-body">

            <div class="page-header">
                <ol class="am-breadcrumb am-breadcrumb-slash">
                    <li><a href="/admin">首页</a></li>
                    <li class="am-active">数据备份</li>
                </ol>

                <h1 style="color: #f4645f;">为了防止出现意外情况，请您定期备份数据库文件！</h1>
            </div>

            <div class="page-body">
                <div class="am-g">
                    <div class="am-u-sm-12 am-u-sm-push-5">
                        <button class="am-btn am-btn-primary submit">开始备份</button>
                    </div>
                </div>
            </div>

        </div>
    </div>

@stop

@section('js')
    <script>
        $(function () {
            $('.submit').click(function () {
                if (confirm('确定要导出数据么？')) {
                    $.ajax({
                        type: 'GET',
                        url: "{{ route('admin.data.export') }}",
                        success: function (data) {
                            if (data.status == 200) {
                                alert(data.msg);
                                window.location.reload();
                            }
                        }
                    })
                }
            })
        })
    </script>
@endsection