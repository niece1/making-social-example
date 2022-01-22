<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Posts\PostType;
use App\Events\PostWasCreated;
use App\Events\RepostWasUpdated;
use App\Models\Post;

class QuoteController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
    }
    
    public function store(Post $post, Request $request)
    {
        $repost = $request->user()->posts()->create([
            'type' => postType::QUOTE,
            'body' => $request->body,
            'original_post_id' => $post->id
        ]);

        broadcast(new PostWasCreated($repost));
        broadcast(new RepostWasUpdated($request->user(), $post));
    }
}
