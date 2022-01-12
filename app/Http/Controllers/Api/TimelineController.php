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
                ->latest()
                ->with(['user', 'likes'])
                ->paginate(5);
        
        return new PostCollection($posts);
    }
}
