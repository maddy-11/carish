<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cars\Features;
use App\Models\AdDescription;
use App\Models\EngineTypeDescription;
use App\BodyTypesDescription;
use App\ColorsDescription;
use App\AdMsg;
use App\ReasonsDescription;
use App\Models\Customers\CustomerAccount;

class Ad extends Model
{
    protected $hidden = ['remember_token'];
    public function tags(){
        return $this->belongsToMany('App\Tag', 'ad_tag');
     }
    public function suggessions(){
        return $this->belongsToMany('App\Suggesstion');
     }
    public function ads_images(){
        return $this->hasMany('App\AdImage','ad_id','id');
    }
    public function ads_description(){
        return $this->hasMany('App\Models\AdDescription','ad_id','id');
    }
    public function ad_tags(){
        return $this->hasMany('App\AdTag','ad_id','id');
    }
    public function maker(){
        return $this->belongsTo('App\Models\Cars\Make','maker_id','id');
    }
    public function model(){
        return $this->belongsTo('App\Models\Cars\Carmodel','model_id','id');
    }
    public function transmission(){
        return $this->belongsTo('App\Models\Transmission','transmission_type','id');
    }
    public function transmissionDescription(){
        return $this->belongsTo('App\Models\TransmissionDescription', 'transmission_type', 'transmission_id');
    }
    public function fuel(){
        return $this->belongsTo('App\Models\EngineType','fuel_type','id');
    }
    public function get_fuel_type_description($fuel_type , $lang_id){
        return EngineTypeDescription::where('engine_type_id',@$fuel_type)->where('language_id',@$lang_id)->first();
    }
    public function engineTypeDescription(){
        return $this->belongsTo('App\Models\EngineTypeDescription', 'fuel_type', 'engine_type_id');
    }
    public function versions(){
        return $this->belongsTo('App\Models\Cars\Version','version_id','id');
    }
    public function color(){
        return $this->belongsTo('App\Color','color_id','id');
    }
    public function get_color_type_description($color_id , $lang_id){
        return ColorsDescription::where('color_id',@$color_id)->where('language_id',@$lang_id)->first();
    }
    public function colorDescription(){
        return $this->belongsTo('App\ColorsDescription','color_id','color_id');
    }
    public function city(){
        return $this->belongsTo('App\City', 'poster_city','id');
    }
    public function country(){
        return $this->belongsTo('App\Models\Country','country_id','id');
    }

    public function countryRegistered(){
        return $this->belongsTo('App\Models\BoughtFrom','bought_from_id','id');
    }

    public function customer(){
        return $this->belongsTo('App\Models\Customers\Customer','customer_id','id');
    }
    public function get_feature($id){
        return Features::where('id',@$id)->first();
    }
    public function get_ad_description($ad_id , $lang_id){
        // dd($ad_id ,$lang_id);
        return AdDescription::where('ad_id',@$ad_id)->where('language_id',@$lang_id)->first();
    }
    public function body_type(){
        return $this->belongsTo('App\Models\Cars\BodyTypes','body_type_id','id');
    }
    public function body_type_description(){
        return $this->belongsTo('App\BodyTypesDescription','body_type_id','body_type_id');
    }
    public function get_body_type_description($body_type_id , $lang_id){
        return BodyTypesDescription::where('body_type_id',@$body_type_id)->where('language_id',@$lang_id)->first();
    }
    public function get_saved_ads(){
            return $this->hasOne('App\UserSavedAds','ad_id','id');
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

        $not_approved_reasons  =  AdMsg::where('ad_id',$ad_id)->get();
         $all_res = '';
        foreach ($not_approved_reasons as $npr) {
            $reason = ReasonsDescription::where('reason_id',$npr->reason_id)->where('language_id',2)->first();

            $all_res .= '<li>'.@$reason->title.'</li>';
        }
        return $all_res;
    }

    public function get_lang_wise_removed_reasons($ad_id){
        $removed_reasons  =  AdMsg::where('ad_id',$ad_id)->orderBy('id','DESC')->first();
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
       $invoice  = CustomerAccount::where('ad_id',$ad_id)->where('type','car_ad')->orderBy('id','DESC')->first();
       return $invoice->id;
    }
}
