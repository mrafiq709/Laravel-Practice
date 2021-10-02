<?php
/**
 * Copyright (c) 2021.
 * Rafiq
 */

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseModel
 *
 * @package App\Models
 */
abstract class BaseModel extends Model
{

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
