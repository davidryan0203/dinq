<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Activities extends Model {

    protected $table = 'activities';

    public function receiver()
    {
  		return $this->belongsTo('App\User', 'receiver_id', 'id');
  	}

  	public function sender()
    {
      return $this->belongsTo('App\User', 'sender_id', 'id');
    }
}
