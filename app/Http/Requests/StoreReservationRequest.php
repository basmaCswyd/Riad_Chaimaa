<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
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
        'reservation_date' => ['required', 'date', 'after_or_equal:today'],
        'reservation_time' => ['required', 'string', 'date_format:H:i'],
        'guests'           => ['required', 'integer', 'min:1', 'max:12'],
        'table_id'         => ['required', 'integer', 'exists:tables,id'], // On valide que la table existe bien en BDD
    ];
}
}
