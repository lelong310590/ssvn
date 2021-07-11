<?php
/**
 * CreateUserWhenCreateCompany.php
 * Created by: trainheartnet
 * Created at: 10/07/2021
 * Contact me at: longlengoc90@gmail.com
 */


namespace Base\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CreateUserWhenCreateCompany extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Đăng ký tài khoản thành công!')
            ->view('nqadmin-dashboard::mail.content.user.create_user_when_company', [
                'user' => $this->user,
                'password' => $this->password
            ]);
    }
}