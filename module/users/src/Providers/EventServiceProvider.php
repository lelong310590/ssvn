<?php
/**
 * EventServiceProvider.php
 * Created by: trainheartnet
 * Created at: 20/07/2021
 * Contact me at: longlengoc90@gmail.com
 */


namespace Users\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Users\Events\ChangeUserCompanyEvent' => [
            'Users\Listeners\ChangeUserCompanyListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}