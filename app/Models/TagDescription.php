<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TagDescription extends Model
{
    public    $timestamps  = true;
    protected $fillable    = ['language_id', 'tag_id', 'name','code'];
    protected $table       = "tag_description";
    
}
