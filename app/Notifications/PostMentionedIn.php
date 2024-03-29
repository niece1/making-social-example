<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Post;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Resources\PostResource;
use App\Notifications\DatabaseNotificationChannel;

class PostMentionedIn extends Notification
{
    use Queueable;

    /**
     * The user instance.
     *
     * @var \App\Models\User
     */
    protected $user;

    /**
     * The post instance.
     *
     * @var \App\Models\Post
     */
    protected $post;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function __construct(User $user, Post $post)
    {
        $this->user = $user;
        $this->post = $post;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [
            DatabaseNotificationChannel::class
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'user' => new UserResource($this->user),
            'post' => new PostResource($this->post),
        ];
    }
}
