<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suggesstion extends Model
{
     public function ads()
    {
        return $this->belongsToMany('App\Ad');
    } 
    public function suggesstion_descriptions()
    {
        return $this->hasMany('App\SuggestionDescriptions', 'suggesstion_id', 'id');
    }

}
