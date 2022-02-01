<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostMedia;
use App\Http\Requests\MediaStoreRequest;
use App\Http\Resources\PostMediaCollection;

class MediaController extends Controller
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
     * Store a new media.
     *
     * @param  \App\Http\Requests\MediaStoreRequest  $request
     * @return PostMediaCollection|\Illuminate\Http\JsonResponse
     */
    public function store(MediaStoreRequest $request)
    {
        $result = collect($request->media)->map(function ($media) {
            return $this->addMedia($media);
        });

        return new PostMediaCollection($result);
    }

    /**
     * Add array of media to the post.
     *
     * @param \App\Models\Media $media
     * @return array $postMedia
     */
    protected function addMedia($media)
    {
        $postMedia = PostMedia::create([]);
        $postMedia->baseMedia()
            ->associate($postMedia->addMedia($media)->toMediaCollection())
            ->save();

        return $postMedia;
    }
}
