<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\FeedbackMail;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function sendFeedback()
    {
       $comment = 'Hi, This test feedback.';
       $toEmail = "mukeshjh4@gmail.com";
       Mail::to($toEmail)->send(new FeedbackMail($comment)); 
       return 'Email has been sent to '. $toEmail;
    }
}
