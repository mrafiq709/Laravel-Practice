<?php
/**
 * Copyright (c) 2021.
 * Rafiq
 */

namespace App\Http\Requests;

/**
 * Class ApiRequest
 *
 * @package App\Http\Requests
 */
class PaginateApiRequest extends ApiRequest
{
    use TraitPaginateApiRequest;

    /**
     * @return array
     */
    public function rules()
    {
        return static::paginateRules();
    }
}
