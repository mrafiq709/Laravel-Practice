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
 * class Movie
 * 
 * @property string         $_id
 * @property int            $creator
 * @property string         $title
 * @property int            $stock
 * @property float          $rate
 * @property bool           $liked
 * @property string         $genre_id
 * @property Carbon         $deleted_at
 * @property Carbon         $created_at
 * @property Carbon         $updated_at
 * @mixin Eloquent
 *
 * @package App\Models\Vidly
 */
class Movie extends MongoModel
{
    use SoftDeletes, HybridRelations;

    protected $collection = 'movies';
    protected $fillable = ['title'];

    protected $dates = ['deleted_at'];

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }
}
