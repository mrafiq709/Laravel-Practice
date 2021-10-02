<?php
/**
 * Copyright (c) 2021.
 * Rafiq
 */

namespace App\Http\Requests;

/**
 * Trait TraitPaginateApiRequest
 *
 * @package App\Http\Requests
 */
trait TraitPaginateApiRequest
{

    /**
     * @return int
     */
    static function defaultPerPage()
    {
        return 10;
    }

    /**
     * @return array
     */
    static function paginateRules()
    {
        return [
            'limit'        => 'in:10,20,50,100,500',
            'page'         => 'integer|min:1',
            'status'       => 'in:0,1',
            'sort'         => 'string',
            'created_from' => 'integer',
            'created_to'   => 'integer',
        ];
    }

    /**
     * @return int
     */
    static function requestPerPage()
    {
        return request()->has('limit') ? (int) request()->input('limit') : static::defaultPerPage();
    }

    /**
     * @return int
     */
    public function perPage()
    {
        return static::requestPerPage();
    }
}
