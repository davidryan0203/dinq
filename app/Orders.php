<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Orders extends Model {

    protected $table = 'orders';

    public function receiver()
    {
        return $this->belongsTo('App\User', 'recepient_id', 'id');
    }

    public function sender()
    {
        return $this->belongsTo('App\User', 'sender_id', 'id');
    }

    public function menu_item(){
    	return $this->belongsTo('App\MenuItem', 'menu_id', 'id');
    }

    public function venue(){
    	return $this->belongsTo('App\Venue', 'venue_id', 'id');
    }

    public function getMenuItemsAttribute($value){
        return json_decode($value);
    }
}
