<?php
/**
 * Copyright (c) 2021.
 * Rafiq
 */

namespace App\Models\User;

use App\Models\BaseModel;
use App\User;
use Eloquent;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Support\Carbon;

/**
 * Class AuthPassportUser
 *
 * @package App\Models\User
 * @property int            $id
 * @property Carbon|null    $created_at
 * @property Carbon|null    $updated_at
 * @property string|null    $name
 * @property string|null    $email
 * @property-read User|null $user
 * @mixin Eloquent
 */
class AuthPassportUser extends BaseModel
{

    /**
     * @return belongsTo
     */
    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }
}
