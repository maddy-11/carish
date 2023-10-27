<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdImage extends Model
{
    protected $table = "ad_images";

     protected $fillable = [
        'ad_id',
        'img'
    ];
}
