<?php

namespace App\Posts;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

/**
 * Custom  Eloquent Collection.
 *
 * @author Volodymyr Zhonchuk
 */
class FacilityDatabaseCollection extends Collection
{
    /**
     * Get a user collection where username associated with facilities' body_plain record.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function users()
    {
        return User::whereIn('username', $this->pluck('body_plain'))->get();
    }
}
