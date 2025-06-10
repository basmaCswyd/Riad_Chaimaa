<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFeedbackRequest extends FormRequest
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
        // C'est ici que nous définissons les règles de validation.
        // Les clés du tableau ('subject', 'description') doivent correspondre
        // EXACTEMENT aux attributs 'name' des inputs de notre formulaire.
        return [
            'subject'     => ['required', 'string', 'min:5', 'max:255'],
            'description' => ['required', 'string', 'min:20'],
        ];
    }

}
