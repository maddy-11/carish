<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ServiceDescription;
use App\ServiceTitle;
use App\ServiceMessage;
use App\ReasonsDescription;

class Services extends Model
{
     public function get_customer()
    {
    	return $this->belongsTo('App\Models\Customers\Customer','customer_id','id');
    }

    public function get_service_image(){
    	return $this->hasOne('App\Models\ServiceImage','service_id','id');
    }
    
    public function services_images(){
        return $this->hasMany('App\Models\ServiceImage','service_id','id');
    }

     public function service_details(){
    	return $this->hasMany('App\ServiceDetail','service_id','id');
    }

    public function primary_service(){
        return $this->belongsTo('App\Models\Customers\PrimaryService','primary_service_id','id');
    }

    public function sub_service(){
        return $this->belongsTo('App\Models\Customers\SubService','sub_service_id','id');
    }

    public function sub_sub_service(){
        return $this->belongsTo('App\Models\Customers\SubService','sub_sub_service_id','id');
    }

   /* public function category(){
        return $this->belongsTo('App\Models\Customers\SubService','category_id','id');
    }

     public function sub_category(){
        return $this->belongsTo('App\Models\Customers\SubService','sub_category_id','id');
    }*/

    public function get_category($primary_service_id , $lang_id){
        return PrimaryServicesDescription::where('primary_service_id',@$primary_service_id)->where('language_id',@$lang_id)->pluck('title')->first();
    }

    public function category($primary_service_id , $lang_id){
        return PrimaryServicesDescription::where('primary_service_id',@$primary_service_id)->where('language_id',@$lang_id)->first();
    }

     public function sub_category($sub_service_id , $lang_id){
        return SubServicesDescription::where('sub_service_id',@$sub_service_id)->where('language_id',@$lang_id)->first();
    }

    public function detials($sub_sub_service_id , $lang_id){
        return SubServicesDescription::where('sub_service_id',@$sub_sub_service_id)->where('language_id',@$lang_id)->first();
    }

    public function get_service_description($service_id , $lang_id){
        // dd($ad_id ,$lang_id);
        return ServiceDescription::where('service_id',@$service_id)->where('language_id',@$lang_id)->first();
    }

    public function service_description(){
        return $this->hasMany('App\ServiceDescription','service_id','id');
    }

    public function get_service_ad_title($ad_id , $lang_id){
        return ServiceTitle::where('services_id',@$ad_id)->where('language_id',@$lang_id)->first();
    }

    public function is_feature(){
            return $this->belongsTo('App\Models\Customers\FeaturedRequest','id','ad_id');
    }
    public function is_paid_ad(){
        return $this->hasOne('App\Models\Customers\CustomerAccount','ad_id','id');
    }
    public function ads_status($status){
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
    public function ads_url($status){
        if($status == 0)
        {
            return 'pending-ads';
        }
        else if($status == 1)
        {
            return 'active-ads';
        }
        else if($status == 2)
        {
            return 'remove-ads';
        }
        else if($status == 3)
        {
            return 'not-approved-ads';
        }
        else if($status == 5)
        {
            return 'unpaid-ads';
        }
    }
    public function get_reasons($service_id){

        $not_approved_reasons  =  ServiceMessage::where('services_id',$service_id)->get();
         $all_res = '';
        foreach ($not_approved_reasons as $npr) {
            $reason = ReasonsDescription::where('reason_id',$npr->reason_id)->where('language_id',2)->first();

            $all_res .= '<li>'.@$reason->title.'</li>';
        }
        return $all_res;
    }

    public function get_lang_wise_removed_reasons($ad_id){

        $removed_reasons  =  ServiceMessage::where('services_id',$ad_id)->orderBy('id','DESC')->first();
        $title = 'N/A';
        if($removed_reasons){
            $activeLanguage = \Session::get('language');
            $lang_id = $activeLanguage['id'];
            $reason_desc = ReasonsDescription::where('reason_id',$removed_reasons->reason_id)->where('language_id',$lang_id)->first();
            $title = $reason_desc->title;
        }
        
        return $title; // title
    }
}
