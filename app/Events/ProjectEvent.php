<?php

namespace App\Events;

use App\Models\Project;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Project $project;
    public $notifyUser;
    public $notiName;

    /**
     * Create a new event instance.
     */
    public function __construct(Project $project, $notifyUser, $notiName)
    {
        $this->project = $project;
        $this->notifyUser = $notifyUser;
        $this->notiName = $notiName;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('project'),
        ];
    }
}
