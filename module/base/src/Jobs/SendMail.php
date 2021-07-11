<?php
/**
 * SendMail.php
 * Created by: trainheartnet
 * Created at: 11/07/2021
 * Contact me at: longlengoc90@gmail.com
 */

namespace Base\Jobs;

use Base\Mail\CreateUserWhenCreateCompany;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    protected $password;

    public function __construct($user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    public function handle()
    {
        $email = new CreateUserWhenCreateCompany($this->user, $this->password);
        Mail::to($this->user->email)->send($email);
    }

}