@extends('layouts.admin.app')

@section('content')
    <div class="admin-content">
        <div class="admin-content-body">
            <div class="page-header">
                <ol class="am-breadcrumb am-breadcrumb-slash">
                    <li><a href="{{ route('admin.customers.index') }}">会员管理</a></li>
                    <li class="am-active">赠课会员</li>
                </ol>
            </div>

            <div class="page-body">

                @include('layouts.shared._flash')

                <form class="am-form am-form-horizontal" method="post"
                      action="{{ route('admin.customers.relation_update', $relation->id) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="type_id[]" value="3">
                    <div class="am-form-group">
                        <label for="name" class="am-u-sm-12 am-u-md-3 am-form-label">会员姓名</label>
                        <div class="am-u-sm-12 am-u-md-5 am-u-end">
                            <input type="text" name="username" value="{{ $relation->username }}">
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="name" class="am-u-sm-12 am-u-md-3 am-form-label">分配教练</label>
                        <div class="am-u-sm-12 am-u-md-5 am-u-end">
                            <select data-am-selected="{btnWidth: '100%', btnSize: 'sm', maxHeight: 360}" name="user_id">
                                <option value="">请选择</option>
                                @foreach($users as $user)
                                    <option value="{{$user->id}}"
                                            @if($relation->user_id == $user->id) selected @endif>{{$user->realname}}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="name" class="am-u-sm-12 am-u-md-3 am-form-label">手机号</label>
                        <div class="am-u-sm-12 am-u-md-5 am-u-end">
                            <input type="text" name="mobile" value="{{ $relation->mobile }}">
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="name" class="am-u-sm-12 am-u-md-3 am-form-label">生日</label>
                        <div class="am-u-sm-12 am-u-md-5 am-u-end">
                            <input type="text" name="birthday" value="{{ $relation->birthday }}">
                        </div>
                    </div>

                    <hr style="border:1px dotted #1f99b0;">


                    <div class="am-form-group">
                        <button type="button" class="am-btn am-btn-primary add_file"><span
                                    class="am-icon-plus"></span>
                            增加
                        </button>
                        <p style="margin-left: 100px;margin-top: -30px;color: #f4645f">* 注：每次只能添加一条数据,已有数据不可编辑，请删除后重新添加</p>
                    </div>

                    <div class="files">

                        @foreach($relation->relation_properties as $item)
                            <input type="hidden" name="c_id[]" value="{{$item->id}}">
                            <div class="am-form-group">
                                <div class="am-u-md-offset-2 am-u-sm-12 am-u-md-3">
                                    <select class="file1"
                                            data-am-selected="{btnWidth: '100%', btnSize: 'sm', maxHeight: 360}"
                                            name="course_id[]"  disabled="disabled">
                                        <option value="">请选择</option>
                                        @foreach($courses as $course)
                                            <option value="{{$course->id}}"
                                                    @if($course->id == $item->course_id) selected @endif>{{$course->name}}</option>
                                        @endforeach

                                    </select>
                                </div>

                                <div class="am-u-sm-12 am-u-md-3">
                                    <input class="file1" type="text" name="g_hour[]" value="{{$item->g_hour}}" readonly>
                                </div>

                                <div class="am-u-sm-12 am-u-md-4">
                                    <a href="javascript:;" class="am-icon-close del_one"
                                       data-id="{{$item->id}}" data-cid="{{$relation->id}}"></a>
                                </div>
                            </div>
                        @endforeach

                    </div>

                    <div class="am-form-group">
                        <div class="am-u-sm-12 am-u-md-9 am-u-md-offset-3">
                            <button type="button" onclick="location.href='/admin/relations'"
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
                if (length > 10) {
                    alert('每次只能添加1个课程~');
                    return false;
                }

                var html = '';

                var i = length + 1;

                html += '<div class="am-form-group buy_user">' +
                    '<div class="am-u-md-offset-2 am-u-sm-12 am-u-md-3">' +
                    '<select class="file' + i + '" data-am-selected="{btnWidth: \'100%\', btnSize: \'sm\'}" name="course_id[]">' +
                    '<option value="">&nbsp;点击选择...</option>' +
                    '<option value="4">常规课</option>' +
                    '<option value="3">拳击课</option>' +
                    '<option value="2">拉伸课</option>' +
                    '<option value="1">团课</option>';

                // $.get("/api/get_courses", function (data) {
                //     $.each(data, function (k, v) {
                //         // console.log(v.id);return;
                //
                //         html += '<option value="">请选择</option>';
                //     })
                // });

                html += '</select>' +
                    '</div>' +
                    '<div class="am-u-sm-12 am-u-md-3">' +
                    '<input placeholder="课程课时" class="file' + i + '" type="text" name="g_hour[]">' +
                    '</div>' +
                    '<div class="am-u-sm-12 am-u-md-4">' +
                    '<a href="javascript:;" class="am-icon-close empty_file1"></a>' +
                    '</div>' +
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
                var cid = $(this).data('cid');
                var _this = $(this);
                if (confirm('删除后不可恢复，请慎重！')) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('admin.customers.del_relation') }}",
                        data: {id: id,cid:cid,tid:3},
                        success: function () {
                            _this.parents('.am-form-group').remove();
                        }
                    })
                }
            })
        })
    </script>
@endsection
