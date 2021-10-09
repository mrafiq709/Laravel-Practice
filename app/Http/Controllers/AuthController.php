<?php
/**
 * Copyright (c) 2021.
 * Rafiq
 */

namespace App\Http\Controllers;

use App\Http\Requests\ApiRequest;
use App\Http\Requests\User\RegisterUserRequest;
use App\Services\User\RegisterUserService;

class AuthController extends Controller
{

    /**
     * @param ApiRequest $request
     *
     * @return JsonResponse
     */
    public function logout(ApiRequest $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * @param RegisterUserRequest $request
     * @param RegisterUserService $service
     *
     * @return \Illuminate\Http\Response|Response
     * @throws GuzzleException
     */
    public function register(RegisterUserRequest $request, RegisterUserService $service)
    {
        $service->register($request);
        return responder()->toJson();
    }
}
