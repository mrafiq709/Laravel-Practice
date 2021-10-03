<?php

/**
 * Copyright (c) 2021.
 * Rafiq
 */

namespace App\Services;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

/**
 * Class ApiCall
 *
 * @package App\Services
 */
abstract class ApiCall
{

    /**
     * @var Client
     */
    protected $client;

    /**
     * ApiCall constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return array
     */
    public function defaultHeaders()
    {
        return [
            'Content-Type' => 'application/json',
            'Accept'       => 'application/json',
        ];
    }

    /**
     * @param string     $url
     * @param array      $params
     * @param array|null $headers
     *
     * @return array
     * @throws GuzzleException|ClientException
     */
    public function post(string $url, array $params, array $headers = null)
    {
        $res = $this->request('POST', $url, $params, $headers);
        $content = $res->getBody()->getContents();

        return json_decode($content, true);
    }

    /**
     * @param string     $url
     * @param array      $params
     * @param array|null $headers
     *
     * @return array|bool
     * @throws GuzzleException
     */
    public function postAndCatch(string $url, array $params, array $headers = null)
    {
        try {
            $content = $this->post($url, $params, $headers);
        } catch (ClientException $e) {
            $content = $e->getResponse()->getBody()->getContents();
            $content = json_decode($content, true);
            $message = 'API Call to partner have error';
            responder()->errorException($message);
            responder()->addErrorMessages(['partner_message' => [$content['message']]]);

            return false;
        }

        return $content;
    }

    /**
     * @param string     $url
     * @param array|null $headers
     *
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function get(string $url, array $headers = null)
    {
        $headers === null ? $headers = $this->defaultHeaders() : null;
        $options = [
            'headers' => $headers,
        ];

        return $this->client->request('GET', $url, $options);
    }

    /**
     * @param string     $url
     * @param array|null $headers
     *
     * @return mixed|ResponseInterface|null
     * @throws Exception
     * @throws GuzzleException
     */
    public function getAndCatch(string $url, array $headers = null)
    {
        $headers === null ? $headers = $this->defaultHeaders() : null;
        $options = [
            'headers' => $headers,
        ];

        try {
            $content = $this->client->request('GET', $url, $options);
        } catch (ClientException $e) {
            $content = $e->getResponse()->getBody()->getContents();
            $content = json_decode($content, true);
            \Log::info('api response: ', [$content]);
            $message = 'API Call to partner have error';
            responder()->errorException($message);
            responder()->addErrorMessages(['partner_message' => [$content['message']]]);
            throw new Exception($content['message']);
        }

        return $content;
    }

    /**
     * @param string     $method
     * @param string     $url
     * @param array|null $params
     * @param array|null $headers
     *
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function request(string $method, string $url, array $params = null, array $headers = null)
    {
        $headers === null ? $headers = $this->defaultHeaders() : null;
        $options = [
            'json'    => $params,
            'headers' => $headers,
        ];

        return $this->client->request($method, $url, $options);
    }
}
