<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MyAlert extends Model
{
    public $timestamps  = true;
    public function get_model(){
    	return $this->belongsTo('App\Models\Cars\Carmodel','car_model','id');
    }

    public function get_city(){
    	return $this->belongsTo('App\City','city','id');
    }
}
