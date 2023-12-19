<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'first_name'         => 'required|max:100',
            'last_name'          => 'required|max:100',
            'email'              => 'required|min:4|max:255|email|unique:users,email',
            'password'           => 'required|min:6|max:30',
        ];
    }
}
