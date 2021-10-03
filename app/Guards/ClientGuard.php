<?php

namespace App\Guards;

use App\Services\User\AuthPassportUserService;
use App\Services\User\UserService;
use App\User;
use Exception;
use Firebase\JWT\JWT;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

/**
 * Class ClientGuard
 *
 * @package App\Guards
 */
class ClientGuard
{

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var UserService
     */
    protected $userService;

    protected $authPassportUserService;

    /**
     * CredentialGuard constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->userService = app(UserService::class);
        $this->authPassportUserService = app(AuthPassportUserService::class);
    }

    /**
     * @return User|null
     * @throws GuzzleException
     */
    public function user(): ? User
    {
        $publicKey = 'oauth-public.key';
        return $this->userFromBearerToken($publicKey);
    }

    /**
     * @param string $publicKey
     *
     * @return User|null
     * @throws AuthenticationException
     * @throws GuzzleException
     */
    protected function userFromBearerToken(string $publicKey): ? User
    {
        if (!$token = $this->request->bearerToken()) {
            return null;
        }

        $keyPath = storage_path($publicKey);
        
        if (!file_exists($keyPath)) {
            throw new AuthenticationException(__('Server can not verify Token'));
        }
        $key = file_get_contents($keyPath);
        $decoded = JWT::decode($token, $key, ['RS256']);

        return $this->getUser($decoded->sub, $token);
    }

    /**
     * @param string $email
     * @param string $token
     *
     * @return User
     * @throws GuzzleException
     * @throws Exception
     */
    protected function getUser(string $sub, string $token): User
    {
        $user = User::find($sub);

        if (!$user) {
            $authPassportUser = $this->authPassportUserService->getUser($token);
            $user = $this->userService->createUserFromAuthPassport($authPassportUser);
        }

        return $user;
    }
}
