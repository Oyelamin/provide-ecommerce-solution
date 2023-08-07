<?php
/**
 * Created by PhpStorm.
 * User: blessing
 * Date: 07/08/2023
 * Time: 2:26 am
 */

namespace App\Support\Abstracts;

use App\Support\Traits\ResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

abstract class ApiRequestConfig extends FormRequest
{
    use ResponseTrait;

    /**
     * @param Validator $validator
     * @return void
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException($this->respondWithValidationError(context: $validator->errors()));
    }
}
