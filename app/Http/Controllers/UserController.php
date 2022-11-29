<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;



class UserController extends Controller
{
    public function register(UserRequest $request){
        try {
            $user = new User();
            $user->first_name = $request->get('first_name');
            $user->last_name = $request->get('last_name');
            $user->email = $request->get('email');
            $user->password = Hash::make($request->get('password'));
            $user->admin = true;
            $user->save();
    
            $user->access_token = $user->createToken("myAppToken")->plainTextToken;
            // $token = $user->createToken('myAppToken')->plainTextToken;
            $response = [
                'user' => $user,
                // 'Bearer_token' => $token
            ];
            return response($response, 201);

        } catch (Throwable $th){
            return response()->json([
                'error' => 'Server Error'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
      

        // Auto valdate already exists email 
        // $request->validated($request->only(['email', 'password']));

        // if(!User::where("email", $request->email)->first()) {
        //     $user = User::create([
        //         'first_name' => $request->first_name,
        //         'last_name' => $request->last_name,
        //         'email' => $request->email,
        //         'password' => $request->password,
    
        //     ]);
    
        //     $user->access_token = $user->createToken("API_TOKEN")->plainTextToken;
        //     return response()->json($user, 201);
        // }
    }

    public function login(Request $request)
    {
        try {
            // $user = User::where("email", $request->email)->first();
            // if($user || !Hash::check($request->password, $user->password)){
            //     return ["error"=>"Email or password is incorrect"];
            // }
            // return $user;
            // return response()->json('Login success', 204);
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            if (Auth::attempt($credentials)) {
                // $user = Auth::user();
                $user = User::where("email", $request->email)->first();
                $user->access_token = $user->createToken("myAppToken")->plainTextToken;

                // $token = $user->createToken('myAppToken')->plainTextToken;
                $response = [
                    'user' => $user,
                    // 'Bearer_token' => $token
                ];
                return response($response, 201);
            }
            return response()->json('Login failed: Invalid username or password.', 422);

        } catch (Throwable $th){
            return response()->json([
                'error' => 'Server Error'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
      
    }

    public function logout()
    {
        try {
            // // Revoke all tokens...
            // $user->tokens()->delete();
            
            // // Revoke the token that was used to authenticate the current request...
            // $request->user()->currentAccessToken()->delete();
            
            // // Revoke a specific token...
            // $user->tokens()->where('id', $tokenId)->delete();
            
            // Auth::user()->tokens()->delete();
            // Auth()->user()->tokens()->delete();
            request()->user()->tokens()->delete();
            return response()->json([
                'message' => 'Logged out success!!!',
                'status' => 204,
            ]);

        } catch (Throwable $th){
            return response()->json([
                'error' => 'Server Error'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // Auth::logout();
        // $request->session()->invalidate();
        // $request->session()->regenerateToken();
        // return response('', 204);
    }
}
