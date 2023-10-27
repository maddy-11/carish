<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    

    public function parent()
		{
		    return $this->belongsTo(self::class, 'parent_id');
		}

		
}
