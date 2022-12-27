<?php

namespace App\Http\Controllers;
use Throwable;
use App\Http\Requests\AddCustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;

use App\Exports\CustomersExport;
use App\Imports\CustomersImport;
use Illuminate\Support\Facades\Config;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Reader\Csv;



class CustomerController extends Controller
{
    protected $csv;

    function __construct(Csv $csv){
        $this->csv = $csv;
    }
       
    public function index()
    {
        $customers = Customer::orderBy('updated_at', 'DESC')->paginate(10);

        return view('pages.customer', compact("customers"));
    }

    public function fetchData(Request $request){
        $customer_name = $request->customer_name;
        $email = $request->email;
        $is_active = $request->is_active;
        $address = $request->address;

        
        
        $customers = Customer::orderBy('updated_at', 'DESC');

        $customers = $this->filterSearch($customers, $customer_name, $email, $is_active, $address);
        $customers = $customers->paginate(10);
        $customers = $customers->appends([
                                    'customer_name' => $customer_name,
                                    'email' => $email,
                                    'is_active' => $is_active,
                                    'address'=> $address,  
                                ]);
        return view('layouts.customerlist', compact('customers'));

    }

    public function filterSearch($customers, $customer_name, $email, $is_active, $address) 
    {
        // address
        $customers = $address!= null ? $customers->where('address','like','%'. $address . '%') : $customers;
        // is_active
        $customers = $is_active!=null ? $customers->where('is_active', $is_active) : $customers;
        // Name
        $customers = $customer_name!=null ? $customers->where('customer_name', 'like', $customer_name . '%') : $customers;
        // email
        $customers = $email!=null ? $customers->where('email', 'like', $email . '%') : $customers;

        return $customers;
    }
    // 
    function setInputEncoding($file) {
        $fileContent = file_get_contents($file->path());
        $enc = mb_detect_encoding($fileContent, mb_list_encodings(), true);
        // dd($enc);
        Config::set('excel.imports.csv.input_encoding', $enc);
    }
    // 
    public function import(Request $request) 
    {
        // Excel::import(new CustomersImport, $request->file('file_customer')->store('temp'));
        $import = new CustomersImport();
        $file = $request->file('file_customer')->store('temp');
        $import->import($file);

        // dd($request->file('file_customer'));
        // dd(pathinfo($request->file('file_customer')));
        // $this->csv->setInputEncoding('utf-8');
        $inputs = $request->all();
        $this->setInputEncoding($inputs['file_customer']);
        try {
            $this->csv->load($inputs['file_customer']);

        } catch (Throwable $th){
            $errors[] = [ 
                0 => '',
                1 => 'Lỗi tên định dạng file Excel => CSV comma delimited',
                2 => [ 0 => '']
            ];  
            return back()->with('error', $errors);
        }

        $spreadsheet = $this->csv->load($inputs['file_customer']);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();
        $sheetHeader = $sheetData[0];
        // dd($sheetHeader[0]);
        $errors = [];
        
        if(sizeof($import->failures()) != 0)
        {
            if($sheetHeader == null |$sheetHeader[0] != 'Tên khách hàng' | $sheetHeader[1] != 'Email'|
                $sheetHeader[2] != 'TelNum' | $sheetHeader[3] !='Địa chỉ')
            {    
                $errors[] = [ 
                    0 => '1',
                    1 => 'Lỗi tên Heading Excel',
                    2 => [ 0 => '']
                ];  
            }
            else 
            {
                foreach ($import->failures() as $failure) 
                {
                    $errors[] = [
                        // $failure
                        $failure->row(),
                        $failure->attribute(),
                        $failure->errors()
                    ];
                }
            }
          
            return back()->with('error', $errors);
        }
        return back()->with('success', 'All good!');
        
    }
    public function export(Request $request) 
    {
        $customers = Customer::orderBy('updated_at', 'DESC');

        $customers = $this->filterSearch($customers, $request->customer_name,
        $request->email, $request->is_active, $request->address);
        if( $request->customer_name != null |
            $request->email != null |
            $request->is_active != null |
            $request->address  != null)
        {
            $customers = $customers->select('customer_name', 'email', 'tel_num', 'address')->get();
        }else{
            $customers = $customers->select('customer_name', 'email', 'tel_num', 'address')->take(10)->get();
        }
        return  Excel::download(new CustomersExport($customers), 'customers.csv');

        // $response =  array(
        //     'name' => "customers.xlsx",
        //     'file' => "data:application/vnd.ms-excel;base64,".base64_encode($downfile)
        //  );
        // return response()->json($response);
        // return Excel::download(new CustomersExport($customers), 'customers.xlsx');

    }
// 
    public function postCustomer(AddCustomerRequest $request){
        $error_arr = [];
        $success_add = '';
        if (isset($request->validator) && $request->validator->fails()) {
            // foreach($request->validator->errors()->messages() as $key => $value){
            // }
            $error_arr[] = $request->validator->errors()->messages() ;
        }else {
            if(request()->button_action == 'insert') {
                $customer = new Customer();
                $customer->customer_name = $request->customer_name;
                $customer->email = $request->email;
                $customer->tel_num = $request->tel_num;
                $customer->address = $request->address;
                $customer->is_active = $request->status;

                $customer->save();
                // return $customer;
                $success_add =  'Customer added';
                // return redirect('/customer')->with('success', 'Data updated');
            }
            if(request()->button_action == 'update') {
                $customer = Customer::findOrFail(request()->customer_id);
                // $customer->customer_id = request()->customer_id;
                $customer->customer_name = $request->customer_name;
                $customer->email = $request->email;
                $customer->tel_num = $request->tel_num;
                $customer->address = $request->address;
                $customer->is_active = $request->status;

                $customer->save();
                // return $customer;
                $success_add =  'Customer updated';
                // $success_add =  $customer;
                // return redirect('/customer')->with('success', 'Data updated');
            }

        }
        $output = [
            'error' => $error_arr,
            'success' => $success_add
        ];
        // echo json_encode(array_values($output));
        return json_encode($output);
    }


    public function show($customer_id) {
        $customer = Customer::findOrFail($customer_id);
        return response()->json([
            'customer' => $customer
        ]);
    }
  
}
