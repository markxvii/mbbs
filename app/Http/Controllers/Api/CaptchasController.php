<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CaptchaRequest;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CaptchasController extends Controller
{
    public function store(CaptchaRequest $request, CaptchaBuilder $builder)
    {
        $key = 'captcha-' . Str::random(15);
        $phone = $request->phone;

        $captcha = $builder->build();
        \Cache::put($key, ['phone'=>$phone,'code'=>$captcha->getPhrase()], 10);

        return $this->response
            ->array(['captcha_key' => $key, 'expired_at' => '5分钟后过期', 'captcha_image_content' => $captcha->inline()])
            ->setStatusCode(201);
    }
}
