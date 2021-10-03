<?php

/**
 * Copyright (c) 2021.
 * Rafiq
 */

namespace App\Services\User;

use App\Http\Requests\User\IndexUserRequest;
use App\Services\TraitRepositoryService;

class IndexUserService extends UserService 
{
    use TraitRepositoryService;

    /**
     * User Index
     * 
     * @param IndexUserRequest $request
     */
    public function index(IndexUserRequest $request)
    {
        $this->repository->resetCriteria();
        $this->addIndexCriteria();

        /**
         * @var Collection $paginate
         */
        $paginate = $this->repository->paginate($request->perPage());
        responder()->success($paginate->toArray());
    }
}