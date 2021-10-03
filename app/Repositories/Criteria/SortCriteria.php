<?php
/**
 * Copyright (c) 2021.
 * Rafiq
 */

namespace App\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use App\Http\Requests\ApiRequest;

/**
 * Class SortCriteria
 *
 * @package App\Repositories\Criteria
 */
class SortCriteria extends BaseCriteria implements CriteriaInterface
{

    /**
     * @var array
     */
    protected $sortKeys;

    /**
     * SortCriteria constructor.
     *
     * @param array|null      $sortKeys
     * @param ApiRequest|null $request
     */
    public function __construct(array $sortKeys = null, ApiRequest $request = null)
    {
        parent::__construct($request);

        $this->sortKeys = $sortKeys === null ? $this->defaultSortKeys() : $sortKeys;
    }

    /**
     * Apply criteria in query repository
     *
     * @param Builder             $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        if ($this->request->has('sort')) {
            $sortString = $this->request->input('sort');
            $sorts = $this->sortParse($sortString, $this->sortKeys);
            foreach ($sorts as $col => $sort) {
                $model = $model->orderBy($col, $sort);
            }
            ! $this->isRequestDebug() ?: responder()->addExtraData(['$sorts' => $sorts]);
        }

        return $model;
    }

    /**
     * @return array
     */
    protected function defaultSortKeys()
    {
        return [
            'created_at',
            'updated_at',
        ];
    }
}
