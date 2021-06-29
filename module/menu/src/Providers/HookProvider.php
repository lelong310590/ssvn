<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 8/1/2018
 * Time: 1:58 PM
 */

namespace Menu\Providers;

use Illuminate\Support\ServiceProvider;
use Menu\Hook\MenuHook;

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

    public function booted()
    {
        add_action('nqadmin-register-menu', [MenuHook::class, 'handle'], 15);
    }
}