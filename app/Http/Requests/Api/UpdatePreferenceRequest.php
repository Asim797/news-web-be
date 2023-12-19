<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePreferenceRequest extends FormRequest
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
            'sources'         => 'required',
            'sources.*'       => 'required_with_all:sources|numeric|exists:sources,id',
            'categories'      => 'required',
            'categories.*'    => 'required_with_all:categories|numeric|exists:categories,id',
            'authors'         => 'required',
            'authors.*'       => 'required_with_all:authors|numeric|exists:authors,id',
        ];
    }
}
