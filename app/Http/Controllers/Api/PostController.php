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
use App\Notifications\PostMentionedIn;

class PostController extends Controller
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
     * Get a post list of the particular user.
     *
     * @param Request $request
     * @return PostCollection|\Illuminate\Http\JsonResponse
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
     * Get a specified post.
     *
     * @param \App\Models\Post $post
     * @return PostCollection|\Illuminate\Http\JsonResponse
     */
    public function show(Post $post)
    {
        return new PostCollection(collect([$post])->merge($post->parents()));
    }

    /**
     * Store a new post.
     *
     * @param \App\Http\Requests\PostStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PostStoreRequest $request)
    {
        $post = $request->user()->posts()->create(array_merge($request->only('body'), [
            'type' => PostType::POST
        ]));
        foreach ($request->media as $id) {
            $post->media()->save(PostMedia::find($id));
        }
        foreach ($post->mentions->users() as $user) {
            if ($request->user()->id !== $user->id) {
                $user->notify(new PostMentionedIn($request->user(), $post));
            }
        }

        broadcast(new PostWasCreated($post));
    }
}
