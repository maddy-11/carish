<?php

namespace App\Models\Customers;

use Illuminate\Database\Eloquent\Model;

class FeaturedRequest extends Model
{
     protected $table = 'featured_requests';

public function ad(){
        return $this->belongsTo('App\Ad','ad_id','id');
    }

    public function sparepart(){
        return $this->belongsTo('App\SparePartAd','ad_id','id');
    }

    public function offerservice(){
        return $this->belongsTo('App\Models\Services','ad_id','id');
    }

    public function customer(){
        return $this->belongsTo('App\Models\Customers\Customer','user_id','id');
    }

}