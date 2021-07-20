<?php
/**
 * ChangeUserCompanyListener.php
 * Created by: trainheartnet
 * Created at: 20/07/2021
 * Contact me at: longlengoc90@gmail.com
 */


namespace Users\Listeners;

use Cart\Models\UserSubject;
use Course\Models\Certificate;
use Users\Events\ChangeUserCompanyEvent;

class ChangeUserCompanyListener
{
    public function __construct()
    {

    }

    public function handle(ChangeUserCompanyEvent $event)
    {
        $user = $event->user_id;
        $type = $event->type;
        $newCompany = $event->newCompany;

        Certificate::whereIn('user_id', $user)
                    ->where('type', $type)
                    ->update([
                        'company_id' => $newCompany
                    ]);

        UserSubject::whereIn('user', $user)
                    ->where('type', $type)
                    ->update([
                        'company' => $newCompany
                    ]);
    }
}