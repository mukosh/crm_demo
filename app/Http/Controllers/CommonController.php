<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request; 
use Illuminate\Http\Response;
use DB;
use Auth;
use Hash;
use Excel;

class CommonController extends Controller
{
	public function __construct()
    {
       date_default_timezone_set('Asia/Kolkata');
    }
    public function viewclient(Request $request)
	{
	    if($request->ajax())
	    { 
	        $clientId = $request->post('clientId');
	        $clients = DB::select("select * from users where id='".$clientId."'");  
	        print_r(json_encode($clients)); 
	    }
	
	}
	public function balance(Request $request)
	{
	    if($request->ajax())
	    { 
	        $clientId = $request->post('clientId');
	        $clients = DB::select("select * from users where id='".$clientId."'");  
	        print_r(json_encode($clients)); 
	    }
	}
	public function createbalance(Request $request)
	{ 
		$clientId = $request->post('client_id');
		$balance = $request->post('balance');
		$amount = $request->post('amount');
		$description = $request->post('description');
		$data = array(
				'client_id' => $clientId,
				'balance' => $balance,
				'amount' => $amount,
				'description' => $description,
				'created_at' => date('Y-m-d H:i:s')
			); 
			$useragent = $_SERVER['HTTP_USER_AGENT']; 
            $iPod = stripos($useragent, "iPod"); 
            $iPad = stripos($useragent, "iPad"); 
            $iPhone = stripos($useragent, "iPhone");
            $Android = stripos($useragent, "Android"); 
            $iOS = stripos($useragent, "iOS");  
            $DEVICE = ($iPod||$iPad||$iPhone||$Android||$iOS);
            if (!$DEVICE) {
                $devices = 'Desktop';
            }else{
                $devices = 'Mobile';
            } 
		$data_log = array(
				'client_id' => $clientId,
				'module_name' => 'Recharge',
				'activity' => 'Insert',
				'data'	=> json_encode($data),
				'ip_address' => $_SERVER['REMOTE_ADDR'],
				'browser_name' => $_SERVER['HTTP_USER_AGENT'],
				'system_name' => $devices,
				'time' => date('H:i:s'),
				'type' => 'Info',
				'created_at' => date('Y-m-d H:i:s')
			);

		$insert = DB::table('recharge_history')->insert($data);
		 DB::table('audit_log')->insert($data_log);
		if($insert){ 
			DB::table('users')
            ->where('id', $clientId)
            ->update(['balance' => $amount+$balance]);
            echo 'Saved Successfully.';
		}
	}

	public function logs(Request $request)
	{
		if(!empty(Auth::user()->email)){
		$logs = DB::table('audit_log') 
    		->join('users', 'users.id', '=', 'audit_log.client_id') 
            ->select('audit_log.*', 'users.fname','users.lname')
            ->orderBy('audit_log.id','DESC')  
            ->get(); 
        return view('admin.logs.index',compact('logs')); 
    	}else{
    		return view('login');
    	}
	}
	public function setpassword(Request $request)
	{   
		$token = $request->get('token');
        return view('setpassword', compact('token'));  
	}

	public function updatepassword(Request $request, $slug){  
	    $this->validate($request,[
            'pass' => 'required|min:6',
            'cpass' => 'required|required_with:pass|same:pass|min:6',
            ] 
        );
	    $userRecord = DB::select("select * from users where token='".$slug."'"); 
	    $email = $userRecord[0]->email;
	    $email_verified = $userRecord[0]->email_verified; 
	    $password = Hash::make($request->input('pass'));
	   // echo $password;die;
        $update = DB::select("update users set password='".$password."', email_verified='1' where email='".$email."'");
         return redirect('/main')->with('success','Password created, Now you can login');
        }

    public function logsview(Request $request)
	{
	    if($request->ajax())
	    { 
	    	$id = $request->post('id');
	    	$logs = DB::table('audit_log') 
	    		->join('users', 'users.id', '=', 'audit_log.client_id') 
	            ->select('audit_log.*', 'users.fname','users.lname')
	            ->where('audit_log.id',$id)  
	            ->get(); 
	        
	       // $logs = DB::select("select * from audit_log where id='".$id."'");  
	        print_r(json_encode($logs)); 
	    }
	
	}

	public function callercreateajax(Request $request)
	{ 
		$otp = rand(1000,9999);  
		$clientId = $request->post('client_id');
		$caller = $request->post('caller'); 
		$data = array(
			'client_id' => $clientId,
			'caller_id' => $caller,
			'login_id' =>  Auth::user()->id,
			'otp' => $otp, 
			'created_at' => date('Y-m-d H:i:s')
		); 
		$useragent = $_SERVER['HTTP_USER_AGENT']; 
        $iPod = stripos($useragent, "iPod"); 
        $iPad = stripos($useragent, "iPad"); 
        $iPhone = stripos($useragent, "iPhone");
        $Android = stripos($useragent, "Android"); 
        $iOS = stripos($useragent, "iOS");  
        $DEVICE = ($iPod||$iPad||$iPhone||$Android||$iOS);
        if (!$DEVICE) {
            $devices = 'Desktop';
        }else{
            $devices = 'Mobile';
        }  
		$data_log = array(
			'client_id' => $clientId,
			'module_name' => 'Caller ID',
			'activity' => 'Insert',
			'data'	=> json_encode($data),
			'ip_address' => $_SERVER['REMOTE_ADDR'],
			'browser_name' => $_SERVER['HTTP_USER_AGENT'],
			'system_name' => $devices,
			'time' => date('H:i:s'),
			'type' => 'Info',
			'created_at' => date('Y-m-d H:i:s')
		); 
		DB::table('callers')->insert($data);
		DB::table('audit_log')->insert($data_log); 
	}

