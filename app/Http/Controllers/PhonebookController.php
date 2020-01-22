<?php

namespace App\Http\Controllers;

use App\Phonebook;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use DB;
use Auth;
use Session;
use Excel;
use File;
//use Maatwebsite\Excel\Excel;

class PhonebookController extends Controller
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
              $phonebooks = Phonebook::join('users', 'phonebooks.client_id', '=', 'users.id')
                  ->select(array('phonebooks.*', 'users.fname','users.lname'))
                  ->where('is_delete', 0)
                  ->orderBy('phonebooks.id', 'DESC')
                  ->paginate(5);
              }else {
                 $phonebooks = Phonebook::join('users', 'phonebooks.client_id', '=', 'users.id')
                  ->select(array('phonebooks.*', 'users.fname','users.lname'))
                  ->where('is_delete', 0)
                  ->where('login_id', Auth::user()->id)
                  ->orderBy('phonebooks.id', 'DESC')
                  ->paginate(5);
              }
                
            return view('admin.phonebooks.index',compact('phonebooks'))
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
        if(!empty(Auth::user()->email)){
            $random = rand(1000000000,9999999999); 
            $phonbook = 'Phonebook_'.date('dmY').'_'.$random;
            $clients = DB::table('users')->where('role','Client')->get();
            return view('admin.phonebooks.create', compact('clients','phonbook'));
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
            'client' =>'required', 
            'phonebook' => 'required',
            'file'  => 'required' 
        ]); 
        $Phonebook = new Phonebook([
            'client_id' => $request->input('client'), 
            'phonebook_name' => $request->input('phonebook'),
            'login_id' => Auth::user()->id,
            'created_at' => date('Y-m-d H:i:s')
        ]); 
        if ($Phonebook->save()) { 
           $extension = File::extension($request->file->getClientOriginalName()); 
           if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") { 
                Schema::create('phonebook_'.$request->input("phonebook").'', function (Blueprint $table) {
                    $table->increments('id');
                    $table->string('contact');  
                    $table->timestamps();
                }); 
            $path = $request->file->getRealPath(); 
            $data = Excel::load($path, function($reader) {
            })->get();
            $data_array1 = $data->toArray(); 
            if($extension == "csv"){
                $data_array = $data_array1;
            }else if($extension == "xlsx"){
                $data_array = $data_array1[0];
            }  
            $bad_contact = array();
            $good_contact = array(); 
            $duplicate_contact = array(); 
            $blankArr = array();
            $val1 = '';
            foreach ($data_array as  $value ) {
              if(!in_array($value, $blankArr))
                { 
                  array_push($blankArr,$value);
                } 
            } 
            foreach($blankArr as $newVal){
              $val =  $newVal['contact'];  
              $val1 = $val;
              if(preg_match("/^\d+\.?\d*$/",$val1) && (strlen($val1)==8 || strlen($val1)==9 || strlen($val1)==10 || strlen($val1)==11 || strlen($val1)==12 || strlen($val1)==13)){ 
                    $good_contact[] = [
                        'contact' => $val1, 
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                }else{ 
                    $bad_contact[] = $val1;
                }
            }

            //die;  
            $gc = count($good_contact); 
            $bc = count($bad_contact);
            //$dc = count($duplicate_contact);
            if(!empty($good_contact)){ 
                $insertData = DB::table('phonebook_'.$request->input("phonebook").'')->insert($good_contact);
                if ($insertData) {
                    Session::flash('success', 'Your Data has successfully imported');
                    //Session::flash('duplicate','Duplicate Contact -'.$dc);
                    Session::flash('success','Total Good Contact -'.$gc);
                    Session::flash('error', 'Total Bad Contact -'.$bc);
                }else {                        
                    Session::flash('error', 'Error inserting the data..');
                    return back();
                }
            } 
            return back(); 
           }else {
            Session::flash('error', 'File is a '.$extension.' file.!! Please upload a valid xlsx, xls and csv file..!!');
            return back();
           }
          }  
              //  return redirect()->route('phonebooks.index')->with('success','Phonebook created successfully.');
           
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Phonebook  $phonebook
     * @return \Illuminate\Http\Response
     */
    public function show(Phonebook $phonebook)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Phonebook  $phonebook
     * @return \Illuminate\Http\Response
     */
    public function edit(Phonebook $phonebook)
    {
        //print_r($phonebook);die;
        $clients = DB::table('users')->where('role','Client')->get();
        return view('admin.phonebooks.edit',compact('phonebook','clients'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Phonebook  $phonebook
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    { 
        $this->validate($request,[ 
            'file'  => 'required' 
        ]);  
        $Phonebook = Phonebook::find($id);
        $table = 'phonebook_'.strtolower($Phonebook->phonebook_name); 
        $update = DB::table('phonebooks')
            ->where('id', $id)
            ->update(['updated_at' => date('Y-m-d H:i:s')]); 
        if ($update) { 
            $extension = File::extension($request->file->getClientOriginalName()); 
            if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {  
            $path = $request->file->getRealPath(); 
            $data = Excel::load($path, function($reader) {
            })->get();
            $data_array1 = $data->toArray(); 
           //print_r($data_array);die;
            if($extension == "csv"){
                $data_array = @$data_array1;
                 //echo 'csv-'.print_r($data_array);die;
            }else if($extension == "xlsx"){
                $data_array = @$data_array1[0];
               // echo 'xlsx-'.print_r($data_array);die;
            }  
            $bad_contact = array();
            $good_contact = array();
            $duplicate_contact = array(); 
            $val1 = '';
            foreach ($data_array as  $value ) {
            print_r($value);
            // if (empty($value)) {
            //   Session::flash('error', 'Please provide correct value in your sheet.');
            // }else{
            //   $val =  @$value['contact'];
            //     $getContact = DB::table($table)->select('contact')->where('contact',$val)->get()->toArray(); 
            //     foreach($getContact as $getC)
            //     {
            //       $C[] = $getC->contact;
            //     }
            //     $cd = @array_pop($C); 
            //     if($val != $cd)
            //     {
            //       $val1 = $val;
            //     }else{
            //       $duplicate_contact[] = $val;
            //     } 
            //     if ($val1 == false) {
            //         Session::flash('error', 'Please provide correct value in your sheet.');
            //     }else{ 
            //       if(preg_match("/^\d+\.?\d*$/",$val1) && (strlen($val1)==8 || strlen($val1)==9 || strlen($val1)==10 || strlen($val1)==11 || strlen($val1)==12 || strlen($val1)==13)){ 
            //           $good_contact[] = [
            //             'contact' => $val1, 
            //             'created_at' => date('Y-m-d H:i:s')
            //           ];
                    
            //       }else{ 
            //           $bad_contact[] = $val1;
            //       }   
            //     }
            // }  
            } 
            die;
            $gc = count($good_contact); 
            $bc = count($bad_contact);
            $dc = count($duplicate_contact);
            if(!empty($good_contact)){ 
                $insertData = DB::table($table)->insert($good_contact);
                if ($insertData) {
                    Session::flash('success', 'Your Data has successfully imported');
                    Session::flash('duplicate','Total Duplicate Contact -'.$dc);
                    Session::flash('success','Total Good Contact -'.$gc);
                    Session::flash('error', 'Total Bad Contact -'.$bc);
                }else {                        
                    Session::flash('error', 'Error inserting the data..');
                    return back();
                }
            } 
            return back(); 
           }else {
            Session::flash('error', 'File is a '.$extension.' file.!! Please upload a valid xlsx, xls and csv file..!!');
            return back();
           }
        } 
 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Phonebook  $phonebook
     * @return \Illuminate\Http\Response
     */
    public function destroy(Phonebook $phonebook)
    {
        $id = $phonebook->id; 
        $Phonebook = Phonebook::find($id);
        if ($Phonebook) {
                $Phonebook->is_delete = 1; 
                if ($Phonebook->update()) {
                    return redirect()->route('phonebooks.index')
                    ->with('success','Phonebook deleted successfully.');
                }
        } 
        //$phonebook->delete();
         
    }

    
}
