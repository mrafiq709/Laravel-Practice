<?php

/**
 * Copyright (c) 2021.
 * Rafiq
 */

namespace App\Models;

use DateTimeInterface;
use Jenssegers\Mongodb\Eloquent\Model;

/**
 * Class MongoModel
 *
 * @package App\Models
 */
abstract class MongoModel extends Model
{

    /**
     * @var string
     */
    protected $connection = 'mongodb';

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  DateTimeInterface $date
     *
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->getTimestamp();
    }
}
