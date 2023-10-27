<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SparepartsAdsDescription extends Model
{
    public    $timestamps  = true;
    protected $fillable    = ['language_id', 'spare_part_ad_id', 'description'];
    protected $table       = "spareparts_ad_descriptions";
}
