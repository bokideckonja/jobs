<?php

namespace App\Listeners;

use App\Events\FirstJobPosted;
use App\Mail\ModerationInProgress;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

// Listeners that send Mails should allways be queued, becouse actions like that take lot of time
// to execute, i have implemented ShouldQueue interface, but since sync driver set as queue
// driver for this project, it has no efect...to test, symply install and set redis...or some other.
class NotifyHR implements ShouldQueue
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
        // Send an email to HR provided mail
        Mail::to($event->job->email)->send(new ModerationInProgress());
    }
}
