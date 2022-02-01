<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Posts\MediaTypes;

class MediaTypesController extends Controller
{
    /**
     * Fetch a media types array.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json([
            'data' => [
                'image' => MediaTypes::$image,
                'video' => MediaTypes::$video,
            ]
        ]);
    }
}
