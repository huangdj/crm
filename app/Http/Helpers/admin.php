<?php
/***
 * 根据当前时间显示礼貌提示语
 * @return string
 */
function getTime()
{
    $no = date("H", time());
    if ($no >= 0 && $no <= 6) {
        return "凌晨好";
    }
    if ($no > 6 && $no < 12) {
        return "上午好";
    }
    if ($no >= 12 && $no < 13) {
        return "中午好";
    }
    if ($no >= 13 && $no <= 18) {
        return "下午好";
    }
    if ($no > 18 && $no <= 24) {
        return "晚上好";
    }
    return "您好";
}

/***
 * 短信验证码
 * @param $phone
 * @param $msg
 * @return bool|string
 */
function NewSms($phone, $msg)
{
    $url = "http://service.winic.org:8009/sys_port/gateway/index.asp?";
    $data = "id=%s&pwd=%s&to=%s&content=%s&time=";
    $id = 'cw199278';
    $pwd = 'x929711';
    $to = $phone;
    $content = iconv("UTF-8", "GB2312", $msg);
    $rdata = sprintf($data, $id, $pwd, $to, $content);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $rdata);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    $result = substr($result, 0, 3);
    return $result;
}




