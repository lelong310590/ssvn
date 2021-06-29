<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 11/6/2017
 * Time: 10:27 PM
 */

namespace Cart\Providers;

use Cart\Hook\CartHook;
use Illuminate\Support\ServiceProvider;

class HookProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->booted(function () {
            $this->booted();
        });
    }

    public function register()
    {

    }

    private function booted()
    {
        add_action('nqadmin-register-menu', [CartHook::class, 'handle'], 50);
    }
}