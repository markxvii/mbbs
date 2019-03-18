<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\EmailVerify;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function verify(Request $request)
    {
        $email = $request->input('email');
        $token = $request->input('token');
        if (!$email || !$token) {
            return redirect('/')->with('danger', '邮箱验证失败！');
        }

        if ($token != \Cache::get('email_verification_' . $email)) {
            return redirect('/')->with('danger', '服务器没有此token！');
        }

        if (!$user = User::where('email', $email)->first()) {
            return redirect('/')->with('danger', '用户不存在！');
        }
        
        \Cache::forget('email_verification'.$email);

        $user->update(['email_verified' => true]);

        return redirect('/')->with('success', '验证已成功！');
    }

    public function send_email(Request $request)
    {
        $user=$request->user();

        if ($user->email_verified) {
            return redirect('/')->with('danger', '你已经验证过了！');
        }
        $user->notify(new EmailVerify());
        return redirect('/')->with('success', '发送成功！');
    }

}

