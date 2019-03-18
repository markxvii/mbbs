<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Str;

class EmailVerify extends Notification implements ShouldQueue
{
    use Queueable;


    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $token = Str::random(10);
        \Cache::put('email_verification_'.$notifiable->email, $token, 10);
        $url=route('email_verification',['email'=>$notifiable->email,'token'=>$token]);
        return (new MailMessage)
                    ->greeting($notifiable->name.'您好！')
                    ->subject('注册成功，请验证您的邮箱！')
                    ->line('请点击下面的链接来验证！')
                    ->action('验证', $url);
    }
}
