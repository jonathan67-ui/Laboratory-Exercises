<?php

namespace App\Providers;

use App\Events\InventoryRecorded;
use App\Listeners\SendLowStockAlert;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        InventoryRecorded::class => [
            SendLowStockAlert::class,
        ],

        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    public function boot()
    {
        //
    }
}