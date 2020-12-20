<?php

namespace App\Providers;

use App\Events\CompanyCreated;
use App\Events\CompanyDeleted;
use App\Events\JobCreated;
use App\Events\JobDeleted;
use App\Listeners\SendDeletedCompanyNotification;
use App\Listeners\SendNewCompanyNotification;
use App\Listeners\SendNewJobNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        CompanyCreated::class => [
            SendNewCompanyNotification::class
        ],
        CompanyDeleted::class => [
            SendDeletedCompanyNotification::class
        ],
        JobCreated::class => [
            SendNewJobNotification::class
        ],
        JobDeleted::class => [
            //
        ]
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
