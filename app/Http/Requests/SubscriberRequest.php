<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubscriberRequest extends FormRequest
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
            "name" => "required|alpha_space|min:5|max:255|unique:subscribers,name",
            "passport" => "required_without:national_id|min:5|max:20|alpha_num",
            "national_id" => "required_without:passport|min:5|max:20|alpha_num",
            "work_permit" => "required_without:national_id|min:5|max:20|alpha_num",
            "nationality" => "required|min:5|max:50|alpha_space",
            "contact" => "nullable|string|min:7|max:20",
            "company_id" => "nullable|numeric|exists:companies,id"
        ];
    }
}
