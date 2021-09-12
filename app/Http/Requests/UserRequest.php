<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required|alpha_space|min:5|max:50',
            'email' => "required|email|min:5|max:50|unique:users,email,{$this->user}",
            // 'user_type' => 'forbidden',
            'amount' => 'required|numeric|min:0|max:9999',
            'gender' => 'required|in:Male,Female',
            "contact" => "nullable|string|min:7|max:20",
            'active' => 'nullable|sometimes|bool',
            'password' => 'required_unless:confirm_password,null|min:5|max:20|string',
            'confirm_password'=> 'nullable|sometimes|string|min:5',
            'role_id' => 'required|exists:roles,id|numeric',
            'service_provider_id' => 'required_unless:role_id,1|exists:service_providers,id|array'
        ];
    }
}
