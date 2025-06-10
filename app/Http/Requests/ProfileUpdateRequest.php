<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'prenom' => ['required', 'string', 'max:255'],
            'nom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            // Ajout de nos champs personnalisés
            'num_telephone' => ['required', 'string', 'max:20', Rule::unique(User::class)->ignore($this->user()->id)],
            'annee_naissance' => ['required', 'integer', 'min:1920', 'max:' . date('Y')],
            'cin' => ['required', 'string', 'max:20', Rule::unique(User::class)->ignore($this->user()->id)],
        ];
    }
}