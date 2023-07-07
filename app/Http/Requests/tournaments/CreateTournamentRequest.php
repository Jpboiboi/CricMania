<?php

namespace App\Http\Requests\tournaments;

use Illuminate\Foundation\Http\FormRequest;

class CreateTournamentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required | min:3 | max:255 | unique:tournaments',
            'tournament_type_id' => 'required',
            'no_of_teams' => 'required',
            'max_players' => 'required|numeric|min:11|max:25',
            'no_of_overs' => 'required|numeric',
            'start_date' => 'required',
        ];
    }
}
