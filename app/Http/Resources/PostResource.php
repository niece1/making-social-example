<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\MediaCollection;
use App\Http\Resources\FacilityCollection;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'body' => $this->body,
            'type' => $this->type,
            'user' => new UserResource($this->user),
            'likes_count' => $this->likes->count(),
            'reposts_count' => $this->reposts->count(),
            'original_post' => new PostResource($this->originalPost),
            'media' => new MediaCollection($this->media),
            'replies_count' => $this->replies->count(),
            'facilities' => new FacilityCollection($this->facilities),
            'parent_id' => $this->parent_id,
            'parent_ids' => $this->parents()->pluck('id')->toArray(),
            'replying_to' => optional(optional($this->parentPost)->user)->username,
            'created_at' => $this->created_at->timestamp,
        ];
    }
}
