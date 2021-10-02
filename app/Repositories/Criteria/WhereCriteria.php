<?php

/**
 * Copyright (c) 2019.
 * Simon
 */

namespace App\Repositories\Criteria;

use App\Http\Requests\ClientApiRequest;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class WhereCriteria
 *
 * @package App\Repositories\Criteria
 */
class WhereCriteria extends WhereByRequestCriteria
{

    /**
     * @var string|int|boolean
     */
    protected $value;

    /**
     * SortCriteria constructor.
     *
     * @param ClientApiRequest $request
     * @param string|array     $field
     * @param mixed            $value
     * @param string           $operator
     */
    public function __construct($field, $value, string $operator = '=', ClientApiRequest $request = null)
    {
        parent::__construct($field, $operator, $request);

        $this->value = $value;
    }

    /**
     * Apply criteria in query repository
     *
     * @param Builder                            $model
     * @param RepositoryInterface|BaseRepository $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $this->where($model, $repository, $this->value);
    }
}
