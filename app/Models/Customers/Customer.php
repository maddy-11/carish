<?php
namespace App\Models\Customers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\CustomerResetPasswordNotification;

class Customer extends Authenticatable
{
    use Notifiable;
    protected $guard = 'customer';
    /**
     * The attributes that are mass assignable.
     * 
     * @var array
     */
    protected $fillable = [
        'customer_firstname','customer_lastname', 'customer_company', 'customer_vat','customer_registeration','customer_default_address', 'customers_telephone','customer_email_address', 'customer_password','customer_role','citiy_id','language_id','is_adminverify'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['customer_password', 'remember_token'];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomerResetPasswordNotification($token));
    }

    public function getEmailForPasswordReset()
    {
        return $this->customer_email_address;
    }

    public function language()
    {
        return $this->belongsTo('App\Models\Language','language_id','id');
    }

    public function city()
    {
        return $this->belongsTo('App\City','citiy_id','id');
    }

    public function getAuthPassword()
    {
        return $this->customer_password;
    }

    public function billingInfo()
    {
        return $this->hasOne('App\Models\Customers\CustomerBillingAddress','customer_id');
    }

    public function shippingInfo()
    {
        return $this->hasOne('App\Models\Customers\CustomerShippingAddress','customer_id');
    }

     public function get_car_ads(){
        return $this->hasMany('App\Ad', 'customer_id', 'id');
    }

    public function timings(){
        return $this->hasMany('App\Models\CustomerTiming', 'customer_id', 'id');
    }
    public function customer_account(){
       
        return $this->hasMany('App\Models\Customers\CustomerAccount', 'customer_id', 'id');
    }
    public function invoice_setting()
    {
        return $this->hasOne('App\Models\Customers\InvoiceSetting','customer_id');
    }
    public function send_messages()
    {
        return $this->hasMany('App\CustomerMessages','to_id','id');
    }
    public function received_messages()
    {
        return $this->hasMany('App\CustomerMessages','from_id','id');
    }
}