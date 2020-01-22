<?php

namespace App\Http\Controllers;

use App\Caller;
use App\User;
use Illuminate\Http\Request;
use DB;
use Auth;

class CallerController extends Controller
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
        if(!empty(Auth::user()->email)){
            if(Auth::user()->role == 'Admin'){
                $callers = Caller::join('users', 'callers.client_id', '=', 'users.id')
                ->select(array('callers.*', 'users.id as c_id'))
                ->orderBy('callers.id', 'DESC')
                ->paginate(5);
            }else{
                $callers = Caller::join('users', 'callers.client_id', '=', 'users.id')
                ->select(array('callers.*', 'users.id as c_id'))
                ->where('login_id', Auth::user()->id)
                ->orderBy('callers.id', 'DESC')
                ->paginate(5);
            }

             return view('admin.callers.index',compact('callers'))
            ->with('i', (request()->input('page', 1) -1 ) * 5); 
        }else{
            return view('login');
        }

        // $callers = Caller::latest()->paginate(5);
        // return view('admin.callers.index',compact('callers'))
        //     ->with('i', (request()->input('page', 1) -1 ) * 5); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = DB::table('users')->where('role','Client')->get();
        return view('admin.callers.create',compact('clients'));
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
            'caller' => 'required' 
        ]);
        $data = array(
            'client_id' =>  $request->input('client_id'),
            'login_id' => Auth::user()->id,
            'caller_id' =>  $request->input('caller'), 
            'created_at' => date('Y-m-d H:i:s') 
        );  
        $insert = DB::table('callers')->insert($data); 
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
                    'module_name' => 'Caller Id',
                    'activity' => 'Insert',
                    'data'  => json_encode($data),
                    'ip_address' => $_SERVER['REMOTE_ADDR'],
                    'browser_name' => $_SERVER['HTTP_USER_AGENT'],
                    'system_name' => $devices,
                    'time' => date('H:i:s'),
                    'type' => 'Info',
                    'created_at' => date('Y-m-d H:i:s')
                ); 
                DB::table('audit_log')->insert($data_log); 
           return redirect()->route('callers.index')->with('success','Callers Id created successfully.');
        } 
         
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Caller  $caller
     * @return \Illuminate\Http\Response
     */
    public function show(Caller $caller)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Caller  $caller
     * @return \Illuminate\Http\Response
     */
    public function edit(Caller $caller)
    {
        $clients = DB::table('users')->where('role','Client')->get();
        return view('admin.callers.edit',compact('caller','clients'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Caller  $caller
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //$caller->update($request->all());
        $this->validate($request,[  
            'client_id' => 'required', 
            'caller_id' => 'required'
        ]);

        $data = array( 
            'client_id' =>  $request->input('client_id'), 
            'caller_id' => $request->input('caller_id') 
        ); 
        $update = Caller::whereId($id)->update($data);
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
                'client_id' =>$request->input('client_id'),
                'module_name' => 'Caller Id',
                'activity' => 'Update',
                'data'  => json_encode($data),
                'ip_address' => $_SERVER['REMOTE_ADDR'],
                'browser_name' => $_SERVER['HTTP_USER_AGENT'],
                'system_name' => $devices,
                'time' => date('H:i:s'),
                'type' => 'Info',
                'created_at' => date('Y-m-d H:i:s')
            ); 
            DB::table('audit_log')->insert($data_log); 
        }
        return redirect()->route('callers.index')
                ->with('success','Caller Id updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Caller  $caller
     * @return \Illuminate\Http\Response
     */
    public function destroy(Caller $caller)
    {
        $data = json_encode($caller->toArray());
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
            'client_id' =>$caller->client_id,
            'module_name' => 'Caller Id',
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
        $caller->delete();
        return redirect()->route('callers.index')
                ->with('success','Caller Id deleted successfully.');
    }
}
