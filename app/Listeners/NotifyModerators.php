<?php

namespace App\Listeners;

use App\User;
use App\Events\FirstJobPosted;
use App\Mail\ModerationNeeded;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

// Listeners that send Mails should allways be queued, becouse actions like that take lot of time
// to execute, i have implemented ShouldQueue interface, but since sync driver set as queue
// driver for this project, it has no efect...to test, symply install and set redis...or some other.
class NotifyModerators implements ShouldQueue
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
        // Get first moderator for now, we could select a range of moderators here
        // And pass mail to all of them, but for now, keep it simple
        $moderator = User::firstOrFail();
        // Send an email to first moderator, and pass $job to mail
        Mail::to($moderator->email)->send(new ModerationNeeded($event->job));
    }
}
