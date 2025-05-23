<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCardRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'card_number' => 'required|string|size:16',
            'type' => 'required|in:visa,mastercard,edinar',
            'expiry_date' => 'required|date|after:today',
            'balance' => 'required|numeric|min:0'
        ];
    }
}
