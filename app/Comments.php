<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Comments extends Model {

    protected $table = 'feed_comments';

    public function user()
    {
  		return $this->belongsTo('App\User', 'user_id', 'id');
  	}

  	public function replies()
    {
      return $this->hasMany('App\CommentsReply', 'comment_id', 'id');
    }
}
