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
        $orders = Orders::all();
        return $orders;
    }
}
