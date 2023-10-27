<?php

namespace App\Models\Customers;

use Illuminate\Database\Eloquent\Model;

class SubService extends Model
{
     protected $table = 'sub_services';
    
    public function primary_services()
    {
    	return $this->belongsTo('App\Models\Customers\PrimaryService','primary_service_id','id');
    }

    public function get_category_title(){
        return $this->hasMany('App\Models\SubServicesDescription', 'sub_service_id', 'id');
    }

    public function get_parent_title(){
        return $this->hasMany('App\Models\SubServicesDescription', 'parent_id', 'id');
    }
}
