<?php

namespace App\Models\Cars;

use Illuminate\Database\Eloquent\Model;

class Version extends Model
{
    public    $timestamps  = true;
    protected $fillable    = ['model_id', 'label', 'extra_details', 'from_date', 'to_date', 'cc', 'body_type_id',
        'kilowatt','sort_order'];

    public function models()
    {
        return $this->belongsTo('App\Models\Cars\Carmodel','model_id','id');
    } 

    public function bodyTypes()
    {
        return $this->belongsTo('App\Models\Cars\BodyTypes','body_type_id','id');
    }

    public function body_type_description(){
        return $this->belongsTo('App\BodyTypesDescription','body_type_id','body_type_id');
    }

    public function ads(){
        return $this->hasMany('App\Ad');
    }
    public function CarSerie()
    {
        return $this->belongsTo('App\Models\Cars\CarSerie','id_car_serie','id_car_serie');
    }
    public function CarGeneration()
    {
        return $this->belongsTo('App\Models\Cars\CarGeneration','id_car_generation','id_car_generation');
    }
    public function transmission(){
        return $this->belongsTo('App\Models\Transmission','transmissiontype','id');
    }
    public function transmissionDescription()
    {
        return $this->belongsTo('App\Models\TransmissionDescription', 'transmissiontype', 'transmission_id');
    }
    
}
