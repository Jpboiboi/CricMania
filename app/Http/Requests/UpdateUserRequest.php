<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'first_name'=>'required',
            'last_name'=>'required',
            'specialization'=>'required',
            'state'=>'required',
            'dob'=>'required',
            'batting_hand'=>'required',
            'jersey_number'=>'required|numeric|min:1|max:999',
            'balling_hand'=>'required',
            'balling_type'=>'required',
            'fav_playing_spot'=>'required|numeric|min:1|max:11',
            'image'=>'required|image|mimes:png,jpg,svg|max:1024',
            'password'=>'required|confirmed',
        ];
    }
}
