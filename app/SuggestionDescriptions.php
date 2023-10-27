<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SuggestionDescriptions extends Model
{
    protected $table = "suggesstion_descriptions";
    protected $fillable = ['suggesstion_id','title','sentence','language_id'];

     public function suggestion()
    {
        return $this->belongsTo('App\Suggesstion','suggesstion_id','id');
    }
}
