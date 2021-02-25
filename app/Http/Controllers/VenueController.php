<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Venue;
use App\TaxRates;
use App\User;
use Image;
use App\Country;
use App\MenuItem;
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
        $taxRates = TaxRates::all();
        return view('venue.index')->with(['info' => $info, 'taxRates' => $taxRates]);
    }

    public function editVenue($id){
        $info = Venue::with('user')->where('user_id',$id)->first();
        $taxRates = TaxRates::all();
        return view('venue.index')->with(['info' => $info, 'taxRates' => $taxRates]);
    }

    public function adminVenue()
    {
        return view('admin.venue');
    }

    public function getAllVenues(){
        $info = User::with('venue')->where(['user_type' => 1])->get();
        return $info;
    }

    public function getSupplierVenues(){
        $info = MenuItem::where('supplier_id','=',Auth::user()->supplier->id)->get();
        $menu = collect($info)->unique('venue_id')->toArray();
        $venues = [];
        foreach($menu as $key => $item){
            $venues[] = Venue::with('user')->where('id','=',$item['venue_id'])->first();
        }
        //dd($venues);
        return $venues;
    }

    /**
     * Create a thumbnail of specified size
     *
     * @param string $path path of thumbnail
     * @param int $width
     * @param int $height
     */
    public function createThumbnail($path, $width, $height)
    {
        $img = Image::make($path)->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save($path);
    }

    public function edit(Request $request, $id){
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users,username,'. $id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'. $id],
            'password' => ['confirmed'],
        ]);

        $input = $request->all();

        $venue = Venue::where('user_id', $id)->first();
        // $venue->description = $input['description'];
        $venue->save();

        $user = User::where('id', $id)->first();
        $user->email = $input['email'];
        $user->username = $input['username'];
        if(!empty($input['password'])){
            $user->password = Hash::make($input['password']);
        }
        $user->save();
        if(Auth::user()->user_type == 0){
            return redirect('venue/edit/'.$id)->with('status', 'Venue Profile updated!');
        }else{
            return redirect('venue')->with('status', 'Venue Profile updated!');
        }
    }

    public function editGeneral(Request $request, $id){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $input = $request->all();
        $venue = Venue::where('user_id', $id)->first();
        $venue->description = $input['description'];
        
        $venue->url = $input['url'];
        $venue->latitude = $input['mapLatitude'];
        $venue->longitude = $input['mapLongitude'];

        if($request->hasFile('img_url')) {
            // $image = Image::make($request->file('img_url')->getRealPath());
            // $img = Image::make($request)->resize(320, 240)->insert('public/watermark.png');
            $img = \Image::make($input['img_url'])->resize(200, 200);

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
            $venue->img_url = ($input['img_url']) ? '/images/venue/' . $img_name : '';
        }

        $venue->save();

        $user = User::where('id', Auth::user()->id)->first();
        $user->country_id = 0;
        $user->name = $input['name'];
        $user->contact_number = $input['contact_number'];
        $user->save();

        $client = new \GuzzleHttp\Client();
        
        $client = new \GuzzleHttp\Client(['base_uri' => 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.$input['mapLatitude'].','.$input['mapLongitude'].'&key=AIzaSyByTWPwUTPmcOh6FGaHCo0HUAiFxFSsAyE']);

        $response = $client->request('GET', '', []);
        if($response){
            $address = json_decode($response->getBody()->getContents(),true)['results'][0]['address_components'];
            foreach($address as $data){
                foreach($data['types'] as $key => $val){
                    if($val == 'country'){
                        $country = Country::where('iso', $data['short_name'])->first();
                        if($country){
                            $userData = User::where('id', Auth::user()->id)->first();
                            $userData->country_id = $country->id;
                            $userData->save();
                        }
                    }
                } 
            }
        }
        
        $venue->save();

        if(Auth::user()->user_type == 0){
            return redirect('venue/edit/'.$id)->with('status', 'Venue Profile updated!');
        }else{
            return redirect('venue')->with('status', 'Venue Profile updated!');
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

    public function editData(Request $request, $id){
        $input = $request->all();

        $user = Venue::where('user_id', $id)->first();
        $user->venue_hashtag = $input['venue_hashtag'];
        $user->venue_facebook = $input['venue_facebook'];
        $user->venue_instagram = $input['venue_instagram'];
        $user->venue_twitter = $input['venue_twitter'];
        $user->venue_whatsapp = $input['venue_whatsapp'];
        $user->save();

        if(Auth::user()->user_type == 0){
            return redirect('venue/edit/'.$id)->with('status', 'Venue Profile updated!');
        }else{
            return redirect('venue')->with('status', 'Venue Profile updated!');
        }
    }

    public function editBank(Request $request, $id){
        $input = $request->all();

        $user = Venue::where('user_id', $id)->first();
        $user->bank_name = $input['bank_name'];
        $user->bank_account_holder_name = $input['bank_account_holder_name'];
        $user->bank_iban = $input['bank_iban'];
        $user->bank_account_number = $input['bank_account_number'];
        $user->bank_sort_code = $input['bank_sort_code'];
        $user->bank_swift_code = $input['bank_swift_code'];
        $user->bank_notes = $input['bank_notes'];
        $user->save();

        if(Auth::user()->user_type == 0){
            return redirect('venue/edit/'.$id)->with('status', 'Venue Profile updated!');
        }else{
            return redirect('venue')->with('status', 'Venue Profile updated!');
        }
    }

    public function editOption(Request $request){
        $input = $request->all();

        $user = Venue::where('user_id', $id)->first();
        $user->default_tax_rate = $input['default_tax_rate'];
        $user->save();

        if(Auth::user()->user_type == 0){
            return redirect('venue/edit/'.$id)->with('status', 'Venue Profile updated!');
        }else{
            return redirect('venue')->with('status', 'Venue Profile updated!');
        }
    }

    public function removeVenue($id){
        if(Auth::user()->user_type == 0){
            $user = User::where('id', $id)->update(['is_active' => 0]);
            return redirect('admin-venue')->with('status', 'Venue Profile updated!');
        }
        
        return 'success';
    }

    public function reactivateVenue($id){
        if(Auth::user()->user_type == 0){
            $user = User::where('id', $id)->update(['is_active' => 1]);
            return redirect('admin-venue')->with('status', 'Venue Profile updated!');
        }
        
        return 'success';
    }    

    public function getTaxRates(){
        $rates = TaxRates::all();
        return $rates;
    }
}
