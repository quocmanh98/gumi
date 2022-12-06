<?php

namespace App\Http\Controllers\Demo;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DemoAuthController extends Controller
{
    public function login(){
        return view('demo.login');
    }

    public function handleLogin(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ]);

        if($validator->passes()){
            $data = $request->only('email', 'password');
            $check_login = Auth::attempt($data);
            if($check_login){
                if(Auth::user()->status == 0){
                    Auth::logout();
                    return response()->json(['success' => false,'error' => 'Tài khoản của bạn chưa kích hoạt']);
                }
                $token = Auth::user()->createToken('token')->plainTextToken;
                // Trả về dạng mảng chứa thông tin token
                return response()->json(['data' => Auth::user(),'token'=> $token]);
            }
        }else{
            return response()->json(['success' => false,'error' => $validator->errors()]);
        }


    }
}
