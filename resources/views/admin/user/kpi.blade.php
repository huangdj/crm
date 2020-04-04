@extends('layouts.admin.app')

@section('content')
    <div class="admin-content">
        <div class="admin-content-body">
            <div class="page-header">
                <ol class="am-breadcrumb am-breadcrumb-slash">
                    <li><a href="{{ route('admin.users.index') }}">员工管理</a></li>
                    <li class="am-active">设置KPI</li>
                </ol>
            </div>

            <div class="page-body">

                @include('layouts.shared._flash')

                <form class="am-form am-form-horizontal" method="post"
                      action="{{ route('admin.users.kpi_update', $user->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="am-form-group">
                        <button type="button" class="am-btn am-btn-primary add_file"><span
                                    class="am-icon-plus"></span>
                            新增指标
                        </button>
                        <p style="margin-left: 150px;margin-top: -40px;color: #f4645f">*
                            填写示例：开始值0，结束值5999，百分比5代表5%</p>
                        <p style="margin-left: 150px;margin-top: -10px;color: #f4645f">*
                            注意事项：每次添加时，只能添加一条数据；已有数据不能编辑，请删除后再添加</p>
                    </div>

                    <div class="files">

                        @foreach($user->achievements as $item)
                            <div class="am-form-group">
                                <div class="am-u-sm-12 am-u-md-3">
                                    <input class="file1" type="text" name="start[]" value="{{$item->start}}" readonly>
                                </div>

                                <div class="am-u-sm-12 am-u-md-3">
                                    <input type="text" class="file1" name="end[]" value="{{$item->end}}" readonly>
                                </div>

                                <div class="am-u-sm-12 am-u-md-3">
                                    <input type="text" class="file1" name="percent[]" value="{{$item->percent}}"
                                           readonly>
                                </div>

                                <div class="am-u-sm-12 am-u-md-3">
                                    <a href="javascript:;" class="am-icon-close del_one"
                                       data-id="{{$item->id}}"></a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="am-form-group" style="margin-top: 60px;">
                        <div class="am-u-sm-12 am-u-md-9 am-u-md-offset-3">
                            <button type="button" onclick="location.href='/admin/users'"
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
    <script>
        $(function () {
            $(".add_file").click(function () {
                var length = $(".files").children().length;
                var i = length + 1;

                html = '<div class="am-form-group">' +
                    '<div class="am-u-sm-12 am-u-md-3">' +
                    '<input class="file' + i + '" type="text" name="start[]" placeholder="输入开始值">' +
                    '</div>' +
                    '<div class="am-u-sm-12 am-u-md-3">' +
                    '<input class="file' + i + '" type="text" name="end[]" placeholder="输入结束值">' +
                    '</div>' +
                    '<div class="am-u-sm-12 am-u-md-3">' +
                    '<input type="text" class="file' + i + '" name="percent[]" placeholder="例:输入2代表2%">' +
                    '</div>' +
                    '<div class="am-u-sm-12 am-u-md-3">' +
                    '<a href="javascript:;" class="am-icon-close empty_file1"></a>' +
                    '</div>';
                $(".files").append(html);
            })

            //js删除表单
            $(document).on('click', '.empty_file1', function () {
                $(this).parents('.am-form-group').remove();
            });

            // 删除购买课程
            $(document).on('click', '.del_one', function () {
                var id = $(this).data('id');
                var _this = $(this);
                if (confirm('删除后不可恢复，请慎重！')) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('admin.users.del_one') }}",
                        data: {id: id},
                        success: function () {
                            _this.parents('.am-form-group').remove();
                        }
                    })
                }
            })
        })
    </script>
@endsection
