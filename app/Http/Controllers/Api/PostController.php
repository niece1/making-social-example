<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostStoreRequest;
use Illuminate\Http\Request;
use App\Events\PostWasCreated;
use App\Models\Post;
use App\Posts\PostType;

class PostController extends Controller
{
    /**
     * Undocumented function
     */
    public function __construct()
    {
        $this->middleware(['auth:sanctum'])->only(['store']);
    }
    
    /**
     * Undocumented function
     *
     * @param PostStoreRequest $request
     * @return void
     */
    public function store(PostStoreRequest $request)
    {
        $post = $request->user()->posts()->create(array_merge($request->only('body'), [
            'type' => PostType::POST
        ]));
        
        broadcast(new PostWasCreated($post));
    }
}
