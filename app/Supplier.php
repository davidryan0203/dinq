<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Supplier extends Model {

    protected $table = 'supplier_info';

    public function user()
    {
  	return $this->belongsTo('App\User');
  }
}
