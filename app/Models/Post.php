<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Posts\FacilityExtractor;
use App\Posts\FacilityTypes;

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
        'parent_id',
    ];
    
    /**
     * Get user record that owns the post.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get original post id of the post.
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
    
    /**
     * Get reposts associated with specified post.
     */
    public function reposts()
    {
        return $this->hasMany(Post::class, 'original_post_id');
    }
    
    /**
     * Reposted post has one original post.
     */
    public function repostedPost()
    {
        return $this->hasOne(Post::class, 'original_post_id', 'id');
    }

    /**
     * Get medias associated with specified post.
     */
    public function media()
    {
        return $this->hasMany(PostMedia::class);
    }
    
    /**
     * Get replies associated with specified post.
     */
    public function replies()
    {
        return $this->hasMany(Post::class, 'parent_id');
    }

    /**
     * Scope a query to only include original posts.
     *
     * @param Builder $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeParent(Builder $builder)
    {
        return $builder->whereNull('parent_id');
    }

    /**
     * Get facilities associated with specified post.
     */
    public function facilities()
    {
        return $this->hasMany(Facility::class);
    }
    
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();
        static::created(function (Post $post) {
            $post->facilities()->createMany(
                (new FacilityExtractor($post->body))->getAllFacilities()
            );
        });
    }
    
    /**
     * Get mentions associated with specified post.
     */
    public function mentions()
    {
        return $this->hasMany(Facility::class)
            ->whereType(FacilityTypes::MENTION);
    }
    
    /**
     * Get a parent post of the current post.
     */
    public function parentPost()
    {
        return $this->belongsTo(Post::class, 'parent_id');
    }
    
    /**
     * Get parent post collection.
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function parents()
    {
        $base = $this;
        $parents = [];
        while ($base->parentPost) {
            $parents[] = $base->parentPost;
            $base = $base->parentPost;
        }
        return collect($parents);
    }
}
