<?php

/**
 * Copyright (c) 2021.
 * Rafiq
 */

namespace App\Services;

use App\Http\Requests\ApiRequest;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as LaravelResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class RespondService
 *
 * @package App\Libraries\Backend
 */
class RespondService
{

    /**
     * @var int
     */
    protected $httpStatus = Response::HTTP_OK;

    /**
     * @var bool
     */
    protected $error = false;

    /**
     * @var array
     */
    protected $cookies = [];

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var array
     */
    protected $extraData = [];

    /**
     * @var string
     */
    protected $message;

    /**
     * @var array
     */
    protected $errorMessages = [];

    /**
     * @var array
     */
    protected $hideKeywords = [];

    /**
     * @return array
     */
    public function toArray()
    {
        $data = [
            'code'    => (int) $this->error,
            'message' => $this->message,
            'trace'   => $this->errorMessages,
            'data'    => $this->data,
        ];

        is_array($this->extraData) ? $data = array_merge($data, $this->extraData) : null;

        $this->hideKeywords($data);

        return $data;
    }

    /**
     * @param int|null     $httpStatus
     *
     * @param Request|null $request
     *
     * @return LaravelResponse|Response
     */
    public function toJson($httpStatus = null, Request $request = null)
    {
        $httpStatus === null ?: $this->httpStatus = $httpStatus;

        if (empty($request)) {
            $request = Request::capture();
        }

        if (isDebug() && $request->input('_debug') === '1') {
            $this->addExtraData(['$logMySQL' => DB::getQueryLog()]);
            // $this->addExtraData(['$logMongo' => DB::connection('mongodb')->getQueryLog()]);
        }

        $array = $this->toArray();

        $response = new Response();
        $response->setContent($array);

        $response->setStatusCode($this->httpStatus);

        foreach ($this->cookies as $cookie) {
            $response->withCookie($cookie);
        }

        return $response;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message)
    {
        $this->message = $message;
    }

    /**
     * @return array
     */
    public function getErrorMessages()
    {
        return $this->errorMessages;
    }

    /**
     * @param array $errorMessages
     */
    public function setErrorMessages(array $errorMessages)
    {
        $this->errorMessages = $errorMessages;
    }

    /**
     * @param array $errorMessages
     */
    public function addErrorMessages(array $errorMessages)
    {
        $this->errorMessages += $errorMessages;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @param array $data
     */
    public function addData(array $data)
    {
        $this->data += $data;
    }

    /**
     * @return array
     */
    public function getExtraData()
    {
        return $this->extraData;
    }

    /**
     * @param array $extraData
     */
    public function setExtraData(array $extraData)
    {
        $this->extraData = $extraData;
    }

    /**
     * @param array $extraData
     */
    public function addExtraData(array $extraData)
    {
        $this->extraData = array_merge($this->extraData, $extraData);
    }

    /**
     * @param int $httpStatus
     */
    public function setHttpStatus(int $httpStatus)
    {
        $this->httpStatus = $httpStatus;
    }

    /**
     * @return int
     */
    public function getHttpStatus()
    {
        return $this->httpStatus;
    }

    /**
     * @return bool
     */
    public function isError()
    {
        return $this->error;
    }

    /**
     * @param bool $error
     */
    public function setError($error)
    {
        $this->error = $error;
    }

    /**
     * @param array $data
     * @param int   $httpStatus
     */
    public function success(array $data, int $httpStatus = null)
    {
        if (!$httpStatus) {
            $httpStatus = Response::HTTP_OK;
        }

        $this->addData($data);
        $this->setHttpStatus($httpStatus);
        $this->setError(false);
    }

    /**
     * @param array|string $errorMessages
     * @param int          $httpStatus
     */
    public function error($errorMessages, int $httpStatus = null)
    {
        if (is_string($errorMessages)) {
            $newData = $this->getErrorMessages();
            $newData['error'][] = $errorMessages;
            $errorMessages = $newData;
        } else {
            $newData = $this->errorMessages + $errorMessages;
        }

        $this->setErrorMessages($newData);

        //Get first message
        if ($this->message === null) {
            $shiftArray = $errorMessages;
            $firstElement = (is_array($shiftArray) && count($shiftArray) > 0) ? array_shift($shiftArray) : '';
            $firstMessage = (is_array($firstElement) && count($firstElement) > 0) ? array_shift($firstElement) : '';
            $this->setMessage($firstMessage);
        }

        if ($httpStatus === null && !$this->isError()) {
            $httpStatus = Response::HTTP_BAD_REQUEST;
        }

        $this->setError(true);

        $httpStatus === null ?: $this->setHttpStatus($httpStatus);
    }

    /**
     * @param array $keywords
     */
    public function setHideKeywords(array $keywords)
    {
        $this->hideKeywords = $keywords;
    }

    /**
     * @param array|object $array
     * @param string       $path
     */
    protected function hideKeywords(&$array, string $path = '')
    {

        if (!$this->hideKeywords) {
            return;
        }

        $keywords = $this->hideKeywords;

        $typeArray = gettype($array);

        foreach ($array as $key => $item) {

            $type = gettype($item);

            $currentPath = $path . $key;

            $match = false;
            foreach ($keywords as $keyword) {
                if (fnmatch($keyword, $currentPath)) {
                    $match = true;
                }
            }

            if ($match) {
                $typeArray === 'array' ? $array[$key] = '#hiden' : null;
                $typeArray === 'object' ? $array->$key = '#hiden' : null;
            } else {
                if (in_array($type, ['array', 'object'])) {
                    $this->hideKeywords($item, $currentPath . '.');

                    $typeArray === 'array' ? $array[$key] = $item : null;
                    $typeArray === 'object' ? $array->$key = $item : null;
                }
            }
        }
    }

    /**
     * @param string   $errorMessage
     * @param int|null $httpStatus
     */
    public function errorException($errorMessage, int $httpStatus = null)
    {
        $this->error(['exception' => [$errorMessage]], $httpStatus);
    }

    /**
     * @param string $key
     * @param string $value
     */
    public function setCookie($key, $value)
    {
        $this->cookies[] = cookie($key, $value);
    }
}
