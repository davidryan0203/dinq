<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Venue;
use App\Supplier;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data){
        $userId = 0;
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'civil_status' => 'single',
            'user_type' => $data['user_type'],
            'is_active' => 1,
            'username' => $data['username']
        ]);

        //dd((User::latest()->first()->id + 1));
        if($data['user_type'] == 1){
            $venue = new Venue;
            $venue->description = $data['description'];
            $venue->contact_number = $data['contact_number'];
            $venue->longitude = $data['longitude'];
            $venue->latitude = $data['latitude'];
            $venue->user_id = $user->id;  
            $venue->venue_type = $data['venue_type'];
            $venue->address = $data['address'];
            $venue->save();

            return $user;
        }

        if($data['user_type'] == 2){

            $supplier = new Supplier;
            $supplier->contact_name = $data['contact_name'];
            $supplier->contact_number = $data['contact_number'];
            $supplier->user_id = $user->id;
            $supplier->save();

            return $user;
        }
    }
}
