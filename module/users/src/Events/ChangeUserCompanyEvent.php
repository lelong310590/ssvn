<?php
/**
 * ChangeUserCompanyEvent.php
 * Created by: trainheartnet
 * Created at: 20/07/2021
 * Contact me at: longlengoc90@gmail.com
 */


namespace Users\Events;


class ChangeUserCompanyEvent
{
    public $user_id;

    public $type;

    public $newCompany;

    /**
     * ChangeUserCompanyEvent constructor.
     * @param $user_id
     * @param $type
     * @param $newCompany
     */
    public function __construct($user_id, $type, $newCompany)
    {
        $this->user_id = $user_id;
        $this->type = $type;
        $this->newCompany = $newCompany;
    }
}