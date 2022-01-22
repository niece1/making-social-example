<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Posts\PostType;
use App\Models\Post;
use App\Models\PostMedia;
use App\Events\RepliesWereUpdated;

class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
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

        broadcast(new RepliesWereUpdated($post));
    }
}
