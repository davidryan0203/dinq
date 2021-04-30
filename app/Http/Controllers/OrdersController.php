<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Venue;
use App\User;
use App\Orders;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;   
use Carbon\Carbon;

class OrdersController extends Controller
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
        return view('orders.index');
    }

    public function payouts()
    {
        return view('orders.payouts');
    }

    public function getOrders(){
        $orders = [];
        if(Auth::user()->user_type == 0){
            $orders = Orders::with('receiver','sender','menu_item')->get();
            return $orders;
        }else{
            if(Auth::user()->user_type == 1){
                $orders = Orders::with('receiver','sender','menu_item','venue')->where('venue_id' , Auth::user()->venue->id)->get();
            }

            if(Auth::user()->user_type == 2){
                $orders = Orders::with('receiver','sender','menu_item','venue')->where('supplier_id' , Auth::user()->supplier->id)->get();
            }
            return $orders;
        }
    }

    public function getPaidOrders(){
        $orders = [];
        if(Auth::user()->user_type == 0){
            $orders = Orders::with('receiver','sender','menu_item')->where('order_status', 'redeemed')->get();
            return $orders;
        }else{
            if(Auth::user()->user_type == 1){
                $orders = Orders::with('receiver','sender','menu_item','venue')->where('order_status', 'redeemed')->where('venue_id' , Auth::user()->venue->id)->get();
            }

            if(Auth::user()->user_type == 2){
                $orders = Orders::with('receiver','sender','menu_item','venue')->where('order_status', 'redeemed')->where('supplier_id' , Auth::user()->supplier->id)->get();
            }
            return $orders;
        }
    }

    public function processPayOrder(Request $request){
        $input = $request->all();
        $order = Orders::where('id',$input['id'])->update(['is_paid' => 1]);
        return 'success';
    }

    public function processPayOrderMultiple(Request $request){
        $input = $request->all();
        foreach ($input['selected'] as $key => $data) {
            $order = Orders::where('id',$data)->update(['is_paid' => 1]);
        }
        return 'success';
    }

    public function redeemCoupon(Request $request){
        $input = $request->all();

        $order = Orders::where('coupon_code',$input['coupon_code'])->first();
        if($order){
            if($order->order_status == 'pending'){
                $order->order_status = 'redeemed';
                $order->save();
                return 'success';
            }else{
                return 'order has already been redeemed.';
            }
        }else{
            return 'coupon not found.';
        }
    }

    public function filter(Request $request){
        $input = $request->all();
        //dd($input);
        $records = [];
        if($input['name'] != ''){
            $userRecords = User::where(['user_type' => 3])->where('name','like','%' . $input['name'] . '%')->get();

            foreach ($userRecords as $key => $data) {
                $data['date_of_birth'] = Carbon::parse($data['date_of_birth'])->age;
                $recordsResults[] = $data; 
            }
            $records = collect($recordsResults)->values()->toArray();
        }
        if($input['gender'] != ''){
            if($input['gender'] == 'Male'){
                $userRecords = User::where(['user_type' => 3])->where('gender','=','Male')->get();
            }

            if($input['gender'] == 'Female'){
                $userRecords = User::where(['user_type' => 3])->where('gender','=','female')->get();
            }

            if($input['gender'] == 'Others'){
                $userRecords = User::where(['user_type' => 3])->where('gender','=','Others')->get();
            }


            foreach ($userRecords as $key => $data) {
                $data['date_of_birth'] = Carbon::parse($data['date_of_birth'])->age;
                $recordsResults[] = $data; 
            }
            
            $records = collect($recordsResults)->values()->toArray();
        }

        if($input['ageFrom'] != 0){
            $recordsResults = [];
            $userRecords = User::where(['user_type' => 3])->get();
            foreach ($userRecords as $key => $data) {
                $data['date_of_birth'] = Carbon::parse($data['date_of_birth'])->age;
                $recordsResults[] = $data; 
            }
            $records = collect($recordsResults)->whereBetween('date_of_birth', [$input['ageFrom'],$input['ageTo']])->sortBy('date_of_birth')->values()->toArray();
        }
        return $records;
    }
}
