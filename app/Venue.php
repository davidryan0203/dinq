<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Venue extends Model {

    protected $table = 'venue_info';

    protected $fillable = ['description','address','longitude','latitude','description','user_id','contact_number','venue_type'];

    public function user()
    {
  		return $this->belongsTo('App\User');
  	}

  	public function tax_rate()
    {
  		return $this->belongsTo('App\TaxRates', 'default_tax_rate','id');
  	}

  	public function currency()
    {
  		return $this->belongsTo('App\Currency', 'default_currency','id');
  	}
}
