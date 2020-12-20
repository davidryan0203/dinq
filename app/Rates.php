<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Rates extends Model {

    protected $table = 'exchange_rates';

    public function getExchangeRatesAttribute($value){
        return json_decode($value);
    }

    public function getConversionRatesAttribute($value){
        return json_decode($value);
    }
}
