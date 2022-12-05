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
            'name'=> 'required|string|min:5',
            'email' => 'required|email|unique:mst_users,email,'.request()->id.',id',
            'password' => 'required|string|confirmed',
            'password_confirmation' =>'required',
            'group_role' => 'required|string',
            // 'is_active' => 'required|string',
        ];
    }

        /**
     * customize msg error
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên',
            'name.min' => 'Tên phải lớn hơn 5 ký tự',

            'email.required' => 'Vui lòng nhập email',
            'email.unique' => 'Email đã đăng kí',
            'email.email' => 'Vui lòng nhập đúng định dạng Email',

            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.confirmed' => 'Xác thực mật khẩu không đúng',
            'password_confirmation.required' => 'Vui lòng xác thực mật khẩu',
        ];
    }

    public $validator = null;
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $this->validator = $validator;
    }
}
