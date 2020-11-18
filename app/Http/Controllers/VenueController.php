<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Venue;
use App\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;   

class VenueController extends Controller
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
        $info = Venue::with('user')->where('user_id',Auth::user()->id)->first();
        return view('venue.index')->with('info', $info);;
    }

    public function edit(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,'. Auth::user()->id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'. Auth::user()->id],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $input = $request->all();

        $venue = Venue::where('user_id', Auth::user()->id)->first();
        $venue->description = $input['description'];
        $venue->save();

        $user = User::where('id', Auth::user()->id)->first();
        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->username = $input['username'];
        $user->password = Hash::make($input['password']);
        $venue->save();

        return redirect('venue')->with('status', 'Venue Profile updated!');
    }
}
