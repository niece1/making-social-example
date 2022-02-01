<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\PostResource;

class PostCollection extends ResourceCollection
{
    /**
     * The resource that this resource collects.
     *
     * @var string
     */
    public $collects = PostResource::class;

    /**
     * Transform the resource collection into an array and wraps into data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection
        ];
    }
    
    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function with($request)
    {
        return [
            'meta' => [
                'likes' => $this->likes($request),
                'reposts' => $this->reposts($request),
            ]
        ];
    }
    
    /**
     * Get users likes associated with post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function likes($request)
    {
        //if user not logged in, we don't need it's likes number so we return empty array
        if (!$user = $request->user()) {
            return [];
        }
        return $user->likes()
            ->whereIn(
                'post_id',
                $this->collection->pluck('id')->merge($this->collection->pluck('original_post_id'))
            )
            ->pluck('post_id')
            ->toArray();
    }
    
    /**
     * Get users reposts associated with post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function reposts($request)
    {
        if (!$user = $request->user()) {
            return [];
        }
        return $user->reposts()
            ->whereIn(
                'original_post_id',
                $this->collection->pluck('id')->merge($this->collection->pluck('original_post_id'))
            )
            ->pluck('original_post_id')
            ->toArray();
    }
}
