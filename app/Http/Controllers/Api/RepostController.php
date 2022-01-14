<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Posts\PostType;

class RepostController extends Controller
{
    public function store(Post $post, Request $request)
    {
        $repost = $request->user()->posts()->create([
            'type' => PostType::REPOST,
            'original_post_id' => $post->id
        ]);
    }

    public function destroy(Post $post, Request $request)
    {
        $post->repostedPost()->where('user_id', $request->user()->id)->delete();
    }
}
