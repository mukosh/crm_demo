<?php

namespace App\Http\Controllers;

use App\Sound;
use App\User;
use Illuminate\Http\Request;  

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
 

class SoundController extends Controller
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
       // echo Auth::user()->id;die;
        if(!empty(Auth::user()->email)){
            if(Auth::user()->role == 'Admin'){
                $sounds = Sound::join('users', 'sounds.client_id', '=', 'users.id')
                ->select(array('sounds.*', 'users.id as c_id'))
                ->orderBy('sounds.id', 'DESC')
                ->paginate(5);
            }else{
                $sounds = Sound::join('users', 'sounds.client_id', '=', 'users.id')
                ->select(array('sounds.*', 'users.id as c_id'))
                ->where('login_id', Auth::user()->id)
                ->orderBy('sounds.id', 'DESC')
                ->paginate(5);
            }

             return view('admin.sounds.index',compact('sounds'))
            ->with('i', (request()->input('page', 1) -1 ) * 5); 
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
        $clients = DB::table('users')->where('role','Client')->get();
        return view('admin.sounds.create',compact('clients'));
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
            'client_id' => 'required',
            'title' => 'required',
            'image' => 'required|mimes:mp3,wav',
            'status' => 'required'
        ]); 
        $image = $request->file('image');
        $new_name = rand(). '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'),$new_name); 
        $Sound = array(
            'client_id' =>  $request->input('client_id'),
            'login_id' => Auth::user()->id,
            'title' =>  $request->input('title'),
            'original_name' => $new_name,
            'status' => $request->input('status'),
            'created_at' => date('Y-m-d H:i:s') 
        );  
        $insert = DB::table('sounds')->insert($Sound); 
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
                    'client_id' =>$request->input('client_id'),
                    'module_name' => 'Sound',
                    'activity' => 'Insert',
                    'data'  => json_encode($Sound),
                    'ip_address' => $_SERVER['REMOTE_ADDR'],
                    'browser_name' => $_SERVER['HTTP_USER_AGENT'],
                    'system_name' => $devices,
                    'time' => date('H:i:s'),
                    'type' => 'Info',
                    'created_at' => date('Y-m-d H:i:s')
                ); 
                DB::table('audit_log')->insert($data_log); 
           return redirect()->route('sounds.index')->with('success','Sound created successfully.');
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sound  $sound
     * @return \Illuminate\Http\Response
     */
    public function show(Sound $sound)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sound  $sound
     * @return \Illuminate\Http\Response
     */
    public function edit(Sound $sound)
    {
        if(!empty(Auth::user()->email)){
            $clients = DB::table('users')->where('role','Client')->get();
            return view('admin.sounds.edit',compact('sound','clients'));
        }else{
             return view('login');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sound  $sound
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {  
        $this->validate($request,[  
            'title' => 'required', 
            'status' => 'required'
        ]);

        $form_data = array( 
            'title' =>  $request->input('title'), 
            'status' => $request->input('status') 
        ); 
        $update = Sound::whereId($id)->update($form_data);
        if($update){
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
                'client_id' =>$request->input('c_id'),
                'module_name' => 'Sound',
                'activity' => 'Update',
                'data'  => json_encode($form_data),
                'ip_address' => $_SERVER['REMOTE_ADDR'],
                'browser_name' => $_SERVER['HTTP_USER_AGENT'],
                'system_name' => $devices,
                'time' => date('H:i:s'),
                'type' => 'Info',
                'created_at' => date('Y-m-d H:i:s')
            ); 
            DB::table('audit_log')->insert($data_log); 
        }

        return redirect()->route('sounds.index')->with('success','Sound updated successfully.'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sound  $sound
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sound $sound)
    {    
        $data = json_encode($sound->toArray());
        $dt = $sound->toArray();
        $path = $dt['original_name']; 
        $filename = public_path().'/images/'.$path;
         
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
            'client_id' =>$sound->client_id,
            'module_name' => 'Sound',
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
        \File::delete(@$filename); 
        $sound->delete();
        return redirect()->route('sounds.index')
                ->with('success','Sound deleted successfully.');
    }
}
