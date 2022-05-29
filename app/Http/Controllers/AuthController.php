<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * autheticate
     *
     * @param  mixed $request
     * @return void
     */
    public function login(Request $request){
        $crendetial = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if(Auth::attempt($crendetial)){
            return response()->json([
                'status' => true,
                'message' => 'Successfully login'
            ]);
        }
        return response()->json([
            'status' => false,
            'errors' =>['email' => ['The user credentail not match']]
        ],422);
    }

    /**
     * register
     *
     * @param  mixed $request
     * @return void
     */
    public function register(Request $request){

        $request->validate([
            'name' => 'required|string',
            'email'=> 'required|unique:users|email',
            'password'=> 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email'=> $request->email,
            'password'=> bcrypt($request->password)
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Successfully create a account'
        ]);
    }

    public function logout(){
        Auth::logout();
        Session::flush();
        return response()->json([
            'status' => true,
        ]);
    }
}
