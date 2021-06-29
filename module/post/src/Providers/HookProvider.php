<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 7/30/2018
 * Time: 2:51 PM
 */

namespace Post\Providers;

use Illuminate\Support\ServiceProvider;
use Post\Hook\PostHook;

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
        add_action('nqadmin-register-menu', [PostHook::class, 'handle'], 12);
    }
}