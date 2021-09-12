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
            "*.name" => "required|alpha_space|min:5|max:255|unique:subscribers,name",
            "*.passport" => "required_without:*.national_id|min:5|max:20|alpha_num|unique:subscribers,passport,{$this->subscriber}",
            "*.national_id" => "required_without:*.passport|min:5|max:20|alpha_num|unique:subscribers,national_id,NULL,id,deleted_at,NULL",
            "*.work_permit" => "required_without:*.national_id|min:5|max:20|alpha_num|unique:subscribers,work_permit,{$this->subscriber}",
            "*.country" => "required|string|min:5|max:50|exists:countries,name",
            "*.contact" => "nullable|numeric|digits:7",
            "*.company_id" => "nullable|numeric|exists:companies,id",
            "*.plan_id" => "required|numeric|exists:plans,id",
            "*.payment_method" => "nullable|sometimes|string|in:cash,credit,credit_card,cheque,online_payment",
            "*.begin_date" => "nullable|date",
            "*.policy_number" => 'nullable'
        ];
    }
    

    public function attributes()
    {
        return [
            '0.name' => 'name',
            '0.passport' => 'passport',
            '0.national_id' => 'national id',
            '0.work_permit' => 'work permit',
            '0.country' => 'country',
            '0.contact' => 'contact',
            '0.company_id' => 'company',
            '0.plan_id' => 'plan',
            '0.begin_date' => 'begin date',
            '0.policy_number' => 'policy number'
        ];
    }
}
