<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostMedia;
use App\Http\Requests\MediaStoreRequest;
use App\Http\Resources\PostMediaCollection;

class MediaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function store(MediaStoreRequest $request)
    {
        $result = collect($request->media)->map(function ($media) {
            return $this->addMedia($media);
        });

        return new PostMediaCollection($result);
    }

    /**
     * Undocumented function
     *
     * @param [type] $media
     * @return void
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
