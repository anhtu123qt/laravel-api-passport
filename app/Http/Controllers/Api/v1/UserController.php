<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\User;

class UserController extends Controller
{
    public function register(Request $request) {
        $data = $request->only('name','email','password');
        $validator = Validator::make($data,[
            'name'=> 'required',
            'email'=> 'required|unique:users',
            'password'=> 'required'
        ]);
        if($validator->fails()){
            return response()->json(['error'=>$validator->messages()],400);
        }
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);
        return response()->json(['status'=>true,'user'=>$user],201);
    }
    public function login(Request $request){
        $data = $request->only('email','password');
        $validator = Validator::make($data,[
            'email'=> 'required',
            'password'=> 'required'
        ]);
        if($validator->fails()){
            return response()->json(['error'=>$validator->messages()],400);
        }
        if(!Auth::attempt($data)){
            return response()->json(['message'=>'Invalid login'],400);
        }
        $accessToken = Auth::user()->createToken('api-token')->accessToken;
        return response()->json(['status'=>true,'message'=>'Login successful','token'=>$accessToken],200);
    }
    public function me(){
        return Auth::user();
    }
}
