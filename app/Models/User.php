<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Post;
use App\Posts\PostType;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Whom we are following.
     */
    public function following()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'following_id');
    }

    /**
     * Who's following us.
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'following_id', 'user_id');
    }

    /**
     * Get all posts of the follower.
     */
    public function postsFromFollowing()
    {
        return $this->hasManyThrough(
            Post::class,
            Follower::class,
            'user_id',
            'user_id',
            'id',
            'following_id'
        );
    }

    /**
     * Get avatars from specified below service.
     *
     * @return string
     */
    public function avatar()
    {
        return 'https://www.gravatar.com/avatar/' . md5($this->email) . '?d=mp';
    }

    /**
     * Get posts associated with specified user.
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    
    /**
     * Get likes associated with specified user.
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Check if a user has liked a post to prevent liking more then once.
     *
     * @param Post $post
     * @return boolean
     */
    public function hasLiked(Post $post)
    {
        return $this->likes->contains('post_id', $post->id);
    }
    
    /**
     * Get reposts associated with specified user.
     */
    public function reposts()
    {
        return $this->hasMany(Post::class)
            ->where('type', PostType::REPOST)
            ->orWhere('type', PostType::QUOTE);
    }
}
