<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
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
            "name" => "required|alpha_space|min:5|max:255|unique:services,name,{$this->service}",
            "description" => "nullable|alpha_space|min:5|max:255",
            "service_type_id" => "required|numeric|exists:service_types,id",
            "service_limit_group_id" => "nullable|numeric|exists:service_limit_groups",
        ];
    }
}
