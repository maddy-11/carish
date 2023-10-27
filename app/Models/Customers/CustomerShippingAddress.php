<?php

namespace App\Models\Customers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class CustomerShippingAddress extends Model
{
    protected $table = 'customer_shippings';
    /**
     * The attributes that are mass assignable.
     * 
     * @var array
     */
    public    $timestamps = true;
    protected $fillable = [
        'customer_id','state_id','country_id','shipping_first_name','shipping_last_name', 'shipping_city','shipping_email', 'shipping_address_1', 'shipping_address_2','shipping_postcode','shipping_company'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    public function customer(){
        return $this->belongsTo('App\Models\Customers\Customer');
    }
 


 
}

