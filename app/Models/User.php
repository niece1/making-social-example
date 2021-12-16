<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
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
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    /**
     * Whom we are following
     */
    public function following()
    {
        return $this->belongsToMany(
            User::class,
            'followers',
            'user_id',
            'following_id'
        );
    }
    
    /**
     * Who's following us
     */
    public function followers()
    {
        return $this->belongsToMany(
            User::class, 
            'followers',
            'following_id',
            'user_id'
        );
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
}
