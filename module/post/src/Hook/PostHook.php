<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 7/30/2018
 * Time: 2:56 PM
 */

namespace Post\Hook;

class PostHook
{
    public function handle()
    {
        echo view('nqadmin-post::partials.sidebar');
    }
}