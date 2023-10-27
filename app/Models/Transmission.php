<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transmission extends Model
{
    protected $table = 'transmissions';
    protected $fillable    = ['api_code'];

    public function transmission_description(){
    	return $this->hasMany('App\Models\TransmissionDescription','transmission_id','id');
    }
}
