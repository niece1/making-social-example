<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'body',
        'user_id',
        'type',
        'original_post_id',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Undocumented function
     *
     * @return void
     */
    public function originalPost()
    {
        return $this->hasOne(Post::class, 'id', 'original_post_id');
    }

    /**
     * Get likes associated with specified post.
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function reposts()
    {
        return $this->hasMany(Post::class, 'original_post_id');
    }

    public function repostedPost()
    {
        return $this->hasOne(Post::class, 'original_post_id', 'id');
    }

    /**
     * Undocumented function
     */
    public function media()
    {
        return $this->hasMany(PostMedia::class);
    }
}
