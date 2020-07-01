<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';
    public $timstamp = true;
    protected $fillable = ['name', 'flag_url', 'user_id'];
}
