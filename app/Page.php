<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = "pages";

    public function page_description()
    {
        // return $this->belongsTo('App\ReasonsDescription','reason_id','id');
        return $this->hasMany('App\PageDescription', 'page_id', 'id');
    }
}
