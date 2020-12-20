<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Supplier extends Model {

    protected $table = 'supplier_info';

    public function user()
    {
	  	return $this->belongsTo('App\User', 'user_id', 'id');
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
