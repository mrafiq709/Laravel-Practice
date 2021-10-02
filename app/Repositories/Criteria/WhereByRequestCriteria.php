<?php
/**
 * Copyright (c) 2019.
 * Simon
 */

namespace App\Repositories\Criteria;

use App\Http\Requests\ClientApiRequest;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class WhereCriteria
 *
 * @package App\Repositories\Criteria
 */
class WhereByRequestCriteria extends BaseCriteria implements CriteriaInterface
{

    /**
     * @var string
     */
    protected $field;

    /**
     * @var string
     */
    protected $field_type = 'string';

    /**
     * @var
     */
    protected $cols;

    /**
     * @var string
     */
    protected $operator;

    /**
     * SortCriteria constructor.
     *
     * @param ClientApiRequest $request
     * @param string|array     $field
     * @param string           $operator
     */
    public function __construct($field, string $operator = '=', ClientApiRequest $request = null)
    {
        parent::__construct($request);

        if (is_array($field)) {
            $this->field = $field['field'];
            $this->cols = $field['cols'];
            $this->field_type = isset($field['type']) ? $field['type'] : 'string';

        } else {
            $this->field = $field;
            $this->cols = $field;
        }

        $this->operator = $operator;
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
        if ($this->request->has($this->field) === false) {
            return $model;
        }

        $value = $this->request->input($this->field);

        return $this->where($model, $repository, $value);
    }

    /**
     * Apply criteria in query repository
     *
     * @param Builder                            $model
     * @param RepositoryInterface|BaseRepository $repository
     * @param                                    $value
     *
     * @return mixed
     */
    protected function where($model, RepositoryInterface $repository, $value)
    {
        if ($this->useTablePrefix) {
            $table = $repository->makeModel()->getTable();
            $cols = sprintf('%s.%s', $table, $this->cols);
        } else {
            $cols = $this->cols;
        }

        switch ($this->field_type) {
            case 'int':
            case 'integer':
                $value = (int) $value;
                break;
            case 'bool':
            case 'boolean':
                $value = (bool) $value;
                break;
        }

        $model = $model->where ($cols, $this->operator, $value);
        $this->isRequestDebug() ? responder()->addExtraData([$cols . ' ' . $this->operator => $value]) : null;

        return $model;
    }
}
