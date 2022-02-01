<?php

namespace App\Posts;

class MediaTypes
{
    /**
     * The image type attributes.
     *
     * @var array
     */
    public static $image = [
        'image/png',
        'image/jpg',
        'image/jpeg',
    ];
    
    /**
     * The image video attributes.
     *
     * @var array
     */
    public static $video = [
        'video/mp4',
    ];
    
    /**
     * Get a media type.
     *
     * @return string|null
     */
    public static function type($mime)
    {
        if (in_array($mime, self::$image)) {
            return 'image';
        }
        if (in_array($mime, self::$video)) {
            return 'video';
        }
        return null;
    }
    
    /**
     * Get both image and video types of media in single array.
     *
     * @return array
     */
    public static function all()
    {
        return array_merge(self::$image, self::$video);
    }
}
