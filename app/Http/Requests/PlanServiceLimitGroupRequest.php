<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanServiceLimitGroupRequest extends FormRequest
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
            // "plan_id" => "required|numeric|exists:plans,id" ,
            // "service_limit_group_id" =>  "required|numeric|exists:service_limit_groups,id",
            "limit_total" => "required|numeric|min:100.00|max:99999999.99|regex:/^\d+(\.\d{1,2})?$/",
        ];
    }
}
