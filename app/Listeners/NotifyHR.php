<?php

namespace App\Listeners;

use App\Events\FirstJobPosted;
use App\Mail\ModerationInProgress;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyHR
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
     * @param  FirstJobPosted  $event
     * @return void
     */
    public function handle(FirstJobPosted $event)
    {
        // Send an email to HR
        Mail::to($event->job->email)->send(new ModerationInProgress());
    }
}
