<?php

namespace App\Posts;

use App\Posts\FacilityTypes;

class FacilityExtractor
{
    /**
     * Undocumented variable
     *
     * @var [type]
     */
    protected $string;

    /**
     *
     */
    public const HASHTAG_REGEX = '/(?!\s)#([A-Za-z]\w*)\b/';

    /**
     *
     */
    public const MENTION_REGEX = '/(?=[^\w!])@(\w+)\b/';

    /**
     * Undocumented function
     *
     * @param [type] $string
     */
    public function __construct($string)
    {
        $this->string = $string;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getHashtagFacilities()
    {
        return $this->buildFacilityCollection(
            $this->match(self::HASHTAG_REGEX),
            FacilityTypes::HASHTAG
        );
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getMentionFacilities()
    {
        return $this->buildFacilityCollection(
            $this->match(self::MENTION_REGEX),
            FacilityTypes::MENTION
        );
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getAllFacilities()
    {
        return array_merge($this->getHashtagFacilities(), $this->getMentionFacilities());
    }

    /**
     * Undocumented function
     *
     * @param [type] $facilities
     * @param [type] $type
     * @return void
     */
    protected function buildFacilityCollection($facilities, $type)
    {
        return array_map(function ($facility, $index) use ($facilities, $type) {
            return [
                'body' => $facility[0],
                'body_plain' => $facilities[1][$index][0],
                'start' => $start = $facility[1],
                'end' => $start + strlen($facility[0]),
                'type' => $type
            ];
        }, $facilities[0], array_keys($facilities[0]));
    }

    /**
     * Undocumented function
     *
     * @param [type] $pattern
     * @return void
     */
    protected function match($pattern)
    {
        preg_match_all($pattern, $this->string, $matches, PREG_OFFSET_CAPTURE);

        return $matches;
    }
}
