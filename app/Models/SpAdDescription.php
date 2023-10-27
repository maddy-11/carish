<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpAdDescription extends Model
{
    protected $fillable    = ['language_id', 'spare_part_ad_id', 'description'];
    protected $table       = "spareparts_ad_descriptions";
}
