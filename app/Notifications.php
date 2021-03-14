<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Notifications extends Model {

    protected $table = 'notifications';

    public function user(){
    	return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function sender(){
    	return $this->belongsTo('App\User', 'sender_id', 'id');
    }

    public function receiver(){
    	return $this->belongsTo('App\User', 'receiver_id', 'id');
    }

    public function venue(){
    	return $this->belongsTo('App\Venue', 'venue_id', 'id');
    }
}
