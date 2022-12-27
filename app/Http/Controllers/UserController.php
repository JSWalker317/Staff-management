<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{

    public function index()
    {
        $users = User::where('is_delete', 0)->orderBy('updated_at', 'DESC')->paginate(10);
        return view('pages.user', compact('users'));
        // return view('pages.user');
       
    }

    public function fetchData(Request $request){
        $group_role =$request->group_role;
        $is_active = $request->is_active;
        $name = $request->name;
        $email = $request->email;

        // echo $request->email;
        
        $users = User::where('is_delete', 0)->orderBy('updated_at', 'DESC');

        $users = $this->filterSearch($users, $group_role, $is_active, $name, $email);
        $users = $users->paginate(10);
        $users = $users->appends(['group_role' => $group_role,
                                    'status'=> $is_active,
                                    'name' => $name,
                                    'email' => $email   ]);
        
        
        return view('layouts.userlist', compact('users'));

        // return response()->json([
        //     $users
        // ]);
    }

    public function filterSearch($users, $group_role, $is_active, $name, $email) 
    {
        // group_role
        $users = $group_role!= null ? $users->where('group_role', $group_role) : $users;
        // status
        $users = $is_active!=null ? $users->where('is_active', $is_active) : $users;
        // Name
        $users = $name!=null ? $users->where('name', 'like', $name . '%') : $users;
        // email
        $users = $email!=null ? $users->where('email', 'like', $email . '%') : $users;

        return $users;
    }
 

    public function postUser(UserRequest $request){
        $error_arr = [];
        $success_add = '';
        if (isset($request->validator) && $request->validator->fails()) {
            $error_arr[] = $request->validator->errors()->messages() ;

        }else {
            if(request()->button_action == 'insert') {
                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = Hash::make($request->password);
                $user->group_role = $request->group_role;
                $user->is_active = $request->status;

                $user->save();

                $success_add =  'User added';
            }
            if(request()->button_action == 'update') {
                $user = User::findOrFail(request()->id);
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = Hash::make($request->password);
                $user->group_role = $request->group_role;
                $user->is_active = $request->status;
                $user->save();

                $success_add =  'User updated';
              
            }

        }
        $output = [
            'error' => $error_arr,
            'success' => $success_add
        ];
        // echo json_encode(array_values($output));
        return json_encode($output);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);  
        return response()->json([
            'user' => $user
        ]);
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->is_delete = 1;
        $user->save();

        $output = [
            'success' => 'User deleted'
        ];
        // echo json_encode(array_values($output));
        return json_encode($output);
       
        // return redirect()->route('users')->with('success', 'Deleted');

    }

    public function setStatus($id){
        $user = User::findOrFail($id);
        if ($user->is_active == 0){
            $user->is_active = 1;
        }else {
            $user->is_active = 0;
        }
        $user->save();

        $output = [
            'success' => 'User updated status'
        ];
        // echo json_encode(array_values($output));
        return json_encode($output);
        // return redirect('/user');
    }


     
    // public function store(UserRequest $request)
    // {
    //     $user = new User();
    //     $user->name = $request->get('name');
    //     $user->email = $request->get('email');
    //     $user->password = Hash::make($request->get('password'));
    //     $user->group_role = $request->get('group_role');
    //     $user->save();

   
     
    //     return redirect('/user')->with('success', 'Data added');
    // }

   

   
    // public function edit(EditUserRequest $request)
    // {
    //     $user = User::findOrFail(request()->id);
    //     $user->name = $request->name;
    //     $user->password = Hash::make($request->password);
    //     $user->group_role = $request->group_role;
    //     $user->save();
    //     //  $response = [
    //     //     'user' => $user,
    //     //     // 'Bearer_token' => $token
    //     // ];
    //     // return response($response, 201);
    //     return redirect('/user')->with('success', 'Data updated');
    // }
 
}
