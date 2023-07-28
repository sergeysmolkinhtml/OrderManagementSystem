<?php

namespace App\Listeners;

use App\Events\ProjectEvent;
use App\Notifications\ProjectCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class ProjectListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * @param ProjectEvent $event
     * @return void
     */
    public function handle(ProjectEvent $event): void
    {
        if($event->notiName == 'ProjectCreatedNotification') {
            Notification::send($event->notifyUser, new ProjectCreatedNotification($event->project));
        }
    }
}
