<?php

namespace App\Http\Controllers; 
use App\User;
use Illuminate\Http\Request;   

class TestController extends Controller
{
    public function __construct()
    {
       date_default_timezone_set('Asia/Kolkata');
    }
     
    public function index()
    {
        echo "mukesh Jha";
    } 
}
