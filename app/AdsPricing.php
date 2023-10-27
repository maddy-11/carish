<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdsPricing extends Model
{
    protected $table = "ads_pricing";

    protected $fillable = [
        'number_of_days',
        'pricing'
    ];
}
