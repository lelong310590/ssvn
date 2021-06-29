<?php

namespace Base\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Users\Models\Users;

class ReserPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $new_pass;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Users $user, $new_pass)
    {
        $this->user = $user;
        $this->new_pass = $new_pass;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Mật khẩu mới đã được tạo!')->view('nqadmin-dashboard::mail.content.user.password_changed');
    }
}
