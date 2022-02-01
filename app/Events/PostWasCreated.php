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
use App\Http\Resources\PostResource;

class PostWasCreated implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;
    
    /**
     * The post instance.
     *
     * @var \App\Models\Post
     */
    protected $post;

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Overrides default event name given by the Laravel exposed in Websockets dashboard.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'PostWasCreated';
    }

    /**
     * Get serialized exact post structure we use in Vue component.
     *
     * @return void
     */
    public function broadcastWith()
    {
        return (new PostResource($this->post))->jsonSerialize();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array (array or single channel)
     */
    public function broadcastOn()
    {
        return $this->post->user->followers->map(function ($user) {
            return new PrivateChannel('timeline.' . $user->id);
        })->toArray();
    }
}
