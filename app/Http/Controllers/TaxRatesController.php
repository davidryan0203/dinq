<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\TaxRates;
use App\User;
use App\Orders;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;   

class TaxRatesController extends Controller
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
    public function taxRates()
    {
        return view('tax-rates');
    }

    public function getTaxRates(){
        $taxRates = TaxRates::all();
        return $taxRates;
    }

    public function saveTaxRate(Request $request){
        $input = $request->all();
        if($input['id']){
            $taxRate = TaxRates::where('id',$input['id'])->first();
        }else{
            $taxRate = new TaxRates;
        }
        $taxRate->name = $input['name'];
        $taxRate->rate = $input['rate'];
        $taxRate->save();

        return 'success';
    }

    public function removeTaxRate(Request $request){
        $input = $request->all();
        $taxRate = TaxRates::where('id',$input['id'])->update(['is_active' => 0]);
        return 'success';
    }
}
