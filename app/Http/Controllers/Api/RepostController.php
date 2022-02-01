<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Posts\PostType;
use App\Events\PostWasCreated;
use App\Events\RepostWasUpdated;
use App\Events\PostWasDeleted;

class RepostController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
    }
    
    /**
     * Store a new repost.
     *
     * @param \App\Models\Post $post
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Post $post, Request $request)
    {
        $repost = $request->user()->posts()->create([
            'type' => PostType::REPOST,
            'original_post_id' => $post->id
        ]);
        broadcast(new PostWasCreated($repost));
        broadcast(new RepostWasUpdated($request->user(), $post));
    }
    
    /**
     * Delete (unrepost) a post.
     *
     * @param  \App\Models\Post  $post
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Post $post, Request $request)
    {
        broadcast(new PostWasDeleted($post->repostedPost));
        $post->repostedPost()->where('user_id', $request->user()->id)->delete();
        broadcast(new RepostWasUpdated($request->user(), $post));
    }
}
