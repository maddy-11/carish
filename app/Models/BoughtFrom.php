<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoughtFrom extends Model
{
    public    $timestamps  = true;
    protected $fillable = ['slug', 'code', 'status'];
    protected $table    = "bought_from";


    public function boughtFromDescription()
    {
        return $this->hasMany('App\Models\BoughtFromDescription','bought_from_id','id');
    }
}
