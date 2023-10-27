<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public    $timestamps  = true;
    protected $fillable = ['name', 'slug', 'code'];
    protected $table    = "countries";
}