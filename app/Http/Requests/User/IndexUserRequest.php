<?php
/**
 * Copyright (c) 2021.
 * Rafiq
 */

namespace App\Http\Requests\User;

use App\Http\Requests\PaginateApiRequest;

/**
 * Class IndexUserRequest
 *
 * @package App\Http\Requests
 * @author Rafiq
 */
class IndexUserRequest extends PaginateApiRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
