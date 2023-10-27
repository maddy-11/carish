<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSavedAds extends Model
{
    public function ads()
    {
    	return $this->belongsTo('App\Ad','ad_id','id');
    }
}