<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Influencers extends Model {

    protected $table = 'influencers';

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id','id');
    }

    public function owner()
    {
        return $this->belongsTo('App\User', 'owner_id','id');
    }

    public function influencer_coupon()
    {
        return $this->belongsTo('App\InfluencerCoupons', 'influencer_coupon_id','id');
    }
}
