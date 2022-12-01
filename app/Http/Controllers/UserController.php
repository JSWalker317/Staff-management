<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\UserRequest;
use App\Http\Requests\EditUserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;





class UserController extends Controller
{
    
    public function setStatus($id){
        $user = User::findOrFail($id);
        if ($user->is_active == 0){
            $user->is_active = 1;
        }else {
            $user->is_active = 0;
        }
        $user->save();
        return redirect('/user');
    }
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('pages.user', compact('users'));
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $user = new User();
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = Hash::make($request->get('password'));
        $user->group_role = $request->get('group_role');
        $user->save();

        // $request->validated();
        // $user = new User();
        // $user->name = $request->name;
        // $user->email = $request->email;
        // $user->password = $request->password;
        // $user->group_role = $request->group_role;
        // $user->save();

        // $response = [
        //     'user' => $user,
        //     // 'Bearer_token' => $token
        // ];
        // return response($response, 201);
       
        return redirect('/user')->with('success', 'Data added');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // dd($id);
        // return User::findOrFail($id)->get();
        $user = User::find($id);
        return $user;
        // return response()->json([
        //     'data' => $this->orderRepository->getAllOrders()
        // ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(EditUserRequest $request)
    {
        $user = User::findOrFail(request()->id);
        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->group_role = $request->group_role;
        $user->save();
        //  $response = [
        //     'user' => $user,
        //     // 'Bearer_token' => $token
        // ];
        // return response($response, 201);
        return redirect('/user')->with('success', 'Data updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        User::findOrFail(request()->id)->delete();
        return redirect()->route('users')->with('success', 'Deleted');

    }
 
}
