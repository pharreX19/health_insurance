<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlanRequest extends FormRequest
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
            "name" => "required|alpha_space|min:5|max:255|unique:plans,name,{$this->plan}",
            "premium" => "required|numeric|min:1.00|max:99999999.99|regex:/^\d+(\.\d{1,2})?$/",
            "limit_total" => "required|numeric|min:100.00|max:99999999.99|regex:/^\d+(\.\d{1,2})?$/",
            "territorial_limit" => "nullable|alpha_space|min:5|max:255",
            // "currency" => "required|alpha|in:MVR,USD",
            "policy_id" => "required|numeric|exists:policies,id"
        ];
    }
}
