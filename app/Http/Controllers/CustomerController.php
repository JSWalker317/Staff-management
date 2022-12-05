<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::orderBy('updated_at', 'DESC')->paginate(10);

        return view('pages.customer', compact("customers"));
    }

    public function fetchData(Request $request){
        $customer_name = $request->customer_name;
        $email = $request->email;
        $is_active = $request->is_active;
        $address =$request->address;
        
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
        $customers = $address!= null ? $customers->where('address','like', $address . '%') : $customers;
        // is_active
        $customers = $is_active!=null ? $customers->where('is_active', $is_active) : $customers;
        // Name
        $customers = $customer_name!=null ? $customers->where('customer_name', 'like', $customer_name . '%') : $customers;
        // email
        $customers = $email!=null ? $customers->where('email', 'like', $email . '%') : $customers;

        return $customers;
    }

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
