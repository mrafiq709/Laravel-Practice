<?php
/**
 * Copyright (c) 2021.
 * Rafiq
 */

namespace App\Services;

use Illuminate\Http\Request;
use App\Repositories\BaseRepository;
use App\Repositories\Criteria\SortCriteria;
use App\Repositories\Criteria\CreatedFromCriteria;

/**
 * Trait TraitRepositoryService
 *
 * @property BaseRepository $repository
 *
 * @package App\Services
 */
trait TraitRepositoryService
{
    /**
     * @param BaseRepository|null $repository
     *
     */
    public function addIndexCriteria(BaseRepository $repository = null)
    {
        $repository === null ? $repository = $this->repository : null;

        $sortKeys = $repository->getSortKeys();
        $repository->pushCriteria(new SortCriteria($sortKeys));
        $repository->pushCriteria(new CreatedFromCriteria());
    }

    /**
     * @param Request             $request
     * @param BaseRepository|null $repository
     */
    public function addWithsCriteria(Request $request, BaseRepository $repository = null)
    {
        if (! $request->has('withs')) {
            return;
        }

        $repository === null ? $repository = $this->repository : null;

        $withs = $request->input('withs');
        $withs = explode(',', $withs);

        foreach ($withs as $with) {
            $repository->with($with);
        }
    }
}