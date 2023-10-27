<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{
    public function descriptions()
    {
        return $this->hasMany('App\VehicleTypeDetail', 'vehicle_type_id', 'id');
    }
}
