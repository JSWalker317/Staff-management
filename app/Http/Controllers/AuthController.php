<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class AuthController extends Controller
{
       /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
    }
// register errorr Table 'laravel.user' doesn't exist
    public function register(UserRequest $request){
        $user = new User();
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = Hash::make($request->get('password'));
        $user->verify_email = $request->get('verify_email');
        $user->group_role = $request->get('group_role');
        $user->save();
        $user->access_token = $user->createToken("myAppToken")->plainTextToken;
        // $token = $user->createToken('myAppToken')->plainTextToken;
        $response = [
            'user' => $user,
            // 'Bearer_token' => $token
        ];
        return response($response, 201);
    }

    public function getLogin()
    {
        if (Auth::check()) {
            // nếu đăng nhập thàng công thì 
            return redirect('/product');
        } else {
            return view('pages.login');
        }

    }

    // test api login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = User::where("email", $request->email)->first();
            $user->access_token = $user->createToken("myAppToken")->plainTextToken;
            $response = [
                'user' => $user,
            ];
            return response($response, 201);
        }
        return response()->json('Login failed: Invalid username or password.', 422);
      
    }

    public function postLogin(LoginRequest $request)
    {
        $login = [
            'email' => $request->email,
            'password' => $request->password
        ];
        if (Auth::attempt($login)) {
            $user = User::where("mst_users.email", $request->email)->first();
            $user->last_login_ip = request()->ip();
            $user->last_login_at = Carbon::now()->timezone('Asia/Ho_Chi_Minh');
            $token = $user->createToken("myAppToken")->plainTextToken;
            if($request->checkbox) {
                $user->remember_token = $token;
            }
            $user->save();
            // $response = [
            //     'user' => $user,
            // ];
            // return view('pages.login', compact('response'));
            return redirect('/product')->with(['flag'=>'success',
                                                 'message' => 'Login successfully']);
        }
        return redirect()->back()->with(['flag'=>'danger',
                                            'message' => 'Login failed: Invalid username or password']);
        // return response()->json('Login failed: Invalid username or password.', 422);
      
    }

    public function logout()
    {
            request()->user()->tokens()->delete();
            Auth::guard('web')->logout();            // Auth::user()->tokens()->delete();
            // return response()->json([
            //     'message' => 'Logged out success!!!',
            //     'status' => 204,
            // ]);
            return redirect()->route('getLogin');
            // return redirect('/login');
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
