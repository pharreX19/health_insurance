<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubscriptionRequest extends FormRequest
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
            "subscriber_id" => "required|numeric|exists:subscribers,id",
            "plan_id" => "required|numeric|exists:plans,id",
            "begin_date" => "nullable|date"
        ];
    }
}
