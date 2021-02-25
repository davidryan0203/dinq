<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Friends extends Model {

    protected $table = 'friends';

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id','id');
    }

    public function friend()
    {
        return $this->belongsTo('App\User', 'friend_id','id');
    }
}
