<?php

namespace App;

namespace App\Models\Cars;

use Illuminate\Database\Eloquent\Model;


class CarSerie extends Model
{
    protected $fillable = ['id_car_serie', 'id_car_model', 'id_car_generation','name','date_create','date_update','id_car_type'];
    protected $table    = "car_serie";
}
