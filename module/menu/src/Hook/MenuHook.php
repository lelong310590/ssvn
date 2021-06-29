<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 8/1/2018
 * Time: 2:04 PM
 */

namespace Menu\Hook;

class MenuHook
{
    public function handle()
    {
        echo view('nqadmin-menu::partials.sidebar');
    }
}