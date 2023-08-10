<?php

namespace App\Http\Requests;

use App\Rules\ValidDeliveryDate;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreBoxRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'delivery_date' => ['required', 'date', new ValidDeliveryDate],
            'recipes' => ['required', 'array'],
            'recipes.*.id' => ['required', 'distinct', 'exists:recipes,id'],
        ];
    }
}
