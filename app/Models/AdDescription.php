<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdDescription extends Model
{
    public    $timestamps  = true;
    protected $fillable    = ['language_id', 'ad_id', 'description'];
    protected $table       = "ad_description";
}
