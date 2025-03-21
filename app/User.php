<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use Notifiable,Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username', 'password','civil_status','is_active','user_type','address','contact_number','longitude','latitude','description','venue_type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function venues()
    {
        return $this->hasMany('App\Venue', 'user_id');
    }

    public function venue()
    {
        return $this->belongsTo('App\Venue', 'id','user_id');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Supplier', 'id','user_id');
    }

    public function country()
    {
        return $this->belongsTo('App\Country');
    }

    public function receiver_activity()
    {
        return $this->hasMany('App\Activities', 'receiver_id');
    }

    public function sender_activity()
    {
      return $this->hasMany('App\Activities', 'sender_id');
    }
}
