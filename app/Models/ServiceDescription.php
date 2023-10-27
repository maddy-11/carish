<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceDescription extends Model
{
    protected $fillable    = ['language_id', 'service_id', 'description'];
    protected $table       = "service_descriptions";
}
