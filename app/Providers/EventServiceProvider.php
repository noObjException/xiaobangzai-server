<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\CreateMissionOrder' => [],
        'App\Events\PayMissionOrder' => [],
        'App\Events\CompletedMissionOrder' => [],
        'App\Events\AcceptMissionOrder' => [],
        'App\Events\CancelMissionOrder' => []
    ];

    /**
     * 需要注册的订阅者类。
     *
     * @var array
     */
    protected $subscribe = [
        'App\Listeners\OrderStatusMessageSubscriber',
        'App\Listeners\BalanceSubscriber',
        'App\Listeners\PointSubscriber'
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
