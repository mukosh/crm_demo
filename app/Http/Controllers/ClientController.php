<?php

namespace App\Http\Controllers;

use App\User;
use DB;
use Illuminate\Http\Request;
use Hash;
use Auth;

class ClientController extends Controller
{ 
   public function __construct()
    {
       date_default_timezone_set('Asia/Kolkata');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
       // $clients = User::latest()->where('role','Client')->paginate(5);
        if(!empty(Auth::user()->email)){
            $clients = User::all()->where('role','Client')->toArray(); 
            return view('admin.clients.index',compact('clients')); 
        }else{
            return view('login');
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!empty(Auth::user()->email)){
            return view('admin.clients.create');
        }else{
            return view('login');
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
                'fname' =>'required|alpha',
                'lname' =>'nullable|alpha',
                'email'=> 'required|email|unique:users',
                'phone' => 'required|unique:users|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:10',
                'pincode' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:6|max:6',
                'address' => 'required',
                'call_limit' => 'required',
                'pacing' => 'required' 
            ] 
        ); 
       // $model = User::where('email', $request->email)->first();
        $token = bin2hex(random_bytes(50));
        $User = array(
            'fname' => $request->input('fname'),
            'lname' => $request->input('lname'),
            'email' => $request->input('email'), 
            'phone' => $request->input('phone'),  
            'company' => $request->input('company'), 
            'address' => $request->input('address'),
            'call_limit'=>$request->input('call_limit'),
            'pacing'=>$request->input('pacing'),
            'city' => $request->input('city'),
            'pincode' => $request->input('pincode'),
            'state' => $request->input('state'),
            'country' => $request->input('country'),
            'description' => $request->input('description'),
            'token'  => $token,
            'status' => $request->input('status'),
            'created_at' => date('Y-m-d H:i:s') 
        );  
        $insert = DB::table('users')->insert($User); 
        $last_inserted_id = DB::getPDO()->lastInsertId();
            if ($insert) { 
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
                    'client_id' =>$last_inserted_id,
                    'module_name' => 'Client',
                    'activity' => 'Insert',
                    'data'  => json_encode($User),
                    'ip_address' => $_SERVER['REMOTE_ADDR'],
                    'browser_name' => $_SERVER['HTTP_USER_AGENT'],
                    'system_name' => $devices,
                    'time' => date('H:i:s'),
                    'type' => 'Info',
                    'created_at' => date('Y-m-d H:i:s')
                ); 
                DB::table('audit_log')->insert($data_log); 
                return redirect()->route('clients.index')->with('success','Client created successfully.');
            } 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $client)
    {
        if(!empty(Auth::user()->email)){
            return view('admin.clients.edit',compact('client'));
        }else{
            return view('login');
        } 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->validate($request,[
            'fname' =>'required|alpha',
            'lname' =>'nullable|alpha',
            'email'=> 'required|email|unique:users,email,'.$id,
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:10|unique:users,phone,'.$id,
            'pincode' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:6|max:6',
            'address' => 'required',
            'call_limit' => 'required',
            'pacing' => 'required' 
            ] 
        );
        $User = User::find($id);
            
        if ($User) {
                $User->fname = $request->input('fname');
                $User->lname = $request->input('lname');
                $User->email = $request->input('email'); 
                $User->company = $request->input('company'); 
                $User->phone = $request->input('phone'); 
                $User->address = $request->input('address');
                $User->call_limit = $request->input('call_limit');
                $User->pacing = $request->input('pacing');
                $User->city = $request->input('city');
                $User->pincode = $request->input('pincode');
                $User->state = $request->input('state');
                $User->country = $request->input('country');
                $User->description = $request->input('description'); 
                $User->status = $request->input('status');
                $User->updated_at = date('Y-m-d H:i:s');
                if ($User->update()) {
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
                    'client_id' =>$User->id,
                    'module_name' => 'Client',
                    'activity' => 'Update',
                    'data'  => json_encode($User),
                    'ip_address' => $_SERVER['REMOTE_ADDR'],
                    'browser_name' => $_SERVER['HTTP_USER_AGENT'],
                    'system_name' => $devices,
                    'time' => date('H:i:s'),
                    'type' => 'Info',
                    'created_at' => date('Y-m-d H:i:s')
                ); 
                DB::table('audit_log')->insert($data_log); 

                    return redirect()->route('clients.index')
                    ->with('success','Client updated successfully.');
                }
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $client)
    {
        $data = json_encode($client->toArray());
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
            'client_id' =>$client->id,
            'module_name' => 'Client',
            'activity' => 'Delete',
            'data'  => $data,
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'browser_name' => $_SERVER['HTTP_USER_AGENT'],
            'system_name' => $devices,
            'time' => date('H:i:s'),
            'type' => 'Error',
            'created_at' => date('Y-m-d H:i:s')
        ); 
        DB::table('audit_log')->insert($data_log); 
        $client->delete();
        return redirect()->route('clients.index')
                ->with('success','Client deleted successfully.');
    } 
}
