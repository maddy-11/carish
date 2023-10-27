<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EngineType extends Model
{
    protected $table       = 'engine_types';
    protected $fillable    = ['api_code'];

    public function engine_type_description(){
    	return $this->hasMany('App\Models\EngineTypeDescription','engine_type_id','id');
    }
}
