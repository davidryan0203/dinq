<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class MenuItem extends Model {

    protected $table = 'menu_items';

    public function getMenuCategoriesAttribute($value){
        return json_decode($value);
    }

    public function getAccessRolesAttribute($value){
        return json_decode($value);
    }

    public function getMixersAttribute($value){
        return json_decode($value);
    }
}
