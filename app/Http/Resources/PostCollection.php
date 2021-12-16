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
}
