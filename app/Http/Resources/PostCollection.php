<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\PostResource;

class PostCollection extends ResourceCollection
{
    /**
     *
     * @var type
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

    public function with($request)
    {
        return [
            'meta' => [
                'likes' => $this->likes($request),
                'reposts' => $this->reposts($request),
            ]
        ];
    }

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
