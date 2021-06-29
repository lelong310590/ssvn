<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 11/6/2017
 * Time: 10:47 PM
 */

namespace Cart\Hook;

class CartHook
{
    public function handle()
    {
        echo view('nqadmin-cart::backend.partials.sidebar');
    }
}