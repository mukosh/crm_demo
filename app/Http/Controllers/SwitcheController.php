<?php

namespace App\Http\Controllers;

use App\Switche; 
use DB;
use Illuminate\Http\Request;
use Hash;
use Auth;

class SwitcheController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $switches = Switche::latest()->paginate(5);
  
        return view('admin.switches.index',compact('switches'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$switch = DB::table('users')->where('role','Client')->get();
        return view('admin.switches.create');
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
            'name' => 'required|unique:switches|alpha|between:5,20',
            'ip' => 'required|unique:switches',
            'ami_user' => 'required|alpha|between:5,15',
            'ami_password' => 'required',
            'cps' => 'required|min:10|max:200|numeric',
            'call_limit' => 'required|min:100|max:2000|numeric',
            'description' => 'required|max:50'
        ]);
        $data = array(
            'name' => $request->input('name'),
            'ip' => $request->input('ip'),
            'ami_user' => $request->input('ami_user'), 
            'ami_password' => $request->input('ami_password'),  
            'cps' => $request->input('cps'), 
            'call_limit'=>$request->input('call_limit'), 
            'description' => $request->input('description'), 
            'status' => $request->input('status'),
            'created_at' => date('Y-m-d H:i:s') 
        );  
        //print_r($data);die;
        $insert = DB::table('switches')->insert($data);
        if($insert){
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
                'client_id' =>'8000002',
                'module_name' => 'Switch',
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
        }
        return redirect()->route('switches.index')->with('success','Switch created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Switch  $Switche
     * @return \Illuminate\Http\Response
     */
    public function show(Switche $Switche)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Switch  $Switche
     * @return \Illuminate\Http\Response
     */
    public function edit(Switche $Switch)
    {
        
        if(!empty(Auth::user()->email)){
            return view('admin.switches.edit',compact('Switch'));
        }else{
            return view('login');
        } 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Switch  $Switche
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id )
    { 
        $this->validate($request,[ 
            'name' => 'required|alpha|between:5,20|unique:switches,name,'.$id,  
            'cps' => 'required|min:10|max:200|numeric',
            'call_limit' => 'required|min:100|max:2000|numeric',
            'description' => 'required|max:50'
        ]);

        $getSD = Switche::find($id); 
        if($getSD){ 
            $getSD->name = $request->input('name');
            $getSD->cps = $request->input('cps'); 
            $getSD->call_limit = $request->input('call_limit'); 
            $getSD->description = $request->input('description'); 
            $getSD->status = $request->input('status');
            $getSD->updated_at = date('Y-m-d H:i:s');  
            if ($getSD->update()) {
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
                'client_id' =>'8000002',
                'module_name' => 'Switch',
                'activity' => 'Update',
                'data'  => json_encode($getSD),
                'ip_address' => $_SERVER['REMOTE_ADDR'],
                'browser_name' => $_SERVER['HTTP_USER_AGENT'],
                'system_name' => $devices,
                'time' => date('H:i:s'),
                'type' => 'Info',
                'created_at' => date('Y-m-d H:i:s')
            ); 
            DB::table('audit_log')->insert($data_log); 
                return redirect()->route('switches.index')
                ->with('success','Switch updated successfully.'); 
            }
        }  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Switch  $Switche
     * @return \Illuminate\Http\Response
     */
    public function destroy(Switche $Switch)
    {
            $data = json_encode($Switch->toArray()); 
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
                'client_id' =>'8000002',
                'module_name' => 'Switch',
                'activity' => 'Delete',
                'data'  => json_encode($data),
                'ip_address' => $_SERVER['REMOTE_ADDR'],
                'browser_name' => $_SERVER['HTTP_USER_AGENT'],
                'system_name' => $devices,
                'time' => date('H:i:s'),
                'type' => 'Info',
                'created_at' => date('Y-m-d H:i:s')
            ); 
            DB::table('audit_log')->insert($data_log); 
        $Switch->delete();
        return redirect()->route('switches.index')
                ->with('success','Switch deleted successfully.');
    }
}
