<?php

namespace App\Http\Controllers;

use Auth;
use App\Influencers;
use App\InfluencerCoupons;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Carbon\Carbon;

class InfluencersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function influencers()
    {
        return view('influencers');
    }

    public function getInfluencerCoupons(Request $request){
        $coupons = InfluencerCoupons::with('user')->get();
        return $coupons;
    }

    public function getInfluencers(Request $request){
        $coupons = Influencers::with('influencer_coupon.user','user','owner')->get();
        return $coupons;
    }

    public function createInfluencerCoupon(Request $request){
        $input = $request->all();
        $coupons = new Influencers;
        $coupons->user_id = $input['user_id'];
        $coupons->coupon = $input['coupon'];
        $coupons->save();
    }
}
