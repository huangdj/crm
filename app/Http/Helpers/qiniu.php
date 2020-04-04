<?php
// 引入鉴权类
use Qiniu\Auth;
// 引入上传类
use Qiniu\Storage\UploadManager;

function qiniu_upload($filePath)
{
    $accessKey = "fAotwAkyCf3pp-v7lx9katOiZiwYE6KCHyy7fWg4";
    $secretKey = "dkCY3RGS3ZXK4KS464JZKg17826-vZPQ7zwn2dp2";
    $bucket = "huangdj";
    $auth = new Auth($accessKey, $secretKey);
    $token = $auth->uploadToken($bucket);
    // 上传到七牛后保存的文件名
    $key = basename($filePath);
    // 初始化 UploadManager 对象并进行文件的上传。
    $uploadMgr = new UploadManager();
    // 调用 UploadManager 的 putFile 方法进行文件的上传。
    $uploadMgr->putFile($token, $key, $filePath);
    unlink($filePath);
}