<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Waiter;
use App\User;
use App\Orders;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;  
use Illuminate\Support\Str; 
use Carbon\Carbon;

class WaiterController extends Controller
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
    public function getWaiter()
    {
        //$waiters = Waiter::where('venue_id', Auth::user()->id)->get();
        //$waiters = Waiter::where('venue_id', Auth::user()->venue->id)->get();
        $waiters = Waiter::all();
        $waitersList = [];
        foreach ($waiters as $key => $data) {
            if(in_array(Auth::user()->venue->id, json_decode($data['venue_access']))){
                $waitersList[] = $data;
            }
        }
        return $waitersList;
    }

    public function waiterUpload(Request $request){
        $user = Auth::user();
    }

    public function saveWaiterData(Request $request){
        $input = $request->all();        
        $waiter = Waiter::where('email', $input['email'])->first();
        if(collect($waiter)->isEmpty()){
            if(isset($input['id']) && $input['id']){
                $waiter = Waiter::where('id',$input['id'])->first();
                $request->validate([
                    'name' => ['required', 'string', 'max:255'],
                    'email' => 'required|email|unique:waiter,email,'.$waiter->id,
                    'username' => 'required|unique:waiter,username,'.$waiter->id,
                ]);
            }else{
                $request->validate([
                    'name' => ['required', 'string', 'max:255'],
                    'username' => ['required', 'string', 'max:255', 'unique:waiter'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:waiter'],
                    'password' => ['required', 'string', 'min:8', 'confirmed'],
                ]);
                $waiter = new Waiter;
            }
            $venueUser = User::with('venue')->where('id', Auth::user()->id)->first();
            $waiter->venue_id = $user->venue->id;
            $waiter->created_by = Auth::user()->id;
            $waiter->name = $input['name'];
            $waiter->email = $input['email'];
            $waiter->email = $input['email'];
            $waiter->username = $input['username'];
            $waiter->venue_access = json_encode(collect(Auth::user()->id)->values()->toArray());
            if(!isset($input['id']) && empty($input['id'])){
                $waiter->password = Hash::make($input['password']);
            }
            $contains = Str::contains($input['img_url'], 'images');
            if($request->hasFile('img_url')) {
     
                $img = \Image::make($input['img_url']);

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

                $path = public_path('/images/waiter/' . $img_name);
                $img->save($path);
                $waiter->img_url = ($input['img_url']) ? '/images/waiter/' . $img_name : '';
            }

            $waiter->contact_number = $input['contact_number'];
            $waiter->save();

            $user = new User;
            $user->name = $input['name'];
            $user->username = $input['username'];
            $user->email = $input['email'];
            $user->password = Hash::make($input['password']);
            $user->country_id = (isset($input['country'])) ? intval($input['country']) : null;
            $user->area_code = (isset($input['areaCode'])) ? intval($input['areaCode']) : null;
            $user->state_id = (isset($input['state'])) ? intval($input['state']) : null;
            $user->user_type = 4;
            $user->city_id = (isset($input['city'])) ? intval($input['city']) : null;
            $user->civil_status = isset($input['civil_status']) ? $input['civil_status'] : 'single';
            $user->contact_number = isset($input['mobile']) ? $input['mobile'] : null;
            $user->gender = 'Others';        
            $user->date_of_birth = Carbon::parse(Carbon::now())->format('Y-m-d');
            $user->favorites_id = isset($input['favorites']) ? ($input['favorites']) : null;


            $user->image_url = \URL::to('/').'/images/users/default.png';
      
            $user->save();
        }else{
            $venueArray = json_decode($waiter->venue_access,true);
            //dd($venueArray);
            $venues = [];
            foreach ($venueArray as $key => $data) {
                $venues[] = $data;
            }
            $waiter->venue_access = json_encode(collect($venues)->flatten()->push(Auth::user()->venue->id)->unique());
            $waiter->save();
        }

        

        return 'success';
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
