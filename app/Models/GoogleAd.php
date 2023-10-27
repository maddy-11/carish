<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoogleAd extends Model
{
    protected $table = 'google_ads';

    public function ad_page(){
        return $this->belongsTo('App\Models\AdsPage','page_id','slug');
    }
}
