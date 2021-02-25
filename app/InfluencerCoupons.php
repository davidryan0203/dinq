<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class InfluencerCoupons extends Model {

    protected $table = 'influencer_coupons';

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id','id');
    }
}
