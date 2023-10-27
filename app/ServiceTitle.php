<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceTitle extends Model
{
    protected $fillable    = ['language_id', 'services_id', 'title'];
    protected $table = 'service_titles';
}
