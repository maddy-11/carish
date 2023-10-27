<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public    $timestamps  = true;
    protected $fillable    = ['make_id','model_id',
                              'average_fuel', 'mileage_total','mileage_per_year', 'suggesstion_id'];
    public function tagsDescription()
    {
        return $this->hasMany('App\Models\TagDescription', 'tag_id', 'id');
    }

    public function maker()
    {
        return $this->belongsTo('App\Models\Cars\Make', 'make_id', 'id');
    }

    public function model()
    {
        return $this->belongsTo('App\Models\Cars\Carmodel', 'model_id', 'id');
    }

    public function suggessions(){
        return $this->belongsTo('App\Suggesstion','suggesstion_id','id');
     }

}
