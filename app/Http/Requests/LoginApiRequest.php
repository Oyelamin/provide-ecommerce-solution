<?php

namespace App\Http\Requests;

use App\Support\Abstracts\ApiRequestConfig;


class LoginApiRequest extends ApiRequestConfig
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
            'email' => ['required', 'string', 'email', 'exists:users,email'],
            'password' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'email.string' => "Kindly provide a valid email address.",
            'email.exists' => "These credentials do not match our records.",
            'email.email' => "Kindly provide a valid email address to continue.",
        ];
    }

}
