<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class MenuCategory extends Model {

    protected $table = 'menu_category';

    public function venue()
    {
        return $this->belongsTo('App\Venue','venue_id');
    }
}
