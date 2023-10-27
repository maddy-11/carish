<?php

namespace App\Models\Customers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class CustomerBillingDetail extends Model
{
    protected $table = 'customer_billing_details';
    /**
     * The attributes that are mass assignable.
     * 
     * @var array
     */
    public    $timestamps = true;
    protected $fillable = [
        'billing_id','customer_payment_id','customer_card_id','card_last_4','card_type','customer_payment_gateway'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    public function billing(){
        return $this->belongsTo('App\Models\Customers\CustomerBillingAddress');
    }
 


 
}

