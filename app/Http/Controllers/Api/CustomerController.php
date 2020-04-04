<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Hash;
use \Qiniu\Auth;
use Cache;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:customers', ['except' => ['login', 'send', 'reset_password']]);
    }

    /***
     * 登录
     * 前端需传手机号和密码
     * @param Request $request
     */
    public function login(Request $request)
    {
        $mobile = $request->mobile;
        $password = $request->password;

        if (!$mobile || !$password) {
            return response()->json(['success' => false, 'message' => '账号或密码必填！']);
        }

        $customer = Customer::where('mobile', $mobile)->first();
        if (!$customer) {
            return response()->json(['success' => false, 'message' => '此用户不存在！']);
        }

        if (!Hash::check($password, $customer->password)) {
            return response()->json(['success' => false, 'message' => '密码填写错误！']);
        }

        $credentials = request(['mobile', 'password']);
        $token = auth('customers')->attempt($credentials);
        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Log the admin out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('customers')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth('customers')->factory()->getTTL() * 60
        ]);
    }

    /***
     * 发送短信接口
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(Request $request)
    {
//        $ak = "fAotwAkyCf3pp-v7lx9katOiZiwYE6KCHyy7fWg4";
//        $sk = "dkCY3RGS3ZXK4KS464JZKg17826-vZPQ7zwn2dp2";
//        $auth = new Auth($ak, $sk);
//        $client = new \Qiniu\Sms\Sms($auth);
//
//        //发送信息模块
//        $template_id = "1235438149216243712";
//        $mobiles = array($request->mobile);
//
//        if ($request->mobile == "") {
//            return response()->json(['success' => false, 'message' => '请填写手机号！']);
//        }
//        if (!preg_match("/^1[34578]\d{9}$/", $request->mobile)) {
//            return response()->json(['success' => false, 'message' => '手机号格式不正确！']);
//        }
//
//        $code = $this->GetRandStr(4);  // 随机生成短信验证码code，4代表验证码长度
//        Cache::put('code', $code, 300);  // 把code存入缓存,5分钟内有效
//        try {
//            //发送短信
//            $resp = $client->sendMessage($template_id, $mobiles, ['code' => $code]);
//            if ($resp) {
//                return response()->json(['success' => true, 'message' => '验证码已发送至您的手机！']);
//            }
//        } catch (\Exception $e) {
//            echo "Error:", $e, "\n";
//        }

        $phone = $request->mobile;
        if ($phone == "") {
            return response()->json(['success' => false, 'message' => '请填写手机号！']);
        }
        if (!preg_match("/^1[34578]\d{9}$/", $phone)) {
            return response()->json(['success' => false, 'message' => '手机号格式不正确！']);
        }
        $code = $this->GetRandStr(4);
        Cache::put('code', $code, 300);  // 把code存入缓存,5分钟内有效
        $msg = "您正在修改密码，短信验证码为：" . $code . "。该验证码5分钟内有效！";
        $res = NewSms($phone, $msg);
        if ($res) {
            return response()->json(['success' => true, 'message' => '验证码已发送至您的手机！']);
        }
    }


    /***
     * 自定义方法生成随机验证码
     * @param $len
     * @return string
     */
    private function GetRandStr($len)
    {
        $chars = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
        $charsLen = count($chars) - 1;
        shuffle($chars);
        $output = "";
        for ($i = 0; $i < $len; $i++) {
            $output .= $chars[mt_rand(0, $charsLen)];
        }
        return $output;
    }


    /***
     * 重设密码
     */
    public function reset_password(Request $request)
    {
        $mobile = $request->mobile;

        // 验证手机号是否存在
        $customer = Customer::where('mobile', $request->mobile)->first();
        if (!$customer) {
            return response()->json(['success' => false, 'message' => '手机号不存在！']);
        }

        $code = Cache::get('code');  //从缓存中获取code
        if (!$code) {
            return response()->json(['success' => false, 'message' => '请获取短信验证码！']);
        }
        if ($code != $request->code) {
            return response()->json(['success' => false, 'message' => '验证码填写错误！']);
        }

        $password = Hash::make($request->password);

        Customer::where('mobile', $mobile)->update(['password' => $password]);
        Cache::forget('code');  // 修改成功后清除缓存

        return response()->json(['success' => true, 'message' => '密码已重置']);
    }
}
