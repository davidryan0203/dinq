<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Feeds extends Model {

    protected $table = 'feeds';

    public function user()
    {
  		return $this->belongsTo('App\User','author_id','id');
  	}

  	public function venue()
    {
  		return $this->belongsTo('App\Venue', 'venue_id', 'id');
  	}

  	public function receiver()
    {
  		return $this->belongsTo('App\User', 'receiver_id', 'id');
  	}

  	public function author()
    {
  		return $this->belongsTo('App\User', 'author_id', 'id');
  	}

    public function sender()
    {
      return $this->belongsTo('App\User', 'sender_id', 'id');
    }

    public function comments()
    {
      return $this->hasMany('App\Comments', 'feed_id', 'id');
    }

    public function venue_info()
    {
      return $this->belongsTo('App\User', 'venue_id', 'id');
    }
}
