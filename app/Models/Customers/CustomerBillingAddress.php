<?php

namespace App\Models\Customers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class CustomerBillingAddress extends Model
{
    protected $table = 'customer_billing_address';
    /**
     * The attributes that are mass assignable.
     * 
     * @var array
     */
    public    $timestamps = true;
    protected $fillable = [
        'customer_id','state_id','country_id','billing_first_name','billing_last_name', 'billing_city', 'billing_zipcode','billing_email', 'billing_address', 'billing_address_2','billing_company'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    public function customer(){
        return $this->belongsTo('App\Models\Customers\Customer');
    }

    public function country(){
        return $this->belongsTo('App\Models\Country');
    }

     public function state(){
        return $this->belongsTo('App\Models\State');
    }

    public function billing_detail(){
        return $this->hasOne('App\Models\Customers\CustomerBillingDetail', 'billing_id');
    }
 


 
}

