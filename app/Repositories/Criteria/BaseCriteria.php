<?php

/**
 * Copyright (c) 2021.
 * Rafiq
 */

namespace App\Repositories\Criteria;

use App\Http\Requests\ApiRequest;

/**
 * Class BaseCriteria
 *
 * @package App\Repositories\Criteria
 */
abstract class BaseCriteria
{

    /**
     * @var ApiRequest
     */
    protected $request;

    /**
     * @var bool
     */
    protected $useTablePrefix = false;

    /**
     * BaseCriteria constructor.
     *
     * @param ApiRequest $request
     */
    public function __construct(ApiRequest $request = null)
    {
        if ($request === null) {
            $request = ApiRequest::capture();
        }

        $this->request = $request;
    }

    /**
     * @param bool $status
     *
     * @return $this
     */
    public function useTablePrefix(bool $status)
    {
        $this->useTablePrefix = $status;

        return $this;
    }

    /**
     * @return array|string|null
     */
    protected function isRequestDebug()
    {
        return $this->request->input('_debug');
    }


    /**
     * @param string $sortString
     * @param array  $allowKeys
     *
     * @return array
     */
    protected function sortParse($sortString, array $allowKeys = [])
    {
        $sort = [];
        $sortArray = explode(',', $sortString);

        foreach ($sortArray as $item) {
            $direction = 'asc';
            $firstChar = substr($item, 0, 1);
            if ($firstChar == '-') {
                $direction = 'desc';
                $item = substr($item, 1);
            }

            !in_array($item, $allowKeys) ?: $sort[$item] = $direction;
        }

        return $sort;
    }
}
