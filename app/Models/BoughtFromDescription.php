<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoughtFromDescription extends Model
{
    public    $timestamps  = true;
    protected $table    = "bought_from_description";

    public function boughtFrom()
    {
        $this->belongsTo('App\Models\BoughtFrom','bought_from_id','id');
    }
}