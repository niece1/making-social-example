<?php

namespace App\Posts;

use App\Posts\FacilityTypes;

class FacilityExtractor
{
    /**
     * Mention or hashtag.
     *
     * @var string
     */
    protected $string;

    /**
     * Regular expression for facility type hashtag.
     *
     * @var string
     */
    public const HASHTAG_REGEX = '/(?!\s)#([A-Za-z]\w*)\b/';

    /**
     * Regular expression for facility type mention.
     *
     * @var string
     */
    public const MENTION_REGEX = '/(?=[^\w!])@(\w+)\b/';

    /**
     * Create a new instance.
     *
     * @param $string
     * @return void
     */
    public function __construct($string)
    {
        $this->string = $string;
    }

    /**
     * Extract hashtag facility.
     *
     * @return array
     */
    public function getHashtagFacilities()
    {
        return $this->buildFacilityCollection(
            $this->match(self::HASHTAG_REGEX),
            FacilityTypes::HASHTAG
        );
    }

    /**
     * Extract mention facility.
     *
     * @return array
     */
    public function getMentionFacilities()
    {
        return $this->buildFacilityCollection(
            $this->match(self::MENTION_REGEX),
            FacilityTypes::MENTION
        );
    }

    /**
     * Get hashtag and mention facilities.
     *
     * @return array
     */
    public function getAllFacilities()
    {
        return array_merge($this->getHashtagFacilities(), $this->getMentionFacilities());
    }

    /**
     * Create facility collection and populate model with data.
     *
     * @param array $facilities
     * @param string $type
     * @return array
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
     * Searches for all facility matches.
     *
     * @param string $pattern
     * @return array
     */
    protected function match($pattern)
    {
        preg_match_all($pattern, $this->string, $matches, PREG_OFFSET_CAPTURE);

        return $matches;
    }
}
