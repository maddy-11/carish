<?php

namespace App\Models\Customers;
use Illuminate\Database\Eloquent\Model;
use App\User, View, Session, Redirect;
use App\Models\Services;
use App\Models\Customers\SubService;
use App\Models\Cars\Make;

class PrimaryService extends Model
{
    protected $table = 'primary_services';

    public function get_category_title(){
        return $this->hasMany('App\Models\PrimaryServicesDescription', 'primary_service_id', 'id');
    }

    public function category_count($cat_id){
    	return Services::where('status','1')->where('primary_service_id',$cat_id)->count();
    }

    public function get_sub_categories($cat_id){

		$activeLanguage = \Session::get('language');
		$engineTypesQuery       = SubService::query()->select("sub_service_id as sub_cat_id","is_make","sc.title");
		$engineTypesQuery->join('sub_services_description AS sc', 'sub_services.id', '=', 'sc.sub_service_id')->where('language_id', $activeLanguage['id']);
		$sub_categories   = $engineTypesQuery->where('primary_service_id', $cat_id)->where('parent_id', 0)->where('status',1)->orderBy('sc.title')->get();
		return $sub_categories;
    }

    public function sub_category_count($sub_cat_id){
    	return Services::where('status','1')->where('sub_service_id',$sub_cat_id)->count();
    }

    public function get_sub_subcategories($sub_cat_id,$is_make){
    	if($is_make == 1)
    	{ 
    		$sub_subcategories = Make::where('status',1)->orderBy('title', 'ASC')->get();
    	}
    	else
    	{
		$activeLanguage = \Session::get('language');
		$engineTypesQuery       = SubService::query()->select("sub_service_id as id","is_make","sc.title");
		$engineTypesQuery->join('sub_services_description AS sc', 'sub_services.id', '=', 'sc.sub_service_id')->where('language_id', $activeLanguage['id']);
		$sub_subcategories   = $engineTypesQuery->where('parent_id', $sub_cat_id)->where('status',1)->orderBy('sc.title')->get();
		}

		return $sub_subcategories;
    }


    public function sub_subcategory_count($sub_subcat_id){
    	return Services::where('status','1')->where('sub_sub_service_id',$sub_subcat_id)->count();
    }


}
