<?php

namespace Auth\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    //Places this task to a queue if its enabled
    use Queueable;

    //Token handler
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    //Notifications sent via email
    public function via($notifiable)
    {
        return ['mail'];
    }

    //Content of email sent to the Seller
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('Bạn nhận được 1 yêu cầu làm mới mật khẩu.')
            ->action('làm mới mật khẩu', url(config('app.url') . route('password.reset.get', $this->token, false)))
            ->line('Nếu bạn không gửi yêu cầu, hay bỏ qua tin nhắn này.');
    }

}