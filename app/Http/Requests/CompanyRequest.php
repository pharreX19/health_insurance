<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => "required|string|min:5|max:255|unique:companies,name,{$this->company}",
            "registration" => "required|string|min:5|max:255|unique:companies,registration,{$this->company}",
            "contact" => "nullable|string|min:7|max:20",
        ];
    }
}
