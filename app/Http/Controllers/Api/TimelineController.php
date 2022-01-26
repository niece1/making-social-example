<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PostCollection;

class TimelineController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
    }
    
    public function index(Request $request)
    {
        $posts = $request->user()
                ->postsFromFollowing()
                ->parent()
                ->latest()
                ->with(['user', 'likes', 'reposts', 'replies', 'facilities', 'media.baseMedia', 'originalPost.user', 'originalPost.likes', 'originalPost.reposts', 'originalPost.media.baseMedia',])
                ->paginate(5);
        
        return new PostCollection($posts);
    }
}
