//设置flash自动隐藏提示框
var hideFlash = function () {
    $(".flash_msg").fadeOut("slow");
}
setTimeout(hideFlash, 2000);


$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});