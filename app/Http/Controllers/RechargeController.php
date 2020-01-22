<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
class RechargeController extends Controller
{
    public function __construct()
    {
       date_default_timezone_set('Asia/Kolkata');
    }
    public function index(){

    	if(!empty(Auth::user()->email)){
            if(Auth::user()->role == 'Admin'){
                $recharge = DB::table('recharge_history') 
            		->join('users', 'users.id', '=', 'recharge_history.client_id') 
                    ->select('recharge_history.*', 'users.fname','users.lname')
                    ->orderBy('recharge_history.id','DESC')  
                    ->get(); 
            }else{
                $recharge = DB::table('recharge_history') 
                    ->join('users', 'users.id', '=', 'recharge_history.client_id') 
                    ->select('recharge_history.*', 'users.fname','users.lname')
                    ->where('client_id', Auth::user()->id)
                    ->orderBy('recharge_history.id','DESC')  
                    ->get();  
            }
        return view('admin.recharge.index',compact('recharge'));
    	 
        }else{
            return view('login');
        }
    	
    }

    public function rechargeview(Request $request)
	{
	    if($request->ajax())
	    { 
	        $id = $request->post('id');
	        $recharge =DB::table('recharge_history') 
	    		->join('users', 'users.id', '=', 'recharge_history.client_id') 
	            ->select('recharge_history.*', 'users.fname','users.lname')
	            ->where('recharge_history.id', $id)  
	            ->get(); 
	        print_r(json_encode($recharge)); 
	    }
	}
}
