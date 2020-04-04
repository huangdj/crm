@extends('layouts.admin.app')

@section('content')
    <div class="admin-content">
        <div class="admin-content-body">
            <div class="page-header">
                <ol class="am-breadcrumb am-breadcrumb-slash">
                    <li><a href="/admin/adverts">广告管理</a></li>
                    <li class="am-active">广告列表</li>
                </ol>
            </div>

            <div class="page-body">

                <div class="am-g">
                    <div class="am-u-sm-12">
                        <div class="am-btn-toolbar">
                            <div class="">
                                <button type="button" onclick="location.href='/admin/adverts/create'"
                                        class="am-btn am-btn-primary"><span class="am-icon-plus"></span>
                                    新增
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="am-g am-g-collapse">
                    <div class="am-u-sm-12">
                        <form class="am-form">
                            <table class="am-table am-table-hover table-main">
                                <thead>
                                <tr>
                                    <th class="table-title">ID</th>
                                    <th class="table-title">缩略图</th>
                                    <th class="table-set">操作</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($adverts as $advert)
                                    <tr>
                                        <td>{{$advert->id}}</td>
                                        <td><img src="{{$advert->image}}" alt="" class="thumb"></td>
                                        <td>
                                            <a href="{{ route('admin.adverts.edit', $advert->id) }}">编辑</a>
                                            <div class="divider divider-vertical"></div>
                                            <a href="{{ route('admin.adverts.destroy', $advert->id) }}"
                                               data-method="delete" data-token="{{csrf_token()}}"
                                               data-confirm="是否确定要删除?">删除</a>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.shared._footer')

    </div>

    @include('layouts.shared._flash')
@stop