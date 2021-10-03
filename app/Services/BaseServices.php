<?php
/**
 * Copyright (c) 2021.
 * Rafiq
 */

namespace App\Services;

use App\Repositories\BaseRepository;

/**
 * Class BaseService
 *
 * @package App\Services
 */
abstract class BaseServices 
{

    /**
     * @var BaseRepository
     */
    public $repository;

    /**
     * BaseServices constructor.
     *
     */
    public function __construct()
    {
        $this->repository = app($this->repository());
    }

    /**
     * @return string
     */
    public abstract function repository();
}