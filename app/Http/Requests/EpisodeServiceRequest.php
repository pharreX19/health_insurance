<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EpisodeServiceRequest extends FormRequest
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
            "episode_id" => "required|numeric|exists:episodes,id",
            "service_id" => "required|numeric|exists:services,id",
            "insurance_covered_limit" =>  "required_with:service_id|numeric|min:1.00|max:99999999.99|regex:/^\d+(\.\d{1,2})?$/",
            "aasandha_covered_limit" =>  "nullable|numeric|min:1.00|max:99999999.99|regex:/^\d+(\.\d{1,2})?$/",
            "self_covered_limit" =>  "nullable|numeric|min:1.00|max:99999999.99|regex:/^\d+(\.\d{1,2})?$/",
        ];
    }
}
