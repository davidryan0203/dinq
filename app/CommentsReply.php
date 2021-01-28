<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class CommentsReply extends Model {

    protected $table = 'comments_reply';

    public function comment()
    {
  		return $this->belongsTo('App\Comments', 'comment_id', 'id');
  	}

  	public function feed()
    {
  		return $this->belongsTo('App\Feeds', 'feed_id', 'id');
  	}
}
