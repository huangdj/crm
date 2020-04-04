<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>CRM | 客户管理系统</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/vendor/assets/css/amazeui.min.css"/>
    <link rel="stylesheet" href="/vendor/assets/css/admin.css">
    <link rel="stylesheet" href="/css/common.css">
    @yield('css')
</head>
<body>
<!--[if lte IE 9]>
<p class="browsehappy">你正在使用<strong>过时</strong>的浏览器，Amaze UI 暂不支持。 请 <a href="http://browsehappy.com/" target="_blank">升级浏览器</a>
    以获得更好的体验！</p>
<![endif]-->


@include('layouts.shared._header')

<div class="am-cf admin-main">
    <!-- sidebar start -->
@include('layouts.shared._sidebar')
    <!-- sidebar end -->

    <!-- content start -->
    @yield('content')
    <!-- content end -->

</div>

<a href="#" class="am-icon-btn am-icon-th-list am-show-sm-only admin-menu"
   data-am-offcanvas="{target: '#admin-offcanvas'}"></a>


<script src="/vendor/assets/js/jquery.min.js"></script>
<script src="/vendor/assets/js/amazeui.min.js"></script>
<script src="/vendor/assets/js/app.js"></script>
<script src="/js/common.js"></script>
<script src="/js/destroy.js"></script>

@yield('js')
</body>
</html>
