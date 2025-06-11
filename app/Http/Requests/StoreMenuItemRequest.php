<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMenuItemRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
         return [
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'min:10'],
            'price'       => ['required', 'numeric', 'min:0'],
            'category'    => ['required', 'string', Rule::in(['Entrée', 'Plat Principal', 'Dessert', 'Boisson', 'Menu Enfant'])],
            'image'       => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ];
    }
}
