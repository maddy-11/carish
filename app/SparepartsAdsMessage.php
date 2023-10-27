<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SparepartsAdsMessage extends Model
{
    protected $table       = "spare_parts_ads_messages";

    public function reason()
    {
      return $this->belongsTo(Reason::class); // abc
    }
}
