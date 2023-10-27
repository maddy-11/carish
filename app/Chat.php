<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    //

    public function customerMessages(){
        return $this->hasMany('App\CustomerMessages');
    }
}
