<?php

namespace App\Models;

use App\Posts\MediaTypes;
use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseMedia;

class Media extends BaseMedia
{
    public function type()
    {
        return MediaTypes::type($this->mime_type);
    }
}
