<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\VerificationCodeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Overtrue\EasySms\EasySms;
use Overtrue\EasySms\Exceptions\NoGatewayAvailableException;

class VerificationCodesController extends Controller
{
    public function store(VerificationCodeRequest $request,EasySms $easySms)
    {
        $captchaData = \Cache::get($request->captcha_key);
        if (!$captchaData) {
            return $this->response->error('图片验证码已失效！', 422);
        }

        if (!hash_equals($captchaData['code'], $request->captcha_code)) {
            //验证错误就清除缓存
            \Cache::forget($request->captcha_key);
            return $this->response->errorUnauthorized('验证码错误');
        }
        $phone = $captchaData['phone'];
        //增加用于开发环境的代码，节约短信费用
        if (!app()->environment('production')) {
            $code='1234';
        }else {
            //生成四位随机数，左侧补0
            $code = str_pad(random_int(1, 9999), 4, 0, STR_PAD_LEFT);

            try {
                $result = $easySms->send($phone, [
                    'content' => "【我的学习小窝】您的验证码是{$code}。如非本人操作，请忽略本短信"
                ]);
            } catch (NoGatewayAvailableException $exception) {
                $message = $exception->getException('yunpian')->getMessage();
                return $this->response->errorInternal($message ?: '短信发送失败！');
            }
        }

        $key = 'verificationCode_' . Str::random(15);
        \Cache::put($key, ['phone'=>$phone,'code'=>$code], 10);
        \Cache::forget($request->captcha_key);

        return $this->response->array(['key'=>$key,'expired_at'=>'10分鐘后過期',])->setStatusCode(201);
    }
}
