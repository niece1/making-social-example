<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Events\LikesWereUpdated;
use App\Notifications\PostLiked;

class LikeController extends Controller
{
    public function store(Post $post, Request $request)
    {
        //to prevent liking more then once
        if ($request->user()->hasLiked($post)) {
            return response(null, 409); //conflict error code
        }
        $request->user()->likes()->create([
            'post_id' => $post->id
        ]);
        if ($request->user()->id !== $post->user_id) {
            $post->user->notify(new PostLiked($request->user(), $post));
        }

        broadcast(new LikesWereUpdated($request->user(), $post));
    }

    public function destroy(Post $post, Request $request)
    {
        $request->user()->likes->where('post_id', $post->id)->first()->delete();

        broadcast(new LikesWereUpdated($request->user(), $post));
    }
}
