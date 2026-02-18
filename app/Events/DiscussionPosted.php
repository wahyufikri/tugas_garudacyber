<?php

namespace App\Events;

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Broadcasting\Channel;

class DiscussionPosted implements ShouldBroadcast
{
    public $discussion;

    public function __construct($discussion)
    {
        $this->discussion = $discussion;
    }

    public function broadcastOn()
    {
        return new Channel('course.' . $this->discussion->course_id);
    }

    public function broadcastAs()
    {
        return 'discussion.posted';
    }
}

