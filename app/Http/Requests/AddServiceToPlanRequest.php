<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddServiceToPlanRequest extends FormRequest
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
            "limit_total" => "required|numeric|min:1.00|max:99999999.99|regex:/^\d+(\.\d{1,2})?$/",
            "limit_group_calculation_type_id" => "required|numeric|exists:service_limit_group_calculation_types,id",
        ];
    }

    public function attributes()
    {
        return [
            "limit_total" => "service limit"
        ];
    }
}
