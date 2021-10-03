<?php

/**
 * Copyright (c) 2021.
 * Rafiq
 */

namespace App\Services;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;

/**
 * Class ModelNotFoundService
 *
 * @package App\Services
 */
class ModelNotFoundService
{

    /**
     * @param RespondService         $respond
     * @param ModelNotFoundException $exception
     *
     * @return Response
     */
    public static function handle(RespondService $respond, ModelNotFoundException $exception)
    {

        $modelName = $exception->getModel();
        $modelName = explode('\\', $modelName);
        $modelName = array_pop($modelName);

        $message = sprintf('%s not found', $modelName);

        $respond->error([$modelName => [$message]]);

        return $respond->toJson(Response::HTTP_NOT_FOUND);
    }
}
