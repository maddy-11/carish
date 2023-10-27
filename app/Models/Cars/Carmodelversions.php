<?php

namespace App\Models\Cars;

use Illuminate\Database\Eloquent\Model;

class Carmodelversions extends Model
{
    protected $table    = "car_model_versions";
    public $timestamps  = true;
    protected $fillable = ['model_id', 'name', 'engin_capacity','fuel_type',
    'features','transmission_type'];

    public function model()
    {
        return $this->belongsTo('App\Models\Car\Make');
    }
    public function ads(){
        return $this->hasMany('App\Ad');
    }
}
