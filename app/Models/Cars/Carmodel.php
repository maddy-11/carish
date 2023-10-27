<?php

namespace App\Models\Cars;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cars\Version;

class Carmodel extends Model
{
    public $timestamps  = true;
    protected $fillable = ['name', 'make_id', 'sort_order'];
    protected $table    = "models";
    public function make()
    {
        return $this->belongsTo('App\Models\Cars\Make');
    }
    public function versions()
    {
        return $this->hasMany('App\Models\Cars\Version');
    }

    public function ads(){
        return $this->hasMany('App\Ad');
    }

    public function sparepart_ads(){
        return $this->hasMany('App\SparePartAd');
    }

    public function getVersionCount($id)
    {
        $models_count = Version::where('model_id' , $id)->count();
        return $models_count;
    }


}
