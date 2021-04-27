<?php
/**
 * Copyright (c) 2021.
 * Rafiq
 */

namespace App\Services\Telegram;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class TeleBotApiCall
 *
 * @package App\Services\Telegram
 */
class TeleBotApiCall
{

    /**
     * @var string
     */
    protected $url = 'https://api.telegram.org/bot%s/%s?';

    /**
     * @var Client
     */
    protected $client;

    /**
     * TeleBotApiCall constructor.
     *
     * @param Client|null $client
     */
    public function __construct(Client $client = null)
    {
        $this->client = $client ? $client : app(Client::class);
    }

    /**
     * @return array
     */
    protected function getParams(): array
    {
        return [
            'Content-Type' => 'application/json',
        ];
    }

    /**
     * @return string
     */
    protected function getToken(): string
    {
        return config('telegram.token');
    }

    /**
     * @return string
     */
    public function getBotName(): string
    {
        return config('telegram.bot_name');
    }

    /**
     * @return string
     */
    protected function getCallback(): string
    {
        $domain = url()->secure('/');
        $uri = 'bots/callback';

        return sprintf('%s/%s', $domain, $uri);
    }

    /**
     * @return array
     * @throws GuzzleException
     */
    public function setWebhook(): array
    {
        $url = $this->getUrl(__FUNCTION__);

        $params = $this->getParams();
        $params['json'] = [
            'url' => $this->getCallback(),
        ];

        return $this->request($url, $params);
    }

    /**
     * @return array
     * @throws GuzzleException
     */
    public function getMyCommands(): array
    {
        $url = $this->getUrl(__FUNCTION__);
        $params = $this->getParams();

        return $this->request($url, $params);
    }

    /**
     * @return array
     * @throws GuzzleException
     */
    public function setMyCommands(): array
    {
        $url = $this->getUrl(__FUNCTION__);

        $params = $this->getParams();
        $params['json'] = [
            'commands' => [

            ],
        ];

        return $this->request($url, $params);
    }

    /**
     *
     * @return array
     * @throws GuzzleException
     */
    public function getWebhookInfo(): array
    {
        $url = $this->getUrl(__FUNCTION__);

        $params = $this->getParams();

        return $this->request($url, $params);
    }

    /**
     * @return array
     */
    //public function getMe()
    //{
    //    $url = $this->getUrl(__FUNCTION__);
    //
    //    $params = $this->getParams();
    //
    //    return $this->request($url, $params);
    //}

    /**
     * @param int    $chatId
     * @param string $message
     *
     * @return array
     * @throws GuzzleException
     */
    public function sendMessage(int $chatId, string $message): array
    {
        $url = $this->getUrl(__FUNCTION__);

        if (strlen($message) > 4000) {
            $message = 'Data too big';
        }

        $json = [
            'text'       => $message,
            'chat_id'    => $chatId,
            'parse_mode' => 'HTML',
        ];

        $params = [
            'json' => $json,
        ];

        $content = $this->request($url, $params);

        if (!$this->isContentOk($content)) {
            _error($content, __CLASS__ . ' : ' . __FUNCTION__ . ' : ' . __LINE__);
        }

        return $content;
    }

    /**
     * @param array $content
     *
     * @return boolean
     */
    protected function isContentOk(array $content): bool
    {
        return isset($content['ok']) ? $content['ok'] : false;
    }

    /**
     * @param string $url
     * @param array  $params
     *
     * @return array
     * @throws GuzzleException
     */
    protected function request(string $url, array $params): array
    {
        try {
            $res = $this->client->post($url, $params);
            $content = $res->getBody()->getContents();
        } catch (ClientException $e) {
            $content = $e->getResponse()->getBody()->getContents();
        }

        return json_decode($content, true);
    }

    /**
     * @param string $method
     *
     * @return string
     */
    public function getUrl(string $method): string
    {
        $token = $this->getToken();

        return sprintf($this->url, $token, $method);
    }
}
