<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdsStatusHistory extends Model
{
    protected $table = 'ads_status_histories';

    public function ads_status($status)
    {
    	if($status == 0)
    	{
    		return 'Pending';
    	}
    	else if($status == 1)
    	{
    		return 'Active';
    	}
    	else if($status == 2)
    	{
    		return 'Removed';
    	}
    	else if($status == 3)
    	{
    		return 'Not Approved';
    	}
    	else if($status == 5)
    	{
    		return 'Unpaid';
    	}
    }

    public function get_user(){
        return $this->belongsTo('App\Models\Customers\Customer', 'user_id', 'id');
    }

    public function get_staff(){
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
