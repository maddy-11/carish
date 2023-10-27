<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BodyTypesDescription extends Model
{
    protected $table = 'body_types_description';
    public    $timestamps  = true;
    protected $fillable = ['name', 'body_type_id', 'language_id'];
}
