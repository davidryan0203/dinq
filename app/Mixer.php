<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Mixer extends Model {

    protected $table = 'menu_mixer_details';

    public function venue()
    {
  		return $this->belongsTo('App\Venue', 'venue_id','id');
  	}
}
