<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceDetail extends Model
{
     public function get_primary_service()
    {
    	return $this->belongsTo('App\Models\Customers\PrimaryService','primary_service_id','id');
    }

     public function get_category()
    {
    	return $this->belongsTo('App\Models\Customers\SubService','category_id','id');
    }

    public function get_sub_category()
    {
    	return $this->belongsTo('App\Models\Customers\SubService','sub_category_id','id');
    }
}
