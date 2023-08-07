<?php

namespace App\Http\Requests;

use App\Rules\InternationalPhoneNumber;
use App\Rules\SecurePassword;
use App\Support\Abstracts\ApiRequestConfig;

class RegisterApiRequest extends ApiRequestConfig
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:users,email',
            'phone' => ['required', new InternationalPhoneNumber()],
            'password' => ['bail','required', new SecurePassword()]
        ];
    }

}
