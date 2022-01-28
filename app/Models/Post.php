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

    public function replies()
    {
        return $this->hasMany(Post::class, 'parent_id');
    }

    /**
     * Undocumented function
     *
     * @param Builder $builder
     * @return void
     */
    public function scopeParent(Builder $builder)
    {
        return $builder->whereNull('parent_id');
    }

    /**
     * Undocumented function
     */
    public function facilities()
    {
        return $this->hasMany(Facility::class);
    }

    public static function boot()
    {
        parent::boot();
        static::created(function (Post $post) {
            $post->facilities()->createMany(
                (new FacilityExtractor($post->body))->getAllFacilities()
            );
        });
    }

    public function mentions()
    {
        return $this->hasMany(Facility::class)
            ->whereType(FacilityTypes::MENTION);
    }

    public function parentPost()
    {
        return $this->belongsTo(Post::class, 'parent_id');
    }

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
