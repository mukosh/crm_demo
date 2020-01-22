<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Excel;


class ImportController extends Controller
{
    public function import(Request $request)
    {
     $this->validate($request, [
      'import_file'  => 'required|mimes:xls,xlsx'
     ]);

     $path = $request->file('import_file')->getRealPath();

     $data = Excel::load($path)->get();

     if($data->count() > 0)
     {
      foreach($data->toArray() as $key => $value)
      {
       foreach($value as $row)
       {
        $insert_data[] = array(
         'client_id'  => $row['client_id'],
         'campaign_id'   => $row['campaign_id'],
         'phonebook'   => $row['phonebook'],
         'description'    => $row['description'] 
        );
       }
      }

      if(!empty($insert_data))
      {
       DB::table('phonebooks')->insert($insert_data);
      }
     }
     return back()->with('success', 'Phonebook Imported successfully.');
    }
}
