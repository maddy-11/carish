<?php

namespace App\Models\Cars;

use Illuminate\Database\Eloquent\Model;

class Makemodelversion extends Model
{
    protected $table    = "make_model_versions";
    public $timestamps  = true;
    protected $fillable = ['make_title', 'model_title', 'variant', 'version',
    'from_date', 'to_date','cc', 'engin_power', 'car_number'];

}
