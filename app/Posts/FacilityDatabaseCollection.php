<?php

namespace App\Posts;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class FacilityDatabaseCollection extends Collection
{
    public function users()
    {
        return User::whereIn('username', $this->pluck('body_plain'))->get();
    }
}
