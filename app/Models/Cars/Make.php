<?php

namespace App\Models\Cars;

use Illuminate\Database\Eloquent\Model;

class Make extends Model
{
	protected $table = "makes";
    public $timestamps  = true;
    protected $fillable = ['title','image', 'sort_order', 'is_popular'];

    public function model()
    {
        return $this->hasMany('App\Models\Cars\Model');
    } 
    
    public function ads(){
        return $this->hasMany('App\Ad');
    }

    public function sparepart_ads(){
        return $this->hasMany('App\SparePartAd');
    }
}
