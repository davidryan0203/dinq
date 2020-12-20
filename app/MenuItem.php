<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class MenuItem extends Model {

    protected $table = 'menu_items';

    public function getMenuCategoriesAttribute($value){
        return json_decode($value);
    }

    public function getAccessRolesAttribute($value){
        return json_decode($value);
    }

    public function getMixersAttribute($value){
        return json_decode($value);
    }

    public function taxRate()
    {
        return $this->belongsTo('App\TaxRates', 'tax_rate_id','id');
    }

    public function venue()
    {
        return $this->belongsTo('App\Venue', 'venue_id','id');
    }
}
