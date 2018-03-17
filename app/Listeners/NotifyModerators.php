<?php

namespace App\Listeners;

use App\User;
use App\Events\FirstJobPosted;
use App\Mail\ModerationNeeded;
use App\Mail\ModerationInProgres;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyModerators
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
        // Get all moderators
        $moderator = User::first();
        // Send an email to moderators
        Mail::to($moderator->email)->send(new ModerationNeeded($event->job->moderate_token));
    }
}
