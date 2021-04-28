<?php

namespace App\Http\Controllers;
use \Firebase\JWT\JWT;
use App\Models\PhoneBookModel;

use Illuminate\Http\Request;

class PhoneBookController extends Controller
{
    public function onInsert(Request $request){

        $token = $request->input('access_token');
        $decoded = JWT::decode($token, env('TOKEN_KEY'), array('HS256'));
        $decoded_array = (array)$decoded;

       $one = $request->input('one');
       $two = $request->input('two');
       $name = $request->input('name');
       $email = $request->input('email');

       $user =  $decoded_array['user'];

       $result = PhoneBookModel::insert([
        'username' => $user,
        'phone_number_one' => $one,
        'phone_number_two' => $two,
        'name' => $name,
        'email' => $email
    ]);

        if($result){
            return "Save Success";
        }else{
            return "faild try again";
        }

    }

    public function onSelect(Request $request){
        $token = $request->input('access_token');
        $decoded = JWT::decode($token, env('TOKEN_KEY'), array('HS256'));
        $decoded_array = (array)$decoded;

       $user =  $decoded_array['user'];

        $result = PhoneBookModel::where('username',$user)->get();

        return $result;
    }

    public function onDelete(Request $request){
        $token = $request->input('access_token');
        $email = $request->input('email');
        $decoded = JWT::decode($token, env('TOKEN_KEY'), array('HS256'));
        $decoded_array = (array)$decoded;

       $user =  $decoded_array['user'];

       $result = PhoneBookModel::where(['username'=>$user,'email'=>$email])->delete();

       if($request){
        return "Delete success";
       }else{
           return "Delete faild";
       }
    }
}
