<?php

/**
 * Copyright (c) 2021.
 * Rafiq
 */

namespace App\Models\Vidly;

use App\Models\MongoModel;
use Carbon\Carbon;
use Jenssegers\Mongodb\Eloquent\HybridRelations;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

/**
 * class Genre
 * 
 * @property string             $_id
 * @property int                $creator
 * @property string             $name
 * @property Carbon             $deleted_at
 * @property Carbon             $created_at
 * @property Carbon             $updated_at
 * @mixin Eloquent
 *
 * @package App\Models\Genre
 */
class Genre extends MongoModel
{
    use SoftDeletes, HybridRelations;

    protected $collection = 'genres';
    protected $fillable = ['name'];

    protected $dates = ['deleted_at'];

    public function movies()
    {
        return $this->hasMany(Movie::class);
    }
}
