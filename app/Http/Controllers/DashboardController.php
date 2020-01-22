<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class DashboardController extends Controller
{
	
    public function index(){
    	if(!empty(Auth::user()->email)){
    		return view('admin.dashboard.dashboard');
    	}else{
    		return view('login');
    	}
       
    }
}
