<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccessoriesAlert extends Model
{
    public $timestamps  = true;
 
    public function get_city(){
    	return $this->belongsTo('App\City','city','id');
    }

    public function get_category(){
    	return $this->belongsTo('App\SparePartCategory','category_id','id');
    }

    public function get_sub_category(){
    	return $this->belongsTo('App\SparePartCategory','sub_category_id','id');
    }
}
