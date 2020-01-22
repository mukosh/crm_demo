<?php 
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
 
 

class LoginController extends Controller
{ 
    public function login(){
        $credentials = $this->validate(request(),[
            'email' => 'email|required|string',
            'password' => 'required|string'
        ]);
        //return $credentials;
        if(Auth::attempt($credentials)){
           return 'correct'; 
       }
 
        return back()->withErrors([ 'email' => trans('auth.failed') ]);
    }
}