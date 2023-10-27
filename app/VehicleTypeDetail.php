<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleTypeDetail extends Model
{
    public function vehicle_type()
    {
        return $this->belongsTo('App\VehicleType','vehicle_type_id','id');
    }
}
