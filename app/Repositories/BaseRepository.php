<?php

/**
 * Copyright (c) 2021.
 * Rafiq
 */

namespace App\Repositories;

use Illuminate\Contracts\Container\BindingResolutionException;
use Prettus\Repository\Eloquent\BaseRepository as PrettusBaseRepository;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Repository\Traits\ComparesVersionsTrait;

/**
 * Class BaseRepository
 *
 * @property Builder|Model $model
 *
 * @package App\Repositories
 */
abstract class BaseRepository extends PrettusBaseRepository
{

    use ComparesVersionsTrait;

    /**
     * @var array
     */
    protected $sortKeys = [
        'created_at',
        'updated_at',
    ];

    /**
     * @param array $attributes
     *
     * @return Model
     */
    public function newModel(array $attributes = null)
    {
        return $this->model->newInstance($attributes);
    }

    /**
     * Applies the given where conditions to the model.
     *
     * @param array $where
     *
     */
    protected function applyConditions(array $where)
    {
        foreach ($where as $field => $value) {
            $this->model = $this->model->where($field, '=', $value);
        }
    }

    /**
     * @param $criteria
     *
     * @return $this|PrettusBaseRepository
     */
    public function pushCriteria($criteria)
    {
        try {
            return parent::pushCriteria($criteria);
        } catch (RepositoryException $e) {
            $message = "Class " . get_class($criteria) . " must be an instance of Prettus\\Repository\\Contracts\\CriteriaInterface";
            _error($message, __CLASS__ . ' : ' . __FUNCTION__ . ' : ' . __LINE__);
        }

        return $this;
    }

    /**
     * @return Model
     */
    public function makeModel()
    {
        $model = null;
        try {
            $model = $this->app->make($this->model());
        } catch (BindingResolutionException $e) {
            _error($e->getMessage(), __CLASS__ . ' : ' . __FUNCTION__ . ' : ' . __LINE__);
        }

        return $this->model = $model;
    }

    /**
     */
    public function resetModel()
    {
        $this->makeModel();
    }

    /**
     * @return array
     */
    public function getSortKeys()
    {
        return $this->sortKeys;
    }
}
