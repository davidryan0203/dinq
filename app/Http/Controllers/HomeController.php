<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactUs;
use Auth;
use App\User;

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

    public function testEmail(){
        // $to_name = 'Ryan David';
        // $to_email = 'davdiryan0203@gmail.com';
        // $data = array('name'=> "Ryan David", "body" => "A test mail");
        // Mail::send('emails.mail', $data, function($message) use ($to_name, $to_email) {
        // $message->to($to_email, $to_name)
        // ->subject('Laravel Test Mail');
        // $message->from('davidryan0203@gmail.com','Test Mail');
        // });
        $data = array('name'=> "Ryan David", "body" => "A test mail");
        Mail::to('davidryan0203@gmail.com')->send(new ContactUs($data));
    }

    public function getUserDetails(){
        return Auth::user();
    }

    public function getCustomers(){
        $users = User::where('user_type', 3)->get();
        return collect($users)->isNotEmpty() ? $users : [];
    }
}
