(function ($) {
    'use strict';

    $(function () {
        var $fullText = $('.admin-fullText');
        $('#admin-fullscreen').on('click', function () {
            $.AMUI.fullscreen.toggle();
        });

        $(document).on($.AMUI.fullscreen.raw.fullscreenchange, function () {
            $fullText.text($.AMUI.fullscreen.isFullscreen ? '退出全屏' : '开启全屏');
        });

        // 通知框
        $(".notification").addClass("show");
        setTimeout(function () {
            $(".notification").removeClass("show");
        }, 4000);

        $(".notification .close-btn").click(function () {
            $(".notification").removeClass("show");
        })
    });
})(jQuery);
