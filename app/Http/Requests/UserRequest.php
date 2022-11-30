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
            'name'=> 'required|string',
            'email' => 'required|string|unique:mst_users,email|email',
            'password' => 'required|string',
            'verify_email' => 'required|string',
            'group_role' => 'required|string',
            
        ];
    }
}
