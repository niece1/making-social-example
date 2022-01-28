<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Post;
use App\Models\User;

class LikesWereUpdated implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    protected $user;
    protected $post;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, Post $post)
    {
        $this->user = $user;
        $this->post = $post;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('posts');
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function broadcastAs()
    {
        return 'LikesWereUpdated';
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function broadcastWith()
    {
        return [
            'id' => $this->post->id,
            'user_id' => $this->user->id,
            'count' => $this->post->likes->count(),
        ];
    }
}
