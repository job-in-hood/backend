<?php

namespace App\Listeners;

use App\Events\JobCreated;
use App\Notifications\NewJobNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNewJobNotification
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
     * @param  JobCreated  $event
     * @return void
     */
    public function handle(JobCreated $event)
    {
        $event->job->notify(new NewJobNotification($event->job));
    }
}
