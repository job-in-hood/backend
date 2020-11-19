<?php

namespace App\Listeners;

use App\Events\CompanyDeleted;
use App\Notifications\DeletedCompanyNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendDeletedCompanyNotification
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
     * @param CompanyDeleted $event
     * @return void
     */
    public function handle(CompanyDeleted $event)
    {
        $event->company->notify(new DeletedCompanyNotification($event->company));
    }
}
