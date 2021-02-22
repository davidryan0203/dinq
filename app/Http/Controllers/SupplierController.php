<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Supplier;
use App\User;
use Image;
use App\Country;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;   
use App\TaxRates;

class SupplierController extends Controller
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

    public function adminSupplier()
    {
        return view('admin.supplier');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function supplier()
    {
        $info = Supplier::with('user')->where('user_id',Auth::user()->id)->first();
        return view('supplier')->with(['info' => $info]);
    }

    public function editSupplier($id){
        $info = Supplier::with('user')->where('user_id',$id)->first();
        $taxRates = TaxRates::all();
        $countries = Country::all();
        return view('supplier')->with(['info' => $info, 'taxRates' => $taxRates, 'countries' => $countries]);
    }

    public function getSupplier()
    {
        //$suppliers = Supplier::with('user')->get();
        $suppliers = User::with('supplier')->where(['user_type' => 2])->get();
        return $suppliers;
    }

    public function edit(Request $request, $id){

        $input = $request->all();
        if(Auth::user()->user_type != 0){
        	$request->validate([
                'username' => ['required', 'string', 'max:255', 'unique:users,username,'. Auth::user()->id],
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'. Auth::user()->id],
                'password' => ['confirmed'],
            ]);
        }else{
            $request->validate([
                'username' => ['required', 'string', 'max:255', 'unique:users,username,'. $id],
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'. $id],
                'password' => ['confirmed'],
            ]);
        }

    	$supplier = Supplier::where('user_id', $id)->first();

        $user = User::where('id', $id)->first();
        $user->email = $input['email'];
        $user->username = $input['username'];
        $user->name = $input['name'];
        if(!empty($input['selectedCountries'])){
            $supplier->available_countries = $input['selectedCountries'];
        }
        if(!empty($input['password'])){
            $supplier->password = Hash::make($input['password']);
        }
        $user->save();


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

            $path = public_path('/images/supplier/' . $img_name);
            $img->save($path);
            $supplier->img_url = ($input['img_url']) ? '/images/supplier/' . $img_name : '';
            $supplier->save();
        }

        $supplier->save();
        return redirect('/supplier/edit/'.$id)->with('status', 'Supplier Profile updated!');
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

    public function removeSupplier($id){
        if(Auth::user()->user_type == 0){
            $user = User::where('id', $id)->update(['is_active' => 0]);
            return redirect('admin-supplier')->with('status', 'Supplier Removed!');
        }
        
        return 'success';
    }

    public function reactivateSupplier($id){
        if(Auth::user()->user_type == 0){
            $user = User::where('id', $id)->update(['is_active' => 1]);
            return redirect('admin-supplier')->with('status', 'Supplier Removed!');
        }
        
        return 'success';
    }    
}