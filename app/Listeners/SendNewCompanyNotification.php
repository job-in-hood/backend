<?php

namespace App\Listeners;

use App\Events\CompanyCreated;
use App\Notifications\NewCompanyNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNewCompanyNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CompanyCreated  $event
     * @return void
     */
    public function handle(CompanyCreated $event)
    {
        $event->company->notify(new NewCompanyNotification($event->company));
    }
}
