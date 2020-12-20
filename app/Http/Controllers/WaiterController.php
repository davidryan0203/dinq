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
        $waiters = Waiter::where('venue_id', Auth::user()->id)->get();
        return $waiters;
    }

    public function waiterUpload(Request $request){
        $user = Auth::user();
    }

    public function saveWaiterData(Request $request){
        $input = $request->all();        

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

        $waiter->venue_id = Auth::user()->id;
        $waiter->created_by = Auth::user()->id;
        $waiter->name = $input['name'];
        $waiter->email = $input['email'];
        $waiter->email = $input['email'];
        $waiter->username = $input['username'];
        if(!isset($input['id']) && empty($input['id'])){
            $waiter->password = Hash::make($input['password']);
        }
        $contains = Str::contains($input['img_url'], 'images');
        if($contains == false){
 
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
