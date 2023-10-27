<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
	protected $fillable = ['code','product_id','date_expired','usage_limit','individual_use','discount_type','updated_at'];
    protected $table = "coupons";
}
