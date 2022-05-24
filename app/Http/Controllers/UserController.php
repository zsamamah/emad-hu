<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        if($request['name'] && $request['email'] && $request['password']){
            $user = User::create([
                'name'=>$request['name'],
                'email'=>$request['email'],
                'password'=>Hash::make($request['password'])
            ]);
            return response($user,200);
        }
        else{
            return response(['message'=>'Error Occuured!'],202);
        }
    }
    public function login(Request $request)
    {
        //check email
        $user = User::where('email', $request['email'])->first();

        if (!$user)
            return response(['message'=>'Email Not Found!'], 201);

        //check password
        if (!Hash::check($request['password'], $user->password)) {
            return response(['message'=>'Wrong Password'], 202);
        }
        $response = [
            'user' => $user,
            // 'token'=>$token
        ];
        return response($response, 200);
    }
}
