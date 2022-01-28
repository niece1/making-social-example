<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Posts\FacilityDatabaseCollection;

class Facility extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function newCollection(array $models = [])
    {
        return new FacilityDatabaseCollection($models);
    }
}
