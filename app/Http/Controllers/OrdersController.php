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

    public function getOrders(){
        $orders = [];
        if(Auth::user()->user_type == 0){
            $orders = Orders::with('receiver','sender','menu_item')->get();
            return $orders;
        }else{
            if(Auth::user()->user_type == 1){
                $orders = Orders::with('receiver','sender','menu_item','venue')->where('venue_id' , Auth::user()->venue->user->id)->get();
            }

            if(Auth::user()->user_type == 2){
                $orders = Orders::with('receiver','sender','menu_item','venue')->where('supplier_id' , Auth::user()->supplier->id)->get();
            }
            return $orders;
        }
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
}
