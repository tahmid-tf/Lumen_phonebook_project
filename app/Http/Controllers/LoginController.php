<?php

namespace App\Http\Controllers;
use \Firebase\JWT\JWT;


use Illuminate\Http\Request;
use App\Models\RegistrationModel;

class LoginController extends Controller
{

    public function tokenTest(){
        return "Token is ok";
    }

    public function onLogin(Request $request){
        $key = env('TOKEN_KEY');

        $username = $request->input('username');
        $password = $request->input('password');

        $payload = array(
            "iss" => "http://demo.com",
            "user" => $username,
            "iat" => time(),
            "exp" => time() + 3000
        );

        $jwt = JWT::encode($payload, $key);
        return response()->json([
            'Token' => $jwt,
            'Status' => 'Login Success'
        ]);

        $userCount = RegistrationModel::where(['username'=>$username,'password'=>$password])->count();
        if($userCount == 1){
            return $key;
        }else{
            return "Wrong username or password";
        }
    }
}
