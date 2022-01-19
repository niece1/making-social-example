<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class PostMedia extends Model implements HasMedia
{
    use HasFactory;
    use HasMediaTrait;

    public function baseMedia()
    {
        return $this->belongsTo(Media::class, 'media_id');
    }
}
