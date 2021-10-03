<?php

/**
 * Copyright (c) 2021.
 * Rafiq
 */

namespace App\Services\User;

use App\Models\User\AuthPassportUser;
use App\Services\ApiCall;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class AuthPassportUserService
 *
 * @package App\Services\User
 */
class AuthPassportUserService extends ApiCall
{

    /**
     * @var string
     */
    protected $uri = '/api/me';

    /**
     * @param string $accessToken
     *
     * @return AuthPassportUser|null
     * @throws Exception
     * @throws GuzzleException
     */
    public function getUser(string $accessToken): ? AuthPassportUser
    {
        $url = $this->url($this->uri);

        $headers = $this->getHeaders($accessToken);

        $re = $this->getAndCatch($url, $headers);
        if (!$re) {
            return null;
        }

        $body = $re->getBody();
        $contents = $body->getContents();
        $data = json_decode($contents, true);
        $authPassportUser = new AuthPassportUser();
        $authPassportUser->id = $data['data']['id'];
        $authPassportUser->name = $data['data']['name'];
        $authPassportUser->email = $data['data']['email'];

        return $authPassportUser;
    }

    /**
     * @param string $accessToken
     *
     * @return array
     */
    protected function getHeaders(string $accessToken): array
    {
        $headers = $this->defaultHeaders();
        // TODO: for use with api key
        //        $headers['X-Authorization'] = config('');
        $headers['Authorization'] = 'Bearer ' . $accessToken;

        return $headers;
    }

    /**
     * @param string $uri
     *
     * @return string
     */
    protected function url(string $uri): string
    {
        $domain = config('micro-services.auth-passport.url');

        return $domain . $uri;
    }
}
