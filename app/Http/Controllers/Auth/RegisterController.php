<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Venue;
use App\Country;
use App\Supplier;
use App\Currency;
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
            'username' => $data['username'],
            'contact_number' => $data['contact_number'],
        ]);
        
        if($data['user_type'] == 1){
            $client = new \GuzzleHttp\Client();
            
            $client = new \GuzzleHttp\Client(['base_uri' => 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.$data['latitude'].','.$data['longitude'].'&key=AIzaSyByTWPwUTPmcOh6FGaHCo0HUAiFxFSsAyE']);

            $response = $client->request('GET', '', []);
            if($response){
                $address = json_decode($response->getBody()->getContents(),true)['results'][0]['address_components'];
                
                foreach($address as $value){
                    foreach($value['types'] as $key => $val){
                        if($val == 'country'){
                            $country = Country::where('iso', $value['short_name'])->first();
                            if($country){
                                $userData = User::where('id', $user->id)->first();
                                $userData->country_id = $country->id;
                                $userData->save();
                            }
                        }
                    } 
                }
            }

            $currency = Currency::where('code',$data['currency'])->first();
            $venue = new Venue;
            $venue->description = $data['description'];
            $venue->contact_number = $data['contact_number'];
            $venue->longitude = $data['longitude'];
            $venue->latitude = $data['latitude'];
            $venue->user_id = $user->id;  
            $venue->default_currency = $currency->id;
            $venue->venue_type = $data['venue_type'];
            $venue->address = $data['address'];

                // $image = Image::make($request->file('img_url')->getRealPath());
                // $img = Image::make($request)->resize(320, 240)->insert('public/watermark.png');
                $img = \Image::make($data['img_url'])->resize(200, 200);

                $mime = $img->mime();  //edited due to updated to 2.x
                if ($mime == 'image/jpeg')
                    $extension = '.jpg';
                elseif ($mime == 'image/png')
                    $extension = '.png';
                elseif ($mime == 'image/gif')
                    $extension = '.gif';
                else
                    $extension = '';
                $name = sha1(date('YmdHis') . $this->generateRandomString());
                $img_name = $name . $extension;

                $path = public_path('/images/venue/' . $img_name);
                $img->save($path);
                $venue->img_url = ($data['img_url']) ? '/images/venue/' . $img_name : '';

            $venue->save();

            return $user;
        }

        if($data['user_type'] == 2){

            $supplier = new Supplier;
            $currency = Currency::where('code',$data['currency'])->first();
            $supplier->contact_name = $data['contact_name'];
            $supplier->contact_number = $data['contact_number'];
            $supplier->default_currency = $currency->id;
            $supplier->default_tax_rate = 1;
            $supplier->user_id = $user->id;

                // $image = Image::make($request->file('img_url')->getRealPath());
                // $img = Image::make($request)->resize(320, 240)->insert('public/watermark.png');
                $img = \Image::make($data['img_url'])->resize(200, 200);

                $mime = $img->mime();  //edited due to updated to 2.x
                if ($mime == 'image/jpeg')
                    $extension = '.jpg';
                elseif ($mime == 'image/png')
                    $extension = '.png';
                elseif ($mime == 'image/gif')
                    $extension = '.gif';
                else
                    $extension = '';
                $name = sha1(date('YmdHis') . $this->generateRandomString());
                $img_name = $name . $extension;

                $path = public_path('/images/supplier/' . $img_name);
                $img->save($path);
                $supplier->img_url = ($data['img_url']) ? '/images/supplier/' . $img_name : '';

            $supplier->save();

            return $user;
        }
    }
    
    public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
