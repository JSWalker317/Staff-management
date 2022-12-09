<?php

namespace App\Imports;

use App\Models\Customer;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
// xoa format str_slug() helper
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
HeadingRowFormatter::default('none');



class CustomersImport implements ToCollection
    , WithHeadingRow
    , WithValidation
    ,SkipsOnFailure
    ,SkipsEmptyRows
    ,SkipsOnError
{
    use Importable, SkipsFailures,SkipsErrors;
     /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            Customer::create([
                'customer_name'=> $row['Tên khách hàng'],
                'email'      => $row['Email'],
                'tel_num'    => $row['TelNum'],   
                'address'    => $row['Địa chỉ'],   
            ]);      
        }
    }
    
    // public function model(array $row)
    // {
    //     return new Customer([
    //         // Array keys in PHP are case sensitive
    //         'customer_name'=> $row['Tên khách hàng'],
    //         'email'      => $row['Email'],
    //         'tel_num'    => $row['TelNum'],   
    //         'address'    => $row['Địa chỉ'],   
    //     ]);
    // }

    public function rules(): array
    {
        // ten heading
        return [
            // Above is alias for as it always validates in batches
            'Tên khách hàng'=> 'required|string|min:5',
            'Email' => 'required|email|unique:mst_customer,email',
            'TelNum' => 'required|max:11|regex:/(0)[0-9]{9}/',
            'Địa chỉ' =>'required',
        ];
    }

    /**
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            'Tên khách hàng.required' => 'Vui lòng nhập tên',
            'Tên khách hàng.min' => 'Tên phải lớn hơn 5 ký tự',

            'Email.required' => 'Vui lòng nhập email',
            'Email.unique' => 'Email đã đăng kí',
            'Email.email' => 'Vui lòng nhập đúng định dạng Email',

            'TelNum.required' => 'Vui lòng nhập số điện thoại',
            'TelNum.regex' => 'Vui lòng nhập ít nhất 9 số và số 0 ở đầu',
            'TelNum.max' => 'Vui lòng nhập không quá 11 số',

            'Địa chỉ.required' => 'Vui lòng nhập địa chỉ',
        ];
    }

    //  /**
    //  * @param Failure[] $failures
    //  */
    // public function onFailure(Failure ...$failures)
    // {
    //     // Handle the failures how you'd like.
    // }
   
}
