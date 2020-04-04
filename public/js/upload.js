//文件上传
var opts = {
    url: "/admin/photos",
    type: "POST",
    success: function (result) {
        $("input[name='image']").val(result.image_url);
        $("#img_show").attr("src", result.image_url);
    },
    error: function () {
        alert('文件上传失败');
    }
};

$('#image_upload').fileUpload(opts);