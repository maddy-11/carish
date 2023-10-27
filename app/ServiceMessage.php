<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceMessage extends Model
{
    protected $table   = "services_messages";

    public function reason()
   {
      return $this->belongsTo(Reason::class); // abc
   }
    
}
