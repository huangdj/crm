@if (count($errors) > 0)
    <div class="am-g">
        <div class="am-u-md-12">
            <div class="am-alert" data-am-alert>
                <button type="button" class="am-close">×</button>

                <h1>有 {{count($errors)}} 处问题导致无法提交:</h1>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif

@if (session('success'))
    <div role="alert" class="notification">
        <div class="notification-group">
            <h2><i class="am-icon-btn am-icon-check"></i>成功</h2>
            <div class="content">
                <p>{{ session('success') }}</p>
            </div>
            <div class="close-btn am-icon-close"></div>
        </div>
    </div>
@endif

@if (session('error'))
    <div role="alert" class="notification">
        <div class="notification-group">
            <h2><i class="am-icon-btn am-icon-close"></i>错误</h2>
            <div class="content">
                <p>{{ session('error') }}</p>
            </div>
            <div class="close-btn am-icon-close"></div>
        </div>
    </div>
@endif