<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdMsg extends Model
{
   protected $table = "ads_messages";

   public function reason()
   {
      return $this->belongsTo(Reason::class); // abc
   }
    
}
