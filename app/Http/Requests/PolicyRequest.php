<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PolicyRequest extends FormRequest
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
            "name" => "required|min:3|max:255|alpha_space|unique:policies,name,{$this->policy}",
            "number_format" => "required|min:3|max:50|alpha_dash",
        ];
    }

    public function attributes(){
        return [
            'number_format' => 'policy number format'
        ];
    }
}
