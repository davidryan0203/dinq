<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactUs;
use Auth;
use App\User;
use App\Rates;
use App\Orders;
use App\Feeds;
use App\Country;
use App\Currency;
use App\Activities;
use Carbon\Carbon;

class HomeController extends Controller
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
        return view('home');
    }

    public function waiter()
    {
        return view('waiter');
    }

    public function customers()
    {
        return view('customers');
    }

    public function activities()
    {
        return view('admin.activities');
    }

    public function getActivities(){
        $activities = Activities::with('sender','receiver')->get();
        return $activities;
        dd($activities);
    }

    public function testEmail(){
        // $to_name = 'Ryan David';
        // $to_email = 'davdiryan0203@gmail.com';
        // $data = array('name'=> "Ryan David", "body" => "A test mail");
        // Mail::send('emails.mail', $data, function($message) use ($to_name, $to_email) {
        // $message->to($to_email, $to_name)
        // ->subject('Laravel Test Mail');
        // $message->from('davidryan0203@gmail.com','Test Mail');
        // });
        $data = array('name'=> "Ryan David", "body" => "A test mail");
        Mail::to('davidryan0203@gmail.com')->send(new ContactUs($data));
    }

    public function getUserDetails(){
        if(Auth::user()->user_type == 1){
            return User::with('venue','venue.tax_rate','venue.currency')->where('id',Auth::user()->id)->first();
        }elseif(Auth::user()->user_type == 2){
            return User::with('supplier','supplier.tax_rate','supplier.currency')->where('id',Auth::user()->id)->first();
        }else{
            return User::with('venue','venue.tax_rate','venue.currency')->where('id',Auth::user()->id)->first();
        }
    }

    public function getCustomers(){
        if(Auth::user()->user_type == 2){
            $from = \Carbon\Carbon::now()->subDays(30);
            $to = \Carbon\Carbon::now()->addDay(1);
            $checkins = Feeds::with('venue.user.country')->where('feed_type', 'checkin')->whereBetween('created_at', [$from, $to])->get();

            $countryID = [];
            foreach ($checkins as $key => $data) {
                $countryID[] = $data['venue']['user']['country']['iso'];            }

            $countryIDResults = collect($countryID)->unique()->toArray();            

            $countriesArray = explode(',', Auth::user()->supplier->available_countries);
            $array = implode("','",array_merge($countriesArray,$countryIDResults));
            //dd($array);
            $countryIds = Country::whereIn('iso', array_merge($countriesArray,$countryIDResults))->get()->pluck('id');
            //dd($countryIds);
            $users = User::with('country')->where(['user_type' => 3, 'is_active' => 1])->whereIn('country_id', $countryIds)->get();
            //dd($users);
        }else{
            $users = User::with('country','receiver_activity','sender_activity')->where(['user_type' => 3])->get();
            //dd($users);
        }
        return collect($users)->isNotEmpty() ? $users : [];
    }

    public function getExchangeRates(){
        $rates = Rates::first();
        return $rates;
    }

    public function getRevenue(){
        if(Auth::user()->user_type == 0){
            $revenues = [];
            $orders = Orders::select('venue_total','order_total')->where('is_paid', 1)->get();

            foreach ($orders as $key => $data) {
                
                $revenues[] = ($data['order_total'] - $data['venue_total']);
            }
            //dd($revenues);
            $revenue = array_sum($revenues);
        }
        
        if(Auth::user()->user_type == 1){            
            $revenue = Orders::where('venue_id', '=', Auth::user()->venue->id)->where('is_paid', 1)->pluck('venue_total')->sum();
        }

        if(Auth::user()->user_type == 2){            
            $revenue = Orders::where('supplier_id', '=', Auth::user()->supplier->id)->pluck('venue_total')->sum();
        }

        if(Auth::user()->user_type == 2){
            $currencyCode = Currency::where('id', Auth::user()->supplier['default_currency'])->first();
        }else{
            $currencyCode = Currency::where('id', Auth::user()->venue['default_currency'])->first();
        }

        return $currencyCode['symbol_left'].number_format($revenue,2).$currencyCode['symbol_right'];
    }
    public function getRedeemed(){
        $redeemed = 0;
        if(Auth::user()->user_type == 0){
            $redeemed = Orders::where('order_status','=','redeemed')->count();
        }

        if(Auth::user()->user_type == 1){            
            $redeemed = Orders::where(['venue_id' => Auth::user()->venue->id, 'order_status' => 'redeemed'])->count();
        }

        if(Auth::user()->user_type == 2){            
            $redeemed = Orders::where(['supplier_id' => Auth::user()->supplier->id, 'order_status' => 'redeemed'])->count();
        }
        return $redeemed;
    }

    public function getPaidRedeemed(){
        if(Auth::user()->user_type == 0){
            $revenue = Orders::all()->pluck('order_total')->sum();
        }

        if(Auth::user()->user_type == 1){            
            $revenue = Orders::where('venue_id', '=', Auth::user()->venue->id)->pluck('venue_total')->sum();
        }

        if(Auth::user()->user_type == 2){            
            $revenue = Orders::where('supplier_id', '=', Auth::user()->supplier->id)->pluck('venue_total')->sum();
        }

        if(Auth::user()->user_type == 2){
            $currencyCode = Currency::where('id', Auth::user()->supplier['default_currency'])->first();
        }else{
            $currencyCode = Currency::where('id', Auth::user()->venue['default_currency'])->first();
        }

        return $currencyCode['symbol_left'].number_format($revenue,2).$currencyCode['symbol_right'];
    }
    
    public function getPendingOrders(){
        if(Auth::user()->user_type == 0){
            $pending = Orders::where('order_status','=','pending')->count();
        }

        if(Auth::user()->user_type == 1){            
            $pending = Orders::where(['venue_id' => Auth::user()->venue->id, 'order_status' => 'pending'])->count();
        }

        if(Auth::user()->user_type == 2){            
            $pending = Orders::where(['supplier_id' => Auth::user()->supplier->id, 'order_status' => 'pending'])->count();
        }
        return $pending;
    }
    public function getTodaysCheckins(){       
        if(Auth::user()->user_type == 0){
            $feeds = Feeds::where('feed_type', '=', 'checkin')->count();
        }

        if(Auth::user()->user_type == 1){            
            $feeds = Feeds::where(['venue_id' => Auth::user()->venue->id, 'feed_type' => 'checkin'])->count();
        }

        if(Auth::user()->user_type == 2){            
            $feeds = 0;
        }
        return $feeds;
    }

    public function getCountries(){
        $countries = Country::all();
        return $countries;
    }

    public function deactivateCustomer(Request $request){
        $input = $request->all();
        //dd($input);
        $user = User::where('id',$input['id'])->update(['is_active' => 0]);

        return 'delete success.';
    }

    public function reactivateCustomer(Request $request){
        $input = $request->all();
        //dd($input);
        $user = User::where('id',$input['id'])->update(['is_active' => 1]);

        return 'success.';
    }
}
