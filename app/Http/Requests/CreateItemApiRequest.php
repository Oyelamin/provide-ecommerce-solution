<?php

namespace App\Http\Requests;

use App\Rules\ItemPriceRule;
use App\Support\Abstracts\ApiRequestConfig;

class CreateItemApiRequest extends ApiRequestConfig
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
            'title' => ['required', 'string', 'min:3'],
            'description' => ['required', 'string', 'min:3'],
            'price' => [
                'required',
                new ItemPriceRule()
            ],
            'quantity' => ['required', 'integer', 'min:1']
        ];
    }
}
