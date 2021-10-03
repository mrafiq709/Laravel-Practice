<?php
/**
 * Copyright (c) 2021.
 * Rafiq
 */

namespace App\Repositories\Criteria;

use App\Http\Requests\ApiRequest;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class CreatedFromCriteria
 *
 * @package App\Repositories\Criteria
 */
class CreatedFromCriteria extends BaseCriteria implements CriteriaInterface
{

    /**
     * @var Request
     */
    protected $request;

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
     * @param Builder                            $model
     * @param RepositoryInterface|BaseRepository $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        if ($this->request->has('created_from')) {
            $from = (int) $this->request->input('created_from');
            $timeFrom = Carbon::createFromTimestamp($from);

            $model = $model->where('created_at', '>=', $timeFrom);
            ! $this->isRequestDebug() ?: responder()->addExtraData(['$from' => $from]);
            ! $this->isRequestDebug() ?: responder()->addExtraData(['$timeFrom' => $timeFrom]);
        }

        if ($this->request->has('created_to')) {
            $to = (int) $this->request->input('created_to');
            $timeTo = Carbon::createFromTimestamp($to);

            $model = $model->where('created_at', '<=', $timeTo);
            ! $this->isRequestDebug() ?: responder()->addExtraData(['$to' => $to]);
            ! $this->isRequestDebug() ?: responder()->addExtraData(['$timeTo' => $timeTo]);
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
