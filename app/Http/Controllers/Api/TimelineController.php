<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PostCollection;

class TimelineController extends Controller
{
    public function index(Request $request)
    {
        $posts = $request->user()->postsFromFollowing()->get();
        
        return new PostCollection($posts);
    }
}
