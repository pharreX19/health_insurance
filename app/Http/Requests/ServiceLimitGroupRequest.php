<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceLimitGroupRequest extends FormRequest
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
            "name" => "required|min:3|max:50|alpha_space|unique:service_limit_groups,name",
            "description" => "nullable|min:5|max:255|alpha_space",
            // "limit_total" => "required|numeric|min:1.00|max:99999999.99|regex:/^\d+(\.\d{1,2})?$/"
        ];
    }
}
