<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reason extends Model
{
    protected $table    = "reasons";

    public function reason_description()
    {
        // return $this->belongsTo('App\ReasonsDescription','reason_id','id');
        return $this->hasMany('App\ReasonsDescription', 'reason_id', 'id');
    }

    public function ad_msg()
    {
        return $this->hasMany('App\AdMsg', 'reason_id', 'id');
    }

    public function sp_ad_msg()
    {
        return $this->hasMany('App\SparepartsAdsMessage', 'reason_id', 'id');
    }

    public function services_msg()
    {
        return $this->hasMany('App\ServiceMessage', 'reason_id', 'id');
    }
}
