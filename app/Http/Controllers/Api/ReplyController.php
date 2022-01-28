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
    public function __construct()
    {
        $this->middleware(['auth:sanctum'])->only(['store']);
    }
    
    /**
     * Show all replies for particular post.
     *
     *
     */
    public function index(Post $post)
    {
        return new PostCollection($post->replies);
    }

    public function store(Post $post, Request $request)
    {
        $reply = $request->user()->posts()->create(array_merge($request->only('body'), [
            'type' => PostType::POST,
            'parent_id' => $post->id,
        ]));

        foreach($request->media as $id) {
            $reply->media()->save(PostMedia::find($id));
        }

        if ($request->user()->id !== $post->user_id) {
            $post->user->notify(new PostReplied($request->user(), $reply));
        }

        broadcast(new RepliesWereUpdated($post));
    }
}
