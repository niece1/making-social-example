<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostStoreRequest;
use Illuminate\Http\Request;
use App\Events\PostWasCreated;
use App\Models\Post;
use App\Posts\PostType;
use App\Models\PostMedia;
use App\Http\Resources\PostCollection;

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
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $posts = Post::with([
            'user',
            'likes',
            'reposts',
            'replies',
            'media.baseMedia',
            'originalPost.user',
            'originalPost.likes',
            'originalPost.reposts',
            'originalPost.media.baseMedia',
        ])
            ->find(explode(',', $request->ids));

        return new PostCollection($posts);
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
        foreach($request->media as $id) {
            $post->media()->save(PostMedia::find($id));
        }
        
        broadcast(new PostWasCreated($post));
    }
}
