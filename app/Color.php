<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $fillable    = ['name','api_code','status'];
    public    $timestamps  = true;
    protected $table       = "colors";
    public function color_description(){
        return $this->hasMany('App\ColorsDescription','color_id','id');
    }
}
