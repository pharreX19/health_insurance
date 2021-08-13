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
            'email' => 'required|email|min:5|max:50',
            'user_type' => 'forbidden',
            'gender' => 'required|in:male,female',
            "contact" => "nullable|string|min:7|max:20",
            'active' => 'required|bool',
            'password' => 'required|min:5|max:20|string',
            'role_id' => 'required|exists:roles,id|numeric'
        ];
    }
}
