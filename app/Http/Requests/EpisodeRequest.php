<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EpisodeRequest extends FormRequest
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
            "memo_number" => "required|string|min:5|max:50|unique:episodes,memo_number",
            "subscriber_id" => "required|numeric|exists:subscribers,id",
            "service_provider_id" => "required|numeric|exists:service_providers,id",
        ];
    }
}
