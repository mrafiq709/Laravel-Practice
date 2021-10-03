<?php
/**
 * Copyright (c) 2021.
 * Rafiq
 */

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Response;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Psr\Http\Message\ServerRequestInterface;

class CustomAccessTokenController extends AccessTokenController
{
    use AuthenticatesUsers;

    /**
     * @param ServerRequestInterface $request
     *
     * @return Response
     */
    public function issueUserToken(ServerRequestInterface $request): Response
    {
        $response = $this->issueToken($request);

        if ($response->getStatusCode() === Response::HTTP_OK) {
            if (request()->input('grant_type') === 'password') {
                $username = request()->input('username');
                $user = User::where('email', $username)->first();
                !$user->email_verified_at ? $user->email_verified_at = now() : null;
                $user->save();
            }
        }
        return $response;
    }
}
