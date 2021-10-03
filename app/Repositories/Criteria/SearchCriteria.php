<?php
/**
 * Copyright (c) 2021.
 * Rafiq
 */

namespace App\Repositories\Criteria;

use App\Http\Requests\ApiRequest;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class SearchCriteria
 *
 * @package App\Repositories\Criteria
 */
class SearchCriteria extends BaseCriteria implements CriteriaInterface
{

    /**
     * @var array
     */
    protected $fields;

    /**
     * @var string
     */
    protected $keywordName;

    /**
     * SortCriteria constructor.
     *
     * @param ApiRequest $request
     * @param array      $fields
     * @param string     $keywordName
     */
    public function __construct(array $fields, string $keywordName = 'keyword', ApiRequest $request = null)
    {
        parent::__construct($request);

        $this->fields = $fields;
        $this->keywordName = $keywordName;
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

        $keywordName = $this->keywordName;

        if ($this->request->has($keywordName) === true) {
            $keyword = $this->request->input($keywordName);
            $keyword = str_replace('%', '', $keyword);

            $keywordNameDebug = [];
            $model = $model->where(function (Builder $query) use ($keyword, &$keywordNameDebug) {
                foreach ($this->fields as $field) {
                    $query->orWhere($field, 'LIKE', '%' . $keyword . '%');

                    $keywordNameDebug[ $field ] = $keyword . '%';
                }
            });

            $this->isRequestDebug() ? responder()->addExtraData([$keywordName => $keywordNameDebug]) : null;
        }

        return $model;
    }
}
