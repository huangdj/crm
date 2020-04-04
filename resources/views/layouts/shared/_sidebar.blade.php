<div class="admin-sidebar am-offcanvas" id="admin-offcanvas">
    <div class="am-offcanvas-bar admin-offcanvas-bar">
        <ul class="am-list admin-sidebar-list">

            @if(Auth::user()->is_master)
                <li>
                    <a href="/admin" class="{{$_admin ?? ''}}">
                        <span class="am-icon-dashboard"></span>Dashboard
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.customers.index') }}" class="{{$_customer ?? ''}}">
                        <span class="am-icon-user"></span>会员管理
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.records.index') }}" class="{{ $_record ?? '' }}">
                        <span class="am-icon-video-camera"></span>上课管理
                    </a>
                </li>
            @else
                <li>
                    <a href="/admin" class="{{$_admin ?? ''}}">
                        <span class="am-icon-dashboard"></span>Dashboard
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.courses.index') }}" class="{{$_course ?? ''}}">
                        <span class="am-icon-book"></span>课程管理
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.adverts.index') }}" class="{{$_advert ?? ''}}">
                        <span class="am-icon-adjust"></span>广告管理
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.customers.index') }}" class="{{$_customer ?? ''}}">
                        <span class="am-icon-user"></span>会员管理
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.users.index') }}" class="{{$_user ?? ''}}">
                        <span class="am-icon-user-md"></span>教练管理
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.checkout.index') }}" class="{{$_checkout ?? ''}}">
                        <span class="am-icon-money"></span>工资管理
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.attendances.index') }}" class="{{$_attendances ?? ''}}">
                        <span class="am-icon-amazon"></span>考勤管理
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.data.index') }}" class="{{$_data ?? ''}}">
                        <span class="am-icon-copy"></span> 数据备份
                    </a>
                </li>
            @endif
        </ul>
    </div>
</div>
