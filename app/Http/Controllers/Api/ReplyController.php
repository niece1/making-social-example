<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Posts\PostType;
use App\Models\Post;
use App\Models\PostMedia;
use App\Events\RepliesWereUpdated;
use App\Notifications\PostReplied;
use App\Http\Resources\PostCollection;

class ReplyController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth:sanctum'])->only(['store']);
    }

    /**
     * Show all replies for particular post.
     *
     * @param \App\Models\Post $post
     * @return PostCollection|\Illuminate\Http\JsonResponse
     */
    public function index(Post $post)
    {
        return new PostCollection($post->replies);
    }
    
    /**
     * Store a new reply.
     *
     * @param \App\Models\Post $post
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Post $post, Request $request)
    {
        $reply = $request->user()->posts()->create(array_merge($request->only('body'), [
            'type' => PostType::POST,
            'parent_id' => $post->id,
        ]));
        foreach ($request->media as $id) {
            $reply->media()->save(PostMedia::find($id));
        }
        if ($request->user()->id !== $post->user_id) {
            $post->user->notify(new PostReplied($request->user(), $reply));
        }

        broadcast(new RepliesWereUpdated($post));
    }
}
