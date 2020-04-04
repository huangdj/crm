<header class="am-topbar admin-header">
    <div class="am-topbar-brand">
        <a href="/admin"><img src="/vendor/assets/i/logo.png" alt="ITFun"><strong>客户后台系统管理中心</strong></a>
    </div>

    <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-primary am-show-sm-only"
            data-am-collapse="{target: '#topbar-collapse'}">
        <span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>

    <div class="am-collapse am-topbar-collapse" id="topbar-collapse">

        <ul class="am-nav am-nav-pills am-topbar-nav am-topbar-right admin-header-list">
            <li><a href="javascript:;"><span class="am-icon-envelope-o"></span> 收件箱
                    <span class="am-badge am-badge-primary">5</span></a>
            </li>
            <li class="am-dropdown" data-am-dropdown>
                <a class="am-dropdown-toggle" data-am-dropdown-toggle href="javascript:;">
                    <span class="am-icon-users"></span>
                    @if(Auth::user()->is_master)

                        {{ucfirst(Auth::user()->name)}} 教练
                    @else
                        {{ucfirst(Auth::user()->name)}} 管理员
                    @endif
                    <span class="am-icon-caret-down"></span>
                </a>
                <ul class="am-dropdown-content">
                    <li><a href="/admin/profile"><span class="am-icon-cog"></span> 账户设置</a></li>
                    <li>
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault();document.getElementById('logout-form').submit();"><span
                                    class="am-icon-power-off"></span> 安全退出</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
            <li class="am-hide-sm-only">
                <a href="javascript:;" id="admin-fullscreen"><span class="am-icon-arrows-alt"></span>
                    <span class="admin-fullText">开启全屏</span></a></li>
        </ul>
    </div>
</header>
