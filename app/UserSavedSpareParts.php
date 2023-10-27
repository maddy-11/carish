<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSavedSpareParts extends Model
{
    public function sparePartAds()
    {
    	return $this->belongsTo('App\SparePartAd','spare_part_ad_id','id');
    }
}
