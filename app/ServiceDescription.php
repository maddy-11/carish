<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceDescription extends Model
{
    public    $timestamps  = true;
    protected $fillable    = ['language_id', 'service_id', 'description'];
    protected $table       = "service_descriptions";
}
