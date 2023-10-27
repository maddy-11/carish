<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SparePartAdTitle extends Model
{
    protected $fillable    = ['language_id', 'spare_part_ad_id', 'title'];
    protected $table = 'spare_part_ads_titles';
}
