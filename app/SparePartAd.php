<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use App\Models\SpAdDescription;
use App\SparePartAdTitle;
use App\SparepartsAdsMessage;
use App\Models\Customers\CustomerAccount;
use App\AdMsg;
use App\ReasonsDescription;
use App\Models\SparePartCategoriesDescription;

class SparePartAd extends Model
{
    public function category(){
    	return $this->belongsTo('App\SparePartCategory');
    }
    public function customer(){
        return $this->belongsTo('App\Models\Customers\Customer','customer_id','id');
    }
    public function sp_ads_description(){
        return $this->hasMany('App\Models\SpAdDescription','spare_part_ad_id','id');
    }
    public function parent_category(){
        return $this->belongsTo('App\SparePartCategory','parent_id','id');
    }
    public function maker(){
        return $this->belongsTo('App\Models\Cars\Make','make_id','id');
    }
    public function model(){
        return $this->belongsTo('App\Models\Cars\Carmodel','model_id','id');
    }
    public function sub_category(){
        return $this->belongsTo('App\SparePartCategory','category_id','id');
    }
    public function city(){
        return $this->belongsTo('App\City','city_id','id');
    }
    public function get_one_image(){
    	return $this->hasOne('App\SparePartAdImage');
    }
    public function spare_parts_images(){
        return $this->hasMany('App\SparePartAdImage','spare_part_ad_id','id');
    }
    public function get_customer(){
    	return $this->belongsTo('App\Models\Customers\Customer','customer_id','id');
    }
    public function get_saved_ads(){
            return $this->hasOne('App\UserSavedSpareParts','spare_part_ad_id','id');
    }
    public function get_parent_category($p_cat_id , $lang_id){
        //dd($p_cat_id ,$lang_id);
        return SparePartCategoriesDescription::where('spare_part_category_id',@$p_cat_id)->where('language_id',@$lang_id)->pluck('title')->first();
    }
    public function get_category($cat_id , $lang_id){
        //dd($p_cat_id ,$lang_id);
        return SparePartCategoriesDescription::where('spare_part_category_id',@$cat_id)->where('language_id',@$lang_id)->pluck('title')->first();
    }
    public function get_sp_ad_description($ad_id , $lang_id){
        // dd($ad_id ,$lang_id);
        return SpAdDescription::where('spare_part_ad_id',@$ad_id)->where('language_id',@$lang_id)->first();
    }
    public function get_sp_ad_title($ad_id , $lang_id){
        // dd($ad_id ,$lang_id);
        return SparePartAdTitle::where('spare_part_ad_id',@$ad_id)->where('language_id',@$lang_id)->pluck('title')->first();
    }
    public function is_feature(){
        return $this->belongsTo('App\Models\Customers\FeaturedRequest','id','ad_id');
    }
    public function is_paid_ad(){
        return $this->hasOne('App\Models\Customers\CustomerAccount','ad_id','id')->latest();
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
    
    public function get_reasons($ad_id){

        $not_approved_reasons  =  SparepartsAdsMessage::where('spare_parts_ads_id',$ad_id)->get();
         $all_res = '';
        foreach ($not_approved_reasons as $npr) {
            $reason = ReasonsDescription::where('reason_id',$npr->reason_id)->where('language_id',2)->first();

            $all_res .= '<li>'.@$reason->title.'</li>';
        }
        return $all_res;
    }

    public function get_lang_wise_removed_reasons($ad_id){

        $removed_reasons  =  SparepartsAdsMessage::where('spare_parts_ads_id',$ad_id)->orderBy('id','DESC')->first();
        $title = 'N/A';
        if($removed_reasons){
            $activeLanguage = \Session::get('language');
            $lang_id = $activeLanguage['id'];
            $reason_desc = ReasonsDescription::where('reason_id',$removed_reasons->reason_id)->where('language_id',$lang_id)->first();
            $title = $reason_desc->title;
        }
        
        return $title; // title
    }

    public function get_invoice($ad_id){
       $invoice  = CustomerAccount::where('ad_id',$ad_id)->where('type','sparepart_ad')->first();
       return $invoice->id;
    }
}