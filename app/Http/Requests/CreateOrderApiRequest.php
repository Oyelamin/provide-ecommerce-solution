<?php

namespace App\Http\Requests;

use App\Rules\InternationalPhoneNumber;
use App\Support\Abstracts\ApiRequestConfig;

class CreateOrderApiRequest extends ApiRequestConfig
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
            'address' => ['required', 'string', 'min:3'],
            'contact' => ['required', new InternationalPhoneNumber()],
            'items'     => ['required', 'array'],
            'items.*.id' => ['required', 'string', 'exists:items,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1']
        ];
    }

}
