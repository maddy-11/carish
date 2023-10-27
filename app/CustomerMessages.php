<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerMessages extends Model
{
    public function sender()
    {
    	return $this->belongsTo('App\Models\Customers\Customer','from_id');
    }

    public function receiver()
    {
    	return $this->belongsTo('App\Models\Customers\Customer','to_id');
    }

    public function chat(){
        return $this->belongsTo('App\Chat');

    }
}