	public function calleridverifyajax(Request $request)
	{  
		$otp = $request->post('otp'); 
		DB::table('callers')
            ->where('otp', $otp)
            ->update(['is_verify' => 1, 'updated_at' => date('Y-m-d H:i:s')]);
            echo 'Caller Id successfully verifyed.'; 
	}

	public function sendOtp(Request $request)
	{
		$otp = rand(1000,9999); 
		$id = $request->post('id'); 
		DB::table('callers')
            ->where('id', $id)
            ->update(['otp' => $otp, 'updated_at' => date('Y-m-d H:i:s')]);
           // echo 'Caller Id successfully verifyed.'; 
	}

	public function checkCallerId(Request $request){  
	      	$caller = $request->post('caller');  
	        $caller_count = DB::table('callers')
			     ->where('caller_id', '=', $caller) 
			     ->count();   
	         
	        	if($caller_count > 0)  
		        {
		        	echo(json_encode("Caller Id Already Exist")); 
		        }else{
		        	echo(json_encode(true)); 
		        } 
		}

	public function get_phonebook_table(Request $request)
	{
	    if($request->ajax())
	    { 
	        $id = $request->post('id');
	        $phonebook_data = DB::select("select * from phonebooks where id='".$id."'");  
	        print_r(json_encode($phonebook_data)); 
	    }
	}

	public function addcontactajax(Request $request)
	{  
		if($request->ajax())
	    { 
			$contact = $request->post('contact');
			$table = 'phonebook_'.$request->post('phonebook_table'); 
			$data  = array('contact' => $contact , 'created_at' => date('Y-m-d') );
			$insert = DB::table($table)->insert($data); 
			if($insert)
	            echo 'Cotact added successfully.';
	    } 
	}

	public function checkDuplicateContactPhonebook(Request $request)
	{
		$contact = $request->post('contact');
		$table = strtolower('phonebook_'.$request->post('phonebook_table')); 
    	$contact_count = DB::table($table)
			     ->where('contact', '=', $contact) 
			     ->count(); 
	         if($contact_count > 0)  
	         { 
	       	 	echo(json_encode("Invalid contact number")); 
	         }else{ 
	       	 	echo(json_encode(true)); 
	         } 

	}

	public function search_contact(Request $request)
	{ 
		$sdata = $request->search_data;
		$pbtable = strtolower($request->post('pb_table')); 
		$posts = DB::table($pbtable)->where('contact','LIKE','%'.$sdata.'%')->get();
		$count = DB::table($pbtable)->where('contact','LIKE','%'.$sdata.'%')->count(); 
		//echo $count;
		if($count != 0){
			echo '<table class="table table-hover">
            <thead>
              <tr> 
                <th>Client Number</th>  
                <th colspan="1">Action</th>
              </tr>
            </thead>
            <tbody>';
				foreach ($posts as $value) { 
					echo '<tr> 
		                      <td>'.$value->contact.'</td> 
		                      <td>   
		                          <button type="button" class="btn btn-danger del_contact" data-id="'.$value->id.'">❌</button> 
		                      </td>
		                  </tr>';
				}
			echo '</tbody>
            </table>';
		}else{
			echo '<div class="alert alert-danger">Record not found</div>';
		} 
	}

	public function delete_pb_contact(Request $request){
		$id = $request->post('id'); 
		$pbtable = strtolower($request->post('pb_table')); 
		$query = DB::table($pbtable)->where('id', $id)->delete();
		if($query)
		{
			echo "Removed";
		}
	}

	public function send_pb_otp(Request $request)
	{
		$otp = rand(1000,9999); 
		$cid = $request->post('client_id'); 
		$query = DB::table('users')
            ->where('id', $cid)
            ->update(['otp' => $otp]); 
    }

    public function check_pb_otp_ajax(Request $request){
    	$id = $request->input('pb_id'); 
    	$query = DB::table('phonebooks')
            ->where('id', $id)
            ->update(['is_otp' => 1]); 
    }

    public function checkValidOtp(Request $request)
    {
    	$otp = $request->input('otp');
    	$otp_count = DB::table('users')
			     ->where('otp', '=', $otp) 
			     ->count(); 
	         if($otp_count == 0)  
	         { 
	       	 	echo(json_encode("Invalid OTP")); 
	         }else{ 
	       	 	echo(json_encode(true)); 
	         } 
    }

    public function checkCallerValidOtp(Request $request)
    {
    	$otp = $request->input('otp');
    	$otp_count = DB::table('callers')
			     ->where('otp', '=', $otp) 
			     ->count(); 
	         if($otp_count == 0)  
	         { 
	       	 	echo(json_encode("Invalid OTP")); 
	         }else{ 
	       	 	echo(json_encode(true)); 
	         } 
    }

    public function download_excel(Request $request)
    { 

    	$table = strtolower('phonebook_'.$request->get('table'));
    	$id = $request->get('id'); 

    	$query = DB::table('phonebooks')
	        	->where('id', $id)
	        	->update(['is_otp' => 0]);
	    if($query){ 
		    $customer_data = DB::table($table)->get()->toArray();
		    $customer_array[] = array('Contact Number');
		    foreach($customer_data as $customer)
		    {
			    $customer_array[] = array(
			       'Contact Number'  => $customer->contact
			    );
		    }
		    Excel::create('Contact', function($excel) use ($customer_array){
			    $excel->setTitle('Contact');
			    $excel->sheet('Contact', function($sheet) use ($customer_array){
			    	$sheet->fromArray($customer_array, null, 'A1', false, false);
			      });
		    })->download('xlsx');
		   redirect(Request::url());
		}	 
	    
    }

}
