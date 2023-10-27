<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PageDescription extends Model
{
    protected $table = "page_desciption";

    public function page(){
    	return $this->belongsTo('App\Page','page_id','id');
    }

    public function language()
    {
        return $this->belongsTo('App\Models\Language','language_id','id');
    }
}
