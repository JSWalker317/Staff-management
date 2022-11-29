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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name'=> 'required|string',
            'last_name'=> 'required|string',
            'email' => 'required|string|unique:user,email|email',
            'password' => 'required|string|confirmed',
            'verify_email' => 'required|string',
            
        ];
    }
}
