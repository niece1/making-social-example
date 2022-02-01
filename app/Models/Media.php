<?php

namespace App\Models;

use App\Posts\MediaTypes;
use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseMedia;

class Media extends BaseMedia
{
    /**
     * Get types of media that only meet MediaTypes requirements.
     *
     * @return array
     */
    public function type()
    {
        return MediaTypes::type($this->mime_type);
    }
}
