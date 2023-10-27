<?php

namespace App;

namespace App\Models\Cars;

use Illuminate\Database\Eloquent\Model;


class BodyTypes extends Model
{
    public    $timestamps  = true;
    protected $fillable = ['name', 'name_slug', 'image'];
    protected $table    = "body_types";

     public function bodyType_description(){
        return $this->hasMany('App\BodyTypesDescription','body_type_id','id');
    }
}
