<?php
/**
 * Copyright (c) 2021.
 * Rafiq
 */

namespace App\Http\Requests;

use App\User;
use Exception;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ApiRequest
 *
 * @package App\Http\Requests
 */
class ApiRequest extends FormRequest
{

    /**
     * @var string
     */
    protected $guard = 'api';

    /**
     * Get the user making the request.
     *
     * @param string|null $guard
     *
     * @return User
     */
    public function user($guard = null)
    {
        if ($guard == null) {
            $guard = $this->guard;
        }

        /** @var User $user */
        $user = parent::user($guard);

        return $user;
    }

    /**
     * Validate the class instance.
     *
     * @return void
     * @throws ApiRequestException
     */
    public function validateResolved()
    {
        $this->prepareForValidation();

        if (! $this->passesAuthorization()) {
            throw new Exception('This action is unauthorized.');
        }

        $instance = $this->getValidatorInstance();
        if ($instance->fails()) {
            throw new Exception($instance->getMessageBag());
        }

        (! method_exists($this, 'prepareAfterValidation')) ?: $this->prepareAfterValidation();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the required params that apply to the request.
     *
     * @return array
     */
    public function params()
    {
        return [];
    }
}
