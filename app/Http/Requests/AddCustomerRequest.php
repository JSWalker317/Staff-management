<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
class AddCustomerRequest extends FormRequest
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
            'customer_name'=> 'required|string|min:5',
            // 'email' => 'required|email|unique:mst_customer,email' . request()->customer_id,
            'email' => 'required|email|unique:mst_customer,email,'.request()->customer_id.',customer_id',
            'tel_num' => 'required|max:11|regex:/(0)[0-9]{9}/',
            'address' =>'required',
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
            'customer_name.required' => 'Vui lòng nhập tên',
            'customer_name.min' => 'Tên phải lớn hơn 5 ký tự',

            'email.required' => 'Vui lòng nhập email',
            'email.unique' => 'Email đã đăng kí',
            'email.email' => 'Vui lòng nhập đúng định dạng Email',

            'tel_num.required' => 'Vui lòng nhập số điện thoại',
            // 'tel_num.numeric' => 'Vui lòng nhập sô',
            'tel_num.regex' => 'Vui lòng nhập ít nhất 10 số và số 0 ở đầu',
            'tel_num.max' => 'Vui lòng nhập không quá 11 số',

            'address.required' => 'Vui lòng nhập địa chỉ',
        ];
    }

    public $validator = null;
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $this->validator = $validator;
    }
}
