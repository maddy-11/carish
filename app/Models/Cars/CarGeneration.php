<?php

namespace App;

namespace App\Models\Cars;

use Illuminate\Database\Eloquent\Model;


class CarGeneration extends Model
{
    protected $fillable = ['id_car_generation', 'id_car_model', 'name','year_begin','year_end','date_create','date_update','id_car_type'];
    protected $table    = "car_generation";
}
