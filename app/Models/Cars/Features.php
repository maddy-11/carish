<?php

namespace App\Models\Cars;

use Illuminate\Database\Eloquent\Model;

class Features extends Model
{
    
    public function features()
    {
        return $this->belongsToMany('App\Models\Ad');
    }

    public function features_description(){
        return $this->hasMany('App\Models\FeaturesDescription','feature_id','id');
    }
}
