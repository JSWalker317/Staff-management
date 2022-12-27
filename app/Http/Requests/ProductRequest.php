<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'product_name'=> 'required|string|min:5',
            'product_price' => 'required|numeric|gt:0',
            'is_sales' => 'required',
            'file_photo' =>'image |mimes:jpeg,jpg,png| max:2000 | dimensions:min_width=100,min_height=100,max_width=1024,max_height=1024',
            //  |
        ];
    }

        /**
     * customize msg error
     * @return array
     */
    public function messages()
    {
        return [
            'product_name.required' => 'Vui lòng nhập tên sản phẩm',
            'product_name.min' => 'Tên sản phẩm phải lớn hơn 5 ký tự',

            'product_price.required' => 'Vui lòng nhập giá sản phẩm',
            'product_price.numeric' => 'Giá bán chỉ được nhập số',
            'product_price.gt' => 'Giá bán không được nhỏ hơn 0',

            'is_sales.required' => 'Vui lòng chọn trạng thái',

            // 'file_photo.required' => 'yêu cầu hình ảnh',
            'file_photo.max' => 'Hình ảnh dung lượng < 2Mb',
            'file_photo.mimes' => 'Vui lòng chọn file jpeg,jpg,png',
            'file_photo.image' => 'Vui lòng chọn file hình',
            'file_photo.dimensions' => 'Hình ảnh kích thước dài rộng phải lớn hơn 100 và bé hơn 1024',
        ];
    }

    public $validator = null;
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $this->validator = $validator;
    }
}
