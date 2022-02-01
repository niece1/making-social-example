<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PostCollection;

class TimelineController extends Controller
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
     * Get a list of posts for a timeline.
     *
     * @param Request $request
     * @return PostCollection|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $posts = $request->user()
                ->postsFromFollowing()
                ->parent()
                ->latest()
                ->with(['user', 'likes', 'reposts', 'replies', 'facilities', 'media.baseMedia',
                    'originalPost.user', 'originalPost.likes', 'originalPost.reposts',
                    'originalPost.media.baseMedia',])
                ->paginate(5);

        return new PostCollection($posts);
    }
}
