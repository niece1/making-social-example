<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostStoreRequest;
use Illuminate\Http\Request;
use App\Events\PostWasCreated;
use App\Models\Post;

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
        $post = $request->user()->posts()->create($request->only('body'));
        
        broadcast(new PostWasCreated($post));
    }
}
