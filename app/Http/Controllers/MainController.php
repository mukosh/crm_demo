<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;

class MainController extends Controller
{

  public function __construct()
    {
       date_default_timezone_set('Asia/Kolkata');
    }

   public function index(){

       return view('login');
   }

   // public function login(Request $request)
   // {
   //    $this->validate(request(),[
   //           'email' => 'email|string',
   //           'password' => 'required|min:3'
   //       ]);
   //      $email = $request->get('email');
   //      $password = md5($request->get('password'));
   //      $getLoginDetails =  DB::table('users')->where('email',$email)->where('password',$password)->get();
   //      $count = User::all()->where('email',$email)->where('password',$password)->count(); 
   //      if($count > 0)
   //      {
   //        $get_email = $getLoginDetails[0]->email;
   //        $get_password = $getLoginDetails[0]->password;
   //        if($get_email == $email AND $get_password == $password) {
   //           return redirect('dashboard');
   //        }else{
   //          return Redirect::back()->withErrors(['error','Wrong Login Details']);
   //        }
   //      }

   // }

   public function login(Request $request){ 
        $this->validate(request(),[
            'email' => 'required|email|string',
            'password' => 'required|min:3'
        ]);
        
        $user_data = array(
            'email' => $request->get('email'),
            'password' => $request->get('password')
        );
        
        if(Auth::attempt($user_data))
        {
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
                  'client_id' => @Auth::user()->id,
                  'module_name' => 'Login',
                  'activity' => 'Login',
                  'data'  => json_encode($user_data),
                  'ip_address' => $_SERVER['REMOTE_ADDR'],
                  'browser_name' => $_SERVER['HTTP_USER_AGENT'],
                  'system_name' => $devices,
                  'time' => date('H:i:s'),
                  'type' => 'Info',
                  'created_at' => date('Y-m-d H:i:s')
              ); 
              DB::table('audit_log')->insert($data_log); 
            return redirect('dashboard');
        }
        else
        {
            return back()->with('error','Wrong Login Details');
        }
   }
   
   public function dashboard(){
       return view('dashboard');
   }
   
   public function logout(){
            // $useragent = $_SERVER['HTTP_USER_AGENT']; 
            // $iPod = stripos($useragent, "iPod"); 
            // $iPad = stripos($useragent, "iPad"); 
            // $iPhone = stripos($useragent, "iPhone");
            // $Android = stripos($useragent, "Android"); 
            // $iOS = stripos($useragent, "iOS");  
            // $DEVICE = ($iPod||$iPad||$iPhone||$Android||$iOS);
            // if (!$DEVICE) {
            //     $devices = 'Desktop';
            // }else{
            //     $devices = 'Mobile';
            // }
            // $data_log = array( 
            //       'client_id' => @Auth::user()->id,
            //       'module_name' => 'Logout',
            //       'activity' => 'Logout',
            //       'data'  => Auth::user()->email,
            //       'ip_address' => $_SERVER['REMOTE_ADDR'],
            //       'browser_name' => $_SERVER['HTTP_USER_AGENT'],
            //       'system_name' => $devices,
            //       'time' => date('H:i:s'),
            //       'type' => 'Info',
            //       'created_at' => date('Y-m-d H:i:s')
            //   ); 
            //   DB::table('audit_log')->insert($data_log);
        Auth::logout();
        return redirect('/');
   }
    
}
