<?php

namespace App\Http\Controllers\Guest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cars\Make;
use App\Models\Cars\Carmodel;
use App\Models\Cars\Version;
use App\Models\Cars\BodyTypes;
use App\Models\Services;
use App\Models\Customers\Customer;
use App\Models\CustomerTiming;
use App\SparePartCategory;
use App\Models\Customers\PrimaryService;
use App\Models\Customers\SubService;
use App\ServiceTitle;
use App\User, View, Session, Redirect;
use Mail;
use App\Mail\ResetPasswordMail;

use App\City;
use App\Models\Country;
use App\SparePartAd;
use App\Tag;
use App\Ad;
use App\Color;
use DB;
use Illuminate\Support\Arr;
use Lang;
use App\Suggesstion;
use App\EmailTemplate;
use App\EmailTemplateDescription;

use App\Models\EngineType;
use App\Models\Transmission;
use App\Models\TyreManufacturer;
use App\Models\WheelManufacturer;
use App\Models\Brand;

class SearchController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function getServicesScats()
  {
    $activeLanguage = \Session::get('language');
    if (request()->ajax()) {
      $term       = request()->get('term');
      $spareParts =  PrimaryService::select('ss.primary_service_id as cat_id', 'psd.title AS primary_title', 'ssd.sub_service_id', 'ssd.title')
        ->join('primary_services_description as psd', 'primary_services.id', '=', 'psd.primary_service_id')
        ->join('sub_services AS ss', 'primary_services.id', '=', 'ss.primary_service_id')
        ->join('sub_services_description AS ssd','ss.id','=','ssd.sub_service_id')
        ->where('psd.language_id', $activeLanguage['id'])
        ->where('ssd.language_id', $activeLanguage['id'])
        ->where('ssd.title', 'like', "%$term%")
        ->where('primary_services.status', 1)
        ->where('ss.status', 1)->get();
      $result = array();
      if (!$spareParts->isEmpty()) {
        foreach ($spareParts as $sparePart) {
          $result[] = ['id' => 'ps_' . $sparePart->cat_id . '/cat_' . $sparePart->sub_service_id, 'value' => $sparePart->title .'-'. $sparePart->primary_title];
        }
      }
    } else {
      return response('Forbidden.', 403);
    }
    return response()->json($result);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function offerservicesListing()
  {
    $activeLanguage = \Session::get('language');
    $engineTypesQuery       = PrimaryService::query()->select("primary_service_id as cat_id", "image", "ps.title","slug");
    $engineTypesQuery->join('primary_services_description AS ps', 'primary_services.id', '=', 'ps.primary_service_id')->where('language_id', $activeLanguage['id']);
    $categories   = $engineTypesQuery->where('status', 1)->orderBy('ps.title')->get();
    return view('guest.offerservices_listings', compact('categories'));
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function machinicsListing()
  {
    return view('guest.machinics_listing');
  }

  public function categoryMachinicsListing($id)
  {
    $services = Services::select('customer_id')->where('primary_service_id', $id)->get();
    $customer_ids = $services->unique('customer_id');
    $category = PrimaryService::where('id', $id)->first();
    // dd($customer_ids);
    return view('guest.machinics_listing', compact('customer_ids', 'id', 'category'));
  }

  public function getDealers()
  {
    if (request()->ajax()) {
      $term     = request()->get('term');
      $businessUsers    =  Customer::select('id', 'customer_firstname', 'customer_lastname', 'customer_company')
        ->where('customer_company', 'like', "%$term%")
        ->where('customer_role', '=', "business")->get();
      $result = array();
      if (!$businessUsers->isEmpty()) {
        foreach ($businessUsers as $businessUser) {
          //$result[] = ['id' => "cat_".$sparePart->parent_id."/scat_".$sparePart->category_id."/".$sparePart->id, 'value' => $sparePart->title.' - '. $sparePart->product_code];
          $result[] = ['id' => 'dealer_' . $businessUser->id, 'value' => $businessUser->customer_company];
        }
      }
    } else {
      return response('Forbidden.', 403);
    }
    return response()->json($result);
  }

  public function getServices()
  {
    if (request()->ajax()) {
      $term            = request()->get('term');
      $p_id            = request()->get('p_id');
      $activeLanguage  = \Session::get('language');
      $servicesQuery   = Services::query();
      $servicesQuery->select(
        "st.id as title_id",
        "st.title AS service_title"
      );
      $servicesQuery->join('service_titles AS st', 'services.id', '=', 'st.services_id');
      $servicesQuery->join('primary_services AS ps', 'services.primary_service_id', '=', 'ps.id');
      $servicesQuery->where('st.language_id', '=', $activeLanguage['id']);

      $servicesQuery->where('st.title', 'like', "%$term%");
      $servicesQuery->where('st.language_id', $activeLanguage['id']);
      $servicesQuery->where('services.primary_service_id', $p_id);
      $servicesQuery->where('ps.status', 1);
      $servicesQuery->where('services.status', 1);
      $services = $servicesQuery->get();
      $result           = array();
      if (!$services->isEmpty()) {
        foreach ($services as $service) {
          $result[] = ['id' => 'service_' . $service->title_id, 'value' => $service->service_title];
        }
      }
    } else {
      return response('Forbidden.', 403);
    }
    return response()->json($result);
  }

  public function getSpareParts()
  {
    if (request()->ajax()) {
      $term     = request()->get('term');

      $spareParts     = SparePartAd::query()->distinct('spare_part_ads.id')->groupBy('spare_part_ads.id');
      $spareParts->select('id', 'title', 'product_code', 'parent_id', 'category_id');
      //$spareParts->where(DB::raw("(title LIKE '" % $term % "' OR product_code LIKE '" % $term % "')"));
      $spareParts->whereRaw(DB::raw(
        '(title LIKE "%' . $term . '%"  OR product_code LIKE  "%' . $term . '%" )'
      ));
      /*  $spareParts->orWhere('title', 'like', "%$term%");
      $spareParts->orWhere('product_code', 'like',"%$term%"); */
      if (request()->has('subCategoryId') && request()->get('subCategoryId') != '') {
        $subCategoryId = request()->get('subCategoryId');
        $spareParts->where('category_id', '=', $subCategoryId);
      }

      /* echo $result    = $spareParts->toSql();
      exit; */

      $sparePartsResult = $spareParts->get();
      $result = array();
      if (!$sparePartsResult->isEmpty()) {
        foreach ($sparePartsResult as $sparePart) {
          //$result[] = ['id' => "cat_".$sparePart->parent_id."/scat_".$sparePart->category_id."/".$sparePart->id, 'value' => $sparePart->title.' - '. $sparePart->product_code];
          $result[] = ['id' => $sparePart->id, 'value' => $sparePart->title . ' - ' . $sparePart->product_code];
        }
      }
    } else {
      return response('Forbidden.', 403);
    }
    return response()->json($result);
  }


  public function getSparePartsCats()
  {
    $activeLanguage = \Session::get('language');
    if (request()->ajax()) {
      $term     = request()->get('term');
      $spareParts    =  SparePartCategory::select('spare_part_categories.id', 'spare_part_categories_description.title', 'spare_part_categories.parent_id', 'spare_part_categories_description.spare_part_category_id')->join('spare_part_categories_description', 'spare_part_categories.id', '=', 'spare_part_categories_description.spare_part_category_id')
        ->where('spare_part_categories_description.language_id', $activeLanguage['id'])
        ->where('spare_part_categories_description.title', 'like', "%$term%")
        ->where('spare_part_categories.status', 1)
        ->where('spare_part_categories.parent_id', '>', "0")->get();
      $result = array();
      if (!$spareParts->isEmpty()) {
        foreach ($spareParts as $sparePart) {
          $parent = ' - ' . $sparePart->parent->get_category_title()->where('language_id', $activeLanguage['id'])->pluck('title')->first();
          $result[] = ['id' => 'cat_' . $sparePart->parent_id . '/scat_' . $sparePart->id, 'value' => $sparePart->title . $parent];
        }
      }
    } else {
      return response('Forbidden.', 403);
    }
    return response()->json($result);
  }


  public function autoPartsListing($params = null)
  {
    $parent_child_cat = explode("/",$params);
 
    $parent_category = SparePartCategory::where('slug',$parent_child_cat[0])->first();

    if($parent_child_cat[0]){
      $parent_child_cat[0] = 'cat_'.$parent_category->id;
      $p_slug = $parent_category->slug;
    }

   if(isset($parent_child_cat[0]) && isset($parent_child_cat[1]) 
    && strpos($parent_child_cat[1], 'dealer_') === false 
    && strpos($parent_child_cat[1], 'partid_') === false 
    && strpos($parent_child_cat[1], 'city_') === false 
    && strpos($parent_child_cat[1], 'sortby_') === false
     && strpos($parent_child_cat[1], 'productcode_') === false 
    && strpos($parent_child_cat[1], 'condition_') === false 
    && strpos($parent_child_cat[1], 'price_') === false 
    && strpos($parent_child_cat[1], 'pic_')  === false 
    && strpos($parent_child_cat[1], 'mk_') === false
     && strpos($parent_child_cat[1], 'mo_')  === false 
     && strpos($parent_child_cat[1], 'power_') === false 
     && strpos($parent_child_cat[1], 'enginecc_') === false
     && strpos($parent_child_cat[1], 'mt_') === false
     && strpos($parent_child_cat[1], 'size_') === false
     && strpos($parent_child_cat[1], 'tt_') === false
     && strpos($parent_child_cat[1], 'tq_') === false
     && strpos($parent_child_cat[1], 'mr_') === false
     && strpos($parent_child_cat[1], 'sizeinch_') === false
    && strpos($parent_child_cat[1], 'offset_') === false
    && strpos($parent_child_cat[1], 'style_') === false
  && strpos($parent_child_cat[1], 'holes_') === false
&& strpos($parent_child_cat[1], 'dholes_') === false
&& strpos($parent_child_cat[1], 'rq_') === false)
   {
      $child_category = SparePartCategory::where('slug',$parent_child_cat[1])->first();
      $parent_child_cat[0] = 'cat_'.$parent_category->id;
      $parent_child_cat[1] = 'scat_'.$child_category->id;
      $c_slug = $child_category->slug;

      $filter = $child_category->filter;

    }else{
      $filter = $parent_category->filter;
    }
    
    $queyStringArray = array();
    $searchFilters   = array();
    $queryStringArray = array();
    $scat_title = '';
    $subCategories = null;


    if($parent_child_cat) {
      foreach ($parent_child_cat as $parm) {
        $newArray      = explode("_", $parm,2);
        $arrayFirst    = head($newArray);
        $arrayLast     = last($newArray);
        $queyStringArray[$arrayFirst][] = $arrayLast;
      }
     
    }
    // print_r($queyStringArray).'<br>';
    $sparepartsQuery     = SparePartAd::query()->distinct('spare_part_ads.id')->groupBy('spare_part_ads.id');
    $select = array(
      "spare_part_ads.id", "spare_part_ads.is_featured",  "spare_part_ads.title as spare_part_title",
      "customer_id", "price", "city_id", "spare_part_ads.updated_at", "spare_part_ads.category_id", "neg", "poster_phone"
    );
    
    $sortBy = '';
    if (Arr::has($queyStringArray, 'sortby')) {
      $sortBy = $queyStringArray['sortby'][0];
      $sparepartsQuery->orderByRaw('spare_part_ads.' . $sortBy);
    }
    else{
      $sparepartsQuery->orderByRaw('spare_part_ads.' . 'is_featured,spare_part_ads.updated_at DESC'); 
    }

    $sparepartsQuery->select($select);
    $sparepartsQuery->where('spare_part_ads.status', '=', 1);
    $sparepartsQuery->leftJoin('makes AS m', 'm.id', '=', 'spare_part_ads.make_id');
    $sparepartsQuery->leftJoin('models AS mo', 'mo.id', '=', 'spare_part_ads.model_id');
    $sparepartsQuery->leftJoin('tyre_manufacturers AS tm', 'tm.id', '=', 'spare_part_ads.f3_tyre_manufacturer');
    $sparepartsQuery->leftJoin('wheel_manufacturers AS rm', 'rm.id', '=', 'spare_part_ads.f4_wheel_manufacturer');
    


    if (Arr::has($queyStringArray, 'cat')) {
      $parentCategory = $queyStringArray['cat'][0];
      $sparepartsQuery->where('parent_id', $parentCategory);
      $category        = SparePartCategory::where('id', $parentCategory)->first();
      $childCategories = SparePartCategory::where('parent_id', $parentCategory)->where('status', 1)->get();
      $parentChildCategories = SparePartCategory::where('parent_id', $parentCategory)->where('status', 1)->get();
      $queryStringArray['cat'] = " AND sc.parent_id =" . $parentCategory . " ";
      $totalAdsInParents = SparePartAd::where('status', 1)->where('parent_id', $parentCategory)->count();
      $searchFilters['cat_' . $parentCategory] = $category->title;
    }
    if (Arr::has($queyStringArray, 'scat')) {
      $subCategories = $queyStringArray['scat'][0];
      $sparepartsQuery->where('category_id', $subCategories);
      $queryStringArray['subCategories'] = " AND sc.category_id = " . $subCategories . " ";
      $scat  = SparePartCategory::select('title')->where('id', $subCategories)->first();
      $scat_title =  $scat->title;
      $totalAdsInParents = '';
      $childCategories = SparePartCategory::where('parent_id', $subCategories)->where('status', 1)->get();
      $searchFilters['scat_' . $subCategories] = $scat->title;
    }
    if (Arr::has($queyStringArray, 'dealer')) {
      $dealer = $queyStringArray['dealer'][0];
      $sparepartsQuery->join('customers AS cm', 'cm.id', '=', 'spare_part_ads.customer_id');
      $sparepartsQuery->where('customer_company', 'like', "%$dealer%");
      $searchFilters['dealer_' . $dealer] = $dealer;
      $totalAdsInParents = '';
    }
    if (Arr::has($queyStringArray, 'productcode')) {
      $productcode = $queyStringArray['productcode'][0];
   
      $sparepartsQuery->where('product_code', '=', "$productcode");
      $searchFilters['productcode_' . $productcode] = $productcode;
      $totalAdsInParents = '';
    }
    if (Arr::has($queyStringArray, 'partid')) {
      $part_id = $queyStringArray['partid'][0];
      $sparepartsQuery->where('spare_part_ads.id', '=', $part_id);
      $spa        = SparePartAd::select('title', 'product_code')->where('id', $part_id)->first();
      $spa =  $spa->title . '-' . $spa->product_code;
      $params = str_replace('partid_' . $queyStringArray['partid'][0], 'partid_' . $spa, $params);
      $queyStringArray['partid'][0] = $spa;
      $searchFilters['partid_' . $part_id] = $spa;
      $totalAdsInParents = '';
    }
    if (Arr::has($queyStringArray, 'ct') || Arr::has($queyStringArray, 'city')) {

      if (Arr::has($queyStringArray, 'ct') && Arr::has($queyStringArray, 'city')) {
        $city_id   = array_merge($queyStringArray['ct'], $queyStringArray['city']);
        unset($queyStringArray['city']);
      } 
      else {
        if (Arr::has($queyStringArray, 'ct')) {
          $city_id   = $queyStringArray['ct'];
        }
        if (Arr::has($queyStringArray, 'city')) {
          $city_id   = $queyStringArray['city'];
        }
      }
      $city_id        = array_unique($city_id);
      $sparepartsQuery->whereIn('city_id', $city_id);
      $cityName  = City::select('name')->whereIn('id', $city_id)->where('status', 1)->get();
      // $cityName  = $cityName->name;
      $list      = "'" . implode("', '", $city_id) . "'";
      $queryStringArray['cities'] = " AND c.city_id IN(" . $list . ")";
    }

    if (Arr::has($queyStringArray, 'condition')) {

      $condition   = $queyStringArray['condition'];  
      $condition        = array_unique($condition);
      $sparepartsQuery->whereIn('condition', $condition);

      $list      = "'" . implode("', '", $condition) . "'";
      $queryStringArray['condition'] = " AND sc.condition IN(" . $list . ")";
    }
    
    if (Arr::has($queyStringArray, 'price')) {

      $price = explode('-', $queyStringArray['price'][0]);
      if (count($price) == 1) {
        $sparepartsQuery->where('price', '>=', $price[0]);
        $queryStringArray['price'] = " AND price >='" . $price[0] . "'";
      } else if (count($price) == 2 && $price[0] == "") {
        $sparepartsQuery->where('price', '<=', $price[1]);
        $queryStringArray['price'] = " AND price <='" . $price[0] . "'";
      } else if (count($price) == 2 && $price[1] == "") {
        $sparepartsQuery->where('price', '>=', $price[0]);
        $queryStringArray['price'] = " AND price >='" . $price[0] . "'";
      } else {
        $sparepartsQuery->whereBetween('price', [$price[0], $price[1]]);
        $queryStringArray['price'] = " AND price BETWEEN '" . $price[0] . "' AND '" . $price[1] . "'";
      }

      $searchFilters['price_' . $queyStringArray['price'][0]] = $queyStringArray['price'][0];
    }

    if (Arr::has($queyStringArray, 'pic')) {
      $sparepartsQuery->join('spare_part_ad_images  AS sp', 'sp.spare_part_ad_id', '=', 'spare_part_ads.id');
      $queryStringArray['pic_' . $queyStringArray['pic'][0]] = $queyStringArray['pic'][0];
    } 
    else {
      $sparepartsQuery->leftJoin('spare_part_ad_images AS sp', 'sp.spare_part_ad_id', '=', 'spare_part_ads.id');
    }

    if (Arr::has($queyStringArray, 'mk')) {
      $sparepartsQuery->whereIn('m.title', $queyStringArray['mk']);
      $list = "'" . implode("', '", $queyStringArray['mk']) . "'";
      $queryStringArray['makes'] = " AND m.title IN(" . $list . ")";
      $queryStringArray['mk_' . $queyStringArray['mk'][0]]      = $queyStringArray['mk'][0];
    }
    if (Arr::has($queyStringArray, 'mo')) {
      $sparepartsQuery->whereIn('mo.name', $queyStringArray['mo']);
      $list = "'" . implode("', '", $queyStringArray['mo']) . "'";
      $queryStringArray['models'] = " AND mo.name IN(" . $list . ")";

      $queryStringArray['mo_' . $queyStringArray['mo'][0]] = $queyStringArray['mo'][0];
    }

    if (Arr::has($queyStringArray, 'enginecc')) {
      $enginecc = explode('-', $queyStringArray['enginecc'][0]);
      if (count($enginecc) == 1) {
        $sparepartsQuery->where('f2_liter', '>=', $enginecc[0]);
        $queryStringArray['enginecc'] = " AND f2_liter >='" . $enginecc[0] . "'";
      } else if (count($enginecc) == 2 && $enginecc[0] == "") {
        $sparepartsQuery->where('f2_liter', '<=', $enginecc[1]);
        $queryStringArray['enginecc'] = " AND f2_liter <='" . $enginecc[0] . "'";
      } else if (count($enginecc) == 2 && $enginecc[1] == "") {
        $sparepartsQuery->where('f2_liter', '>=', $enginecc[0]);
        $queryStringArray['enginecc'] = " AND f2_liter >='" . $enginecc[0] . "'";
      } else {
        $sparepartsQuery->whereBetween('f2_liter', [$enginecc[0], $enginecc[1]]);
        $queryStringArray['enginecc'] = " AND f2_liter BETWEEN '" . $enginecc[0] . "' AND '" . $enginecc[1] . "'";
      }

      $searchFilters['enginecc_' . $queyStringArray['enginecc'][0]] = $queyStringArray['enginecc'][0];
    }
    if (Arr::has($queyStringArray, 'power')) {
      $power = explode('-', $queyStringArray['power'][0]);
      if (count($power) == 1) {
        $sparepartsQuery->where('f2_kw', '>=', $power[0]);
        $queryStringArray['power'] = " AND f2_kw >='" . $power[0] . "'";
      } else if (count($power) == 2 && $power[0] == "") {
        $sparepartsQuery->where('f2_kw', '<=', $power[1]);
        $queryStringArray['power'] = " AND f2_kw <='" . $power[0] . "'";
      } else if (count($power) == 2 && $power[1] == "") {
        $sparepartsQuery->where('f2_kw', '>=', $power[0]);
        $queryStringArray['power'] = " AND f2_kw >='" . $power[0] . "'";
      } else {
        $sparepartsQuery->whereBetween('f2_kw', [$power[0], $power[1]]);
        $queryStringArray['power'] = " AND f2_kw BETWEEN '" . $power[0] . "' AND '" . $power[1] . "'";
      }

      $searchFilters['power_' . $queyStringArray['power'][0]] = $queyStringArray['power'][0];
    }


    if (Arr::has($queyStringArray, 'mt')) {
      $sparepartsQuery->whereIn('tm.title', $queyStringArray['mt']);
      $list = "'" . implode("', '", $queyStringArray['mt']) . "'";
      $queryStringArray['mtyers'] = " AND tm.title IN(" . $list . ")";

      $queryStringArray['mt_' . $queyStringArray['mt'][0]] = $queyStringArray['mt'][0];
    }
    if (Arr::has($queyStringArray, 'size')) {
      $size = $queyStringArray['size'][0];
   
      $sparepartsQuery->where('size', '=', "$size");
      $searchFilters['size_' . $size] = $size;
    }
    if (Arr::has($queyStringArray, 'tt')) {
      $t_type = $queyStringArray['tt'][0];
   
      $sparepartsQuery->where('f3_type', '=', "$t_type");
      $searchFilters['tt_' . $t_type] = $t_type;
    }
     if (Arr::has($queyStringArray, 'tq')) {
      $t_quantity = $queyStringArray['tq'][0];
   
      $sparepartsQuery->where('f3_quantity', '=', "$t_quantity");
      $searchFilters['tq_' . $t_quantity] = $t_quantity;
    }

    if (Arr::has($queyStringArray, 'mr')) {
      $sparepartsQuery->whereIn('rm.title', $queyStringArray['mr']);
      $list = "'" . implode("', '", $queyStringArray['mr']) . "'";
      $queryStringArray['mrims'] = " AND tm.title IN(" . $list . ")";

      $queryStringArray['mr_' . $queyStringArray['mr'][0]] = $queyStringArray['mr'][0];
    }
     if (Arr::has($queyStringArray, 'sizeinch')) {
      $sizeinch = $queyStringArray['sizeinch'][0];
   
      $sparepartsQuery->where('f4_size_inch', '=', "$sizeinch");
      $searchFilters['sizeinch_' . $sizeinch] = $sizeinch;
    }

    if (Arr::has($queyStringArray, 'offset')) {
      $offset = $queyStringArray['offset'][0];
   
      $sparepartsQuery->where('f4_offset_mm', '=', "$offset");
      $searchFilters['offset_' . $offset] = $offset;
    }

    if (Arr::has($queyStringArray, 'style')) {
      $style = $queyStringArray['style'][0];
   
      $sparepartsQuery->where('f4_style', '=', "$style");
      $searchFilters['style_' . $style] = $style;
    }

     if (Arr::has($queyStringArray, 'holes')) {
      $holes = $queyStringArray['holes'][0];
   
      $sparepartsQuery->where('f4_num_of_holes', '=', "$holes");
      $searchFilters['holes_' . $holes] = $holes;
    }

     if (Arr::has($queyStringArray, 'dholes')) {
      $dholes = $queyStringArray['dholes'][0];
   
      $sparepartsQuery->where('f4_distance_between_holes', '=', "$dholes");
      $searchFilters['dholes_' . $dholes] = $dholes;
    }

      if (Arr::has($queyStringArray, 'rq')) {
      $r_quantity = $queyStringArray['rq'][0];
   
      $sparepartsQuery->where('f4_quantity', '=', "$r_quantity");
      $searchFilters['rq_' . $r_quantity] = $r_quantity;
    }


    $GeneralSetting = session('GeneralSetting');
    $perpage_spareparts     = $GeneralSetting->perpage_spareparts;

    $sparepartsQuery->orderByRaw('spare_part_ads.' . 'is_featured');
    $allAds          =  $sparepartsQuery->paginate($perpage_spareparts); //$sparepartsQuery->get(); 
    $customer_ids     = $allAds->unique('customer_id');
    $searchedKeywords = '<div class="bg-white p-4"><ul class="list-unstyled mb-0 font-weight-semibold">';
    $citiesSet = true;
    $test = array();
    foreach ($queyStringArray as $keys => $values) {
      foreach ($values as $data) {
        $new_string    = $params;
        $link = $new_string;
        if ($keys == 'cat') {
          if (Arr::has($queyStringArray, 'scat')) {
            continue;
          }
        }

        $link          = str_replace($keys . '_' . $data . '/', '', $new_string);
        $link          = str_replace('/' . $keys . '_' . $data, '', $link);
        

        if (isset($searchFilters[$keys . '_' . $data]) && !empty($searchFilters[$keys . '_' . $data])) {
          $data          = $searchFilters[$keys . '_' . $data];
        }

        if (($keys == 'ct' || $keys == 'city') && $citiesSet) {
          foreach ($cityName as $cities) {
            $searchedKeywords .= '<li class="align-items-center d-flex justify-content-between">' . $cities->name . '<a  href="' . url('/') . '/find-autoparts/' . @$p_slug. '/'. @$c_slug . '"> <span class="fa fa-close themecolor2"></a></span></li>';
          }
          $citiesSet = false;
        } // END IF
        elseif ($keys == 'ct' || $keys == 'city') {
          continue;
        } else {

          $searchedKeywords .= '<li class="align-items-center d-flex justify-content-between">' . $data . '<a href="' . url('/') . '/find-autoparts/' . @$p_slug. '/'. @$c_slug . '"> <span class="fa fa-close themecolor2"></a></span></li>';
        } // END ELSE


      }
    }
    $searchedKeywords .= '</ul></div>';

    #################### CITIES LOCATIONS COUNT ##############################
    $whereCondition  = "SELECT count(c.id) as totalAdsInCities,c.id,c.name FROM spare_part_ads sc 
      INNER JOIN cities AS c ON c.id=sc.city_id ";
    $whereCondition .= " WHERE sc.status=1 " . $queryStringArray['cat'];
    if (Arr::has($queyStringArray, 'ct') || Arr::has($queyStringArray, 'city')) {
    //$whereCondition .= $queryStringArray['cities'];
    }
    if(isset($queryStringArray['subCategories'])){
      $whereCondition .= $queryStringArray['subCategories'];
    }
    $whereCondition .= " GROUP BY sc.city_id ";
    $sideBarArray['foundInCity'] = $this->getSelect($whereCondition);

    #################### CONDITION COUNT ##############################
    $whereCondition  = "SELECT count(sc.id) as totalAdsInCondition,sc.condition FROM spare_part_ads sc ";
    $whereCondition .= " WHERE sc.status=1 " . $queryStringArray['cat'];
    if (Arr::has($queyStringArray, 'condition')) {
    $whereCondition .= $queryStringArray['condition'];
    }
    if(isset($queryStringArray['subCategories'])){
      $whereCondition .= $queryStringArray['subCategories'];
    }
    $whereCondition .= " GROUP BY sc.condition ";
    $sideBarArray['foundInCondition'] = $this->getSelect($whereCondition);

     #################### MAKES ####################################
    $whereCondition = "SELECT count(m.id) as total_ads_in_makes,m.id,m.title 
      FROM spare_part_ads sc
      INNER JOIN makes    AS   m    ON m.id=sc.make_id ";
    $whereCondition .= " WHERE sc.status=1 ". $queryStringArray['cat'];
    if(isset($queryStringArray['subCategories'])){
      $whereCondition .= $queryStringArray['subCategories'];
    }
    $whereCondition ." GROUP BY m.id";
    $sideBarArray['foundInMake'] = $this->getSelect($whereCondition);

    #################### MODEL ####################################
    $whereCondition = "SELECT count(mo.id) as total_ads_in_models,mo.id,mo.name 
      FROM spare_part_ads sc
      INNER JOIN models AS mo ON mo.id=sc.model_id ";
     $whereCondition .= " WHERE sc.status=1 ". $queryStringArray['cat'];
    if(isset($queryStringArray['subCategories'])){
      $whereCondition .= $queryStringArray['subCategories'];
    }
    $whereCondition ." GROUP BY mo.id";
    $sideBarArray['foundInModel'] = $this->getSelect($whereCondition);

    #################### Manufacturer Tyre ####################################
    $whereCondition = "SELECT count(tm.id) as total_ads_in_mtyers,tm.id,tm.title 
      FROM spare_part_ads sc
      INNER JOIN tyre_manufacturers  AS tm ON tm.id=sc.f3_tyre_manufacturer ";
    $whereCondition .= " WHERE sc.status=1 ". $queryStringArray['cat'];
    if(isset($queryStringArray['subCategories'])){
      $whereCondition .= $queryStringArray['subCategories'];
    }
    $whereCondition ." GROUP BY tm.id";
    $sideBarArray['foundInMTyers'] = $this->getSelect($whereCondition);

    #################### CONDITION COUNT ##############################
    $whereCondition  = "SELECT count(sc.id) as totalAdsInTyreType,sc.f3_type FROM spare_part_ads sc ";
    //$whereCondition .= " WHERE sc.status=1 " . $queryStringArray['tt'];
    //if (Arr::has($queyStringArray, 'tt')) {
    //$whereCondition .= $queryStringArray['tt'];
    //}
    $whereCondition .= " GROUP BY sc.f3_type ";
    $sideBarArray['foundInTyreType'] = $this->getSelect($whereCondition);


    #################### Manufacturer Rim ####################################
    $whereCondition = "SELECT count(rm.id) as total_ads_in_mrims,rm.id,rm.title 
      FROM spare_part_ads sc
      INNER JOIN wheel_manufacturers AS rm ON rm.id=sc.f4_wheel_manufacturer ";
    $whereCondition .= " WHERE sc.status=1 ". $queryStringArray['cat'];
    if(isset($queryStringArray['subCategories'])){
      $whereCondition .= $queryStringArray['subCategories'];
    }
    $whereCondition ." GROUP BY rm.id";
    //echo $whereCondition;exit;
    $sideBarArray['foundInMRims'] = $this->getSelect($whereCondition);


    #################### Style COUNT ##############################
    $whereCondition  = "SELECT count(sc.id) as totalAdsInStyle,sc.f4_style FROM spare_part_ads sc ";
    $whereCondition .= " WHERE sc.status=1 " . $queryStringArray['cat'];
   
    if(isset($queryStringArray['subCategories'])){
      $whereCondition .= $queryStringArray['subCategories'];
    }
    $whereCondition .= " GROUP BY sc.f4_style ";
    $sideBarArray['foundInStyle'] = $this->getSelect($whereCondition);


    

    

    /* Sub Category COUNT SPAREPARTS ADS */
    $whereCondition = "SELECT COUNT(sc.id) as totalAdsInCategory,category_id FROM spare_part_ads sc ";
    $whereCondition .= " WHERE status=1 " . $queryStringArray['cat'] . " GROUP BY sc.category_id ";
    $childCategoriesCount = array();
    $subCats = $this->getSelect($whereCondition);

    foreach ($subCats as $cats) {
      $childCategoriesCount[$cats->category_id] = $cats->totalAdsInCategory;
    }

    $makes  =  make::where('status', 1)->orderBy('title', 'ASC')->get();

    $tyre_manufacturers  =  TyreManufacturer::orderBy('title', 'ASC')->get();

    $wheel_manufacturers  =  WheelManufacturer::orderBy('title', 'ASC')->get();

    $brands  =  Brand::orderBy('title', 'ASC')->get();
    
    return view('guest.auto_parts_listing', compact('sortBy','totalAdsInParents', 'childCategoriesCount', 'customer_ids', 'allAds', 'category', 'childCategories', 'subCategories','scat_title', 'queyStringArray', 'searchedKeywords', 'sideBarArray','parentChildCategories','makes','tyre_manufacturers','wheel_manufacturers','brands','filter'));
  }


  public function subAutoPartsListing($id, $sub)
  {
    $allAds = SparePartAd::where('parent_id', $id)->where('category_id', $sub)->get();
    // dd($allAds);
    $customer_ids = $allAds->unique('customer_id');
    $category     = SparePartCategory::where('id', $id)->first();
    $sub_category = SparePartCategory::where('id', $sub)->first();
    // dd($customer_ids);
    return view('guest.sub_auto_parts_listing', compact('customer_ids', 'allAds', 'category', 'sub_category'));
  }

  public function companyProfile($id)
  {
    $page_title = '';
    $GeneralSetting = session('GeneralSetting');
    $ads       = Ad::join('makes', 'ads.maker_id', '=', 'makes.id')->orderBy('makes.title', 'ASC')
      ->select('ads.*', 'v.kilowatt AS engine_power', 'v.cc as engine_capacity')
      ->where('customer_id', $id)->where('ads.status', 1)
      ->leftJoin('versions AS v', 'v.id', '=', 'ads.version_id')->get();
    $PartsAds = SparePartAd::where('customer_id', $id)->where('status', 1)
      ->orderBy('id', 'DESC')->get();
    $services = Services::where('customer_id', $id)->where('status', 1)->orderBy('id', 'DESC')->get();

    $customer = Customer::where('id', $id)->first();
    $timings = CustomerTiming::where('customer_id', $id)->get();
    $page_title = @$customer->customer_company.'/'.$GeneralSetting->title;
    return view('guest.company_profile', compact('customer', 'timings', 'ads', 'PartsAds', 'services','page_title'));
  }

  public function userSpearPartsAds($id)
  {
    $PartsAds = SparePartAd::where('customer_id', $id)->where('status', 1)
      ->orderBy('id', 'DESC')->get();
    $services = Services::where('customer_id', $id)->where('status', 1)->orderBy('id', 'DESC')->get();
    $ads       = Ad::join('makes', 'ads.maker_id', '=', 'makes.id')->orderBy('makes.title', 'ASC')->select('ads.*')->where('customer_id', $id)->where('ads.status', 1)->get();

    $customer = Customer::where('id', $id)->first();
    $timings  = CustomerTiming::where('customer_id', $id)->get();
    return view('guest.company_profile_spareparts', compact('customer', 'timings', 'PartsAds', 'services', 'ads'));
  }

  public function userServicesAds($id)
  {
    $services = Services::where('customer_id', $id)->where('status', 1)->orderBy('id', 'DESC')->get();
    $PartsAds = SparePartAd::where('customer_id', $id)->where('status', 1)
      ->orderBy('id', 'DESC')->get();
    $ads       = Ad::join('makes', 'ads.maker_id', '=', 'makes.id')->orderBy('makes.title', 'ASC')->select('ads.*')->where('customer_id', $id)->where('ads.status', 1)->get();


    $customer = Customer::where('id', $id)->first();
    $timings  = CustomerTiming::where('customer_id', $id)->get();

    return view('guest.company_profile_services', compact('customer', 'services', 'timings', 'PartsAds', 'ads'));
  }
  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function findUsedCars()
  {
    $activeLanguage = \Session::get('language');
    $ads       = Ad::where('is_featured', 'true')->get();
    $customers = Customer::all();
    $featured_dealers = array();
    foreach ($customers as $customer) {
      $ad = Services::where('customer_id', $customer->id)->where('is_featured', 'true')->get();
      if (@$ad->count() > 0) {
        array_push($featured_dealers, $customer);
      }
    }

    //$makes     = Make::limit(31)->orderBy('title', 'ASC')->get();
    //$models    = Carmodel::where('status', 1)->orderBy('name', 'ASC')->limit(55)->get();


    // $tags      = Tag::where('status',1)->get();

    $engineTypesQuery       = EngineType::query()->select("engine_type_id", "et.title");
    $engineTypesQuery->join('engine_types_description AS et', 'engine_types.id', '=', 'et.engine_type_id')->where('language_id', $activeLanguage['id']);
    $engineTypes            = $engineTypesQuery->where('status', 1)->orderBy('et.title')->get();

    $transmissionQuery      = Transmission::query()->select("transmission_id", "t.title");
    $transmissionQuery->join('transmission_description AS t', 'transmissions.id', '=', 't.transmission_id')->where('language_id', $activeLanguage['id']);
    $transmissions          = $transmissionQuery->where('status', 1)->orderBy('t.title')->get();

    $tagsQuery      = Tag::query()->select("id", "cd.name");
    $tagsQuery->join('tag_description AS cd', 'tags.id', '=', 'cd.tag_id')->where('language_id', $activeLanguage['id']);
    $tags        = $tagsQuery->where('status', 1)->get();

    return view('guest.find_used', compact('ads', 'featured_dealers', 'tags', 'engineTypes', 'transmissions'));
  }

  public function fetchCities()
  {
    $cities    = City::where('status', 1)->orderBy('name', 'ASC')->get();
    $html = '';
    if ($cities->count() > 0) {
      $html .= '<ul class="row form-row city-row list-unstyled" >';
      foreach ($cities as $city) {
        $html .= '<li class="col-xl-2 col-lg-3 col-md-3 col-sm-4 col-6"><a target="" href="' . route('simple.search') . '/ct_' . $city->name . '">' . $city->name . '</a></li>';
      }
      $html .= '</ul>';
    }
    return $html;
  }

  public function fetchBodyTypes()
  {
    if (request()->ajax()) {
      $activeLanguage = \Session::get('language');
      $bodyTypesQuery = BodyTypes::query()->select("body_type_id", "cd.name", "body_types.image");
      $bodyTypesQuery->join('body_types_description AS cd', 'body_types.id', '=', 'cd.body_type_id')->where('status', 1)->where('language_id', $activeLanguage['id'])->orderBy('cd.name');
      $bodytypes      = $bodyTypesQuery->get();
    }

    return response()->json(['data' => $bodytypes]);
  }

  public function categoryMakeModels()
  {
    $makes     = Make::select('make_id', 'title', 'name', 'makes.image')
      ->join('models AS m', 'makes.id', '=', 'm.make_id')->where('makes.status', 1)
      ->orderBy('title', 'ASC')->get();
    $models    = Carmodel::where('status', 1)->orderBy('name', 'ASC')->get();
    $cities    = City::where('status', 1)->orderBy('name', 'ASC')->get();
    $modelInMakes = array();
    foreach ($makes as $x => $make) {
      $modelInMakes[str_replace('', '_', $make->title)]['make'] = array('make_id' => $make->id, 'title' => $make->title, 'image' => $make->image);
      $modelInMakes[str_replace('', '_', $make->title)]['models'][] = $make->name;
    }
    return response()->json(['data' => $modelInMakes, 'models' => $models, 'cities' => $cities]);
  }
  public function categoryModels()
  {
    $models       = Carmodel::where('status', 1)->orderBy('name', 'ASC')->get();
    $modelInMakes = array();
    return response()->json(['data' => $models]);
  }

  public function findAutoParts()
  {
    $spareCategories = SparePartCategory::where('parent_id', 0)->where('status', 1)->orderBy('title', 'ASC')->get();
    return view('guest.find_auto_parts', compact('spareCategories'));
  }
  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function searchUsedCars(Request $request, $id)
  {
    //1710168298699
  }

  /**
   * Remove the specified resource from storage.
   *https://www.itsolutionstuff.com/post/jquery-select2-ajax-autocomplete-example-with-demo-in-phpexample.html
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */


  public function getMakes()
  {
    if (request()->ajax()) {
      $term     = request()->get('term');
      $makes    =  Make::select('id', 'title')->where('title', 'like', "%$term%")->get();
      $result = array();
      if (!$makes->isEmpty()) {
        foreach ($makes as $make) {
          $result[] = ['id' => $make->title, 'value' => $make->title, 'label' => $make->title];
        }
      }
    } else {
      $html = response('Forbidden.', 403);
    }
    return response()->json($result);
  }


  public function getModels()
  {

    if (request()->ajax()) {
      $result = array();
      $term     = request()->get('term');
      $models = Carmodel::select('id', 'name')->where('name', 'like', "%$term%")->get();
      if (!$models->isEmpty()) {
        foreach ($models as $model) {
          $result[] = ['id' => $model->name, 'value' => $model->name, 'label' => $model->name];
        }
      }
    } else {
      $html = response('Forbidden.', 403);
    }
    return response()->json($result);
  }

    public function getManufacturerTyre()
  {

    if (request()->ajax()) {
      $result = array();
      $term     = request()->get('term');
      $tyre_manufacturers = TyreManufacturer::select('id', 'title')->where('title', 'like', "%$term%")->get();
      if (!$tyre_manufacturers->isEmpty()) {
        foreach ($tyre_manufacturers as $tyre_manufacturer) {
          $result[] = ['id' => $tyre_manufacturer->title, 'value' => $tyre_manufacturer->title, 'label' => $tyre_manufacturer->title];
        }
      }
    } else {
      $html = response('Forbidden.', 403);
    }
    return response()->json($result);
  }

    public function getManufacturerRim()
  {

    if (request()->ajax()) {
      $result = array();
      $term     = request()->get('term');
      $rim_manufacturers = WheelManufacturer::select('id', 'title')->where('title', 'like', "%$term%")->get();
      if (!$rim_manufacturers->isEmpty()) {
        foreach ($rim_manufacturers as $rim_manufacturer) {
          $result[] = ['id' => $rim_manufacturer->title, 'value' => $rim_manufacturer->title, 'label' => $rim_manufacturer->title];
        }
      }
    } else {
      $html = response('Forbidden.', 403);
    }
    return response()->json($result);
  }


  public function getMakesVersions()
  {

    if (request()->ajax()) {
      $term     = request()->get('term');
      $makes    =  Make::select('id', 'title')->where('title', 'like', "%$term%")->where('status', 1)->get();
      $result = array();
      $versions = Make::select(
        DB::raw('CONCAT(title, " ", m.name) AS full_name'),
        'm.name',
        'm.id as model_id',
        'title',
        'make_id'
      )->join('models AS m', 'makes.id', '=', 'm.make_id')
        ->where(DB::raw('CONCAT(title, " ", m.name)'), 'like', "%$term%")->where('makes.status', 1)->get();
      if (!$makes->isEmpty()) {

        foreach ($makes as $make) {
          $result[] = ['id' => 'mk_' . $make->title, 'value' => $make->title, 'label' => $make->title];
        }
      }

      if (!$versions->isEmpty()) {
        foreach ($versions as $version) {
          $result[] = ['id' => 'mo_' . $version->name, 'value' => $version->full_name, 'label' => $version->full_name, 'make' => 'mk_' . $version->title];
        }
      }
    } else {
      $html = response('Forbidden.', 403);
    }
    return response()->json($result);
  }


  public function getAllCities($type)
  {

    if (request()->ajax()) {

      $term   = request()->get('q');
      $cities = City::select('id', 'name AS text')->where('name', 'like', "%$term%")->where('status', 1)->get();
      if (!$cities->isEmpty()) {
        foreach ($cities as $city) {
          $result[] = ['id' => $type . "_" . $city->text, 'text' => $city->text];
        }
      }
      return response()->json($result);
    }
  }

  public function getCities()
  {
    if (request()->ajax()) {

      $term   = request()->get('term');
      $cities = City::select('id', 'name')->where('name', 'like', "%$term%")->where('status', 1)->get();
      if (!$cities->isEmpty()) {
        foreach ($cities as $city) {
          $result[] = ['id' => $city->id, 'value' => $city->name, 'label' => $city->name];
        }
      }
      return response()->json($result);
    } else {
      return response('Forbidden.', 403);
    }
  }

  public function getTags()
  {
    if (request()->ajax()) {
      $html = '<option value="" selected="">Select Tags</option>';
      $tags = Tag::where('status', 1)->get();
      if (!$tags->isEmpty()) {
        foreach ($tags as $tag) {
          $html .= '<option value="tg_' . $tag->name . '"  >' . $tag->name . '</option>';
        }
      }
    } else {
      $html = response('Forbidden.', 403);
    }

    return $html;
  }

  public function getAllVersions()
  {
    if (request()->ajax()) {
      $response = response()->json(array());
      $term   = request()->get('q');
      $models = array();
      $versions = Version::select('id', 'label', 'cc', 'kilowatt')
        ->where('label', 'like', "%$term%")->get();
      if (!$versions->isEmpty()) {
        foreach ($versions as $version) {
          $models[] = array('id' => "ver_" . str_replace(" / ", "", $version->label), 'text' => $version->label . ' ' . $version->cc . " CC" . ' ' . $version->kilowatt . ' KW');
        }
      }

      return response()->json($models);
    }
  }

  public function getAllVersionsBy($term)
  {
    if (request()->ajax()) {
      $response     = response()->json(array());
      $term         = explode("_", $term);
      $ads_results  = Version::query()->distinct('versions.id')->groupBy('versions.id');
      $select_array = array('id', 'label', 'cc', 'kilowatt');
      $ads_results->join('models AS mo', 'mo.id', '=', 'versions.model_id');
      $filter       = $term[1];
      if ($term[0] == 'mk') {
        $ads_results->join('makes AS m', 'm.id', '=', 'mo.make_id');
        $ads_results->where('m.title', 'like', "%$filter%");
      }
      if ($term[0] == 'mo') {
        $ads_results->where('mo.name', 'like', "%$filter%");
      }
      $models   = array();
      $versions = $ads_results->get();
      $html = '<option value="">' . Lang::get('home.versions') . '</option> ';
      if (!$versions->isEmpty()) {
        foreach ($versions as $version) {
          $html .= '<option value="ver_' . str_replace(" / ", "!", $version->label) . "-" . $version->cc . "-CC-" . $version->kilowatt . '-KW' . '">' . $version->label . ' ' . $version->cc . " CC" . ' ' . $version->kilowatt . ' KW' . '</option>';
          /* $models[] = array('id'=>"ver_".$version->label,'text'=>$version->label.' '.$version->cc." cc".' '.$version->kilowatt.' KW');*/
        }
      }
      return $html;
    }
  }


  public function getAllColors()
  {

    if (request()->ajax()) {
      $response = response()->json(array());
      $term     = request()->get('q');
      $restut = array();
      $activeLanguage = \Session::get('language');
      //$colors   = Color::select('id','name AS text')->where('name', 'like', "%$term%")->get();
      $colorsQuery    = Color::query()->select("color_id", "cd.name as text");
      $colorsQuery->join('colors_description AS cd', 'colors.id', '=', 'cd.color_id')->where('language_id', $activeLanguage['id'])->where('colors.status', 1)->orderBy('cd.name', 'ASC');
      $colorsQuery->where('cd.name', 'like', "%$term%");
      $colors         = $colorsQuery->get();
      // dd($colors);
      if (!$colors->isEmpty()) {
        foreach ($colors as $color) {
          $restut[] = array('id' => 'cl_' . $color->text, 'text' => $color->text);
        }

        // dd($restut);
        $response = response()->json($restut);
      }
      return $response;
    }
  }


  public function getVersionsCC()
  {

    if (request()->ajax()) {
      $html = '';
      $versions   = Version::select('cc', 'id')->distinct('cc')->groupBy('cc')->get();
      /* 'strict' => false, id db file $logs = DB::table('versions')->select('cc','id')->groupBy('cc')->get();
              $versions = Version::selectRaw('distinct(cc), id')->groupBy('cc')->get();
*/
      if (!$versions->isEmpty()) {
        foreach ($versions as $version) {
          $html .= '<option value="' . $version->cc . '"  >' . $version->cc . ' CC</option>';
        }
      }
      return $html;
    }
  }


  public function getVersionsPOwer()
  {

    if (request()->ajax()) {
      $html = '';
      $versions   = Version::select('kilowatt', 'id')->distinct('kilowatt')->groupBy('kilowatt')->get();
      /* 'strict' => false, id db file $logs = DB::table('versions')->select('cc','id')->groupBy('cc')->get();
              $versions = Version::selectRaw('distinct(cc), id')->groupBy('cc')->get();
*/
      if (!$versions->isEmpty()) {
        foreach ($versions as $version) {
          $html .= '<option value="' . $version->kilowatt . '"  >' . $version->kilowatt . ' KW</option>';
        }
      }
      return $html;
    }
  }

  public function BodyTypes()
  {

    if (request()->ajax()) {
      $html = '';

      $activeLanguage = \Session::get('language');
      $bodyTypesQuery = BodyTypes::query()->select("body_type_id", "cd.name");
      $bodyTypesQuery->join('body_types_description AS cd', 'body_types.id', '=', 'cd.body_type_id')->where('status', 1)->where('language_id', $activeLanguage['id'])->orderBy('cd.name');
      $body_types      = $bodyTypesQuery->get();
      //$body_types   = BodyTypes::select('id','name')->get();
      if (!$body_types->isEmpty()) {
        foreach ($body_types as $body_type) {
          $html .= '<option value="bt_' . $body_type->name . '"  >' . $body_type->name . '</option>';
        }
      }
      return $html;
    }
  }

  public function simpleSearch($params)
  {
    // dd($params); 
    /* QUERY OF THE SEARCH */
    //DB::enableQueryLog();
    $GeneralSetting = session('GeneralSetting');
    $perpage_ads     = $GeneralSetting->perpage_ads;
    $activeLanguage  = \Session::get('language');
    $search_page_title =  Lang::get('header.carSearch');

    $ads_results     = Ad::query()->distinct('ads.id')->groupBy('ads.id');
    $select_array    = array(
      'ads.id', 'fuel_type', 'description', 'year', 'millage', 'fuel_average',
      'price', 'vat', 'neg', 'features', 'etd.title AS engine_title', 'gbd.title AS transmission_title', 'assembly',
      'doors', 'length', 'height', 'width', 'poster_name', 'poster_email', 'poster_phone',
      'is_featured', 'views', 'ads.status', 'maker_id', 'mo.id as model_id', 'version_id',
      'customer_id', 'm.title as make_name', 'mo.name as model_name',
      'v.label as version_label', 'v.cc', 'engine_capacity',
      'v.kilowatt AS engine_power',  'c.name as city_name', 'ads.updated_at AS last_updated', 'p.img'
    );
    $ads_results->leftJoin('makes AS m', 'm.id', '=', 'ads.maker_id');
    $ads_results->leftJoin('versions AS v', 'v.id', '=', 'ads.version_id');
    $ads_results->leftJoin('models AS mo', 'mo.id', '=', 'ads.model_id');
    $ads_results->leftJoin('cities AS c', 'c.id', '=', 'ads.poster_city');
    //$ads_results->leftJoin('engine_types_description AS etd','etd.engine_type_id','=','ads.fuel_type');

    $ads_results->leftJoin('engine_types_description AS etd', function ($join) use ($activeLanguage) {
      $join->on('etd.engine_type_id', '=', 'ads.fuel_type');
      $join->where('etd.language_id', '=', $activeLanguage['id']);
    });
    $ads_results->leftJoin('transmission_description AS gbd', function ($join) use ($activeLanguage) {
      $join->on('gbd.transmission_id', '=', 'ads.transmission_type');
      $join->where('gbd.language_id', '=', $activeLanguage['id']);
    });
    $ads_results->where('ads.status', 1)->where('m.status', 1);

    /*$ads_results->leftJoin('transmission_description AS gbd','gbd.transmission_id','=','ads.transmission_type');
      https://stackoverflow.com/questions/16848987/a-join-with-additional-conditions-using-query-builder-or-eloquent
      $ads_results->where('etd.language_id',$activeLanguage['id']);
      $ads_results->where('gbd.language_id',$activeLanguage['id']);*/

    //############ LANGUAGE BASED SEARCH TABLES #########################

    /* END */
    if ($params) {
      $quey_string_slug = array();
      $params_array = explode('/', $params);
      //do stuff 
      foreach ($params_array as $parm) {
        $new_array      = explode("_", $parm,2);
        $array_first    = head($new_array);
        $array_last     = last($new_array);
        $quey_string_slug[$array_first][] = $array_last;
      }
    }
    //print_r($quey_string_slug);
    $searched_keywords  = '';
    $query_string_array = array();
    $searchFilters      = array();
    $searchTables       = '';
    if (Arr::has($quey_string_slug, 'keyword')) {
      $keyword = $quey_string_slug['keyword'][0];
      $ads_results->where('m.title', 'LIKE', "%$keyword%");
      $ads_results->Orwhere('mo.name', 'LIKE', "%$keyword%");
    }
    if (Arr::has($quey_string_slug, 'isf')) {
      $featured = true;
      $ads_results->where('is_featured', $featured);
      $query_string_array['is_featured'] = " AND is_featured= '" . $featured . "' ";
      $searchFilters['isf_featured']     = Lang::get('findUsedCars.featuredAds');
      $search_page_title     = Lang::get('findUsedCars.featuredUsed');
    }
    if (Arr::has($quey_string_slug, 'mk')) {
      $ads_results->whereIn('m.title', $quey_string_slug['mk']);
      $list = "'" . implode("', '", $quey_string_slug['mk']) . "'";
      $query_string_array['makes'] = " AND m.title IN(" . $list . ")";
      $searchFilters['mk_' . $quey_string_slug['mk'][0]]      = $quey_string_slug['mk'][0];
    }
    if (Arr::has($quey_string_slug, 'mo')) {
      $ads_results->whereIn('mo.name', $quey_string_slug['mo']);
      $list = "'" . implode("', '", $quey_string_slug['mo']) . "'";
      $query_string_array['models'] = " AND mo.name IN(" . $list . ")";

      $searchFilters['mo_' . $quey_string_slug['mo'][0]] = $quey_string_slug['mo'][0];
    }
    /* YEAR */
    if (Arr::has($quey_string_slug, 'year')) {
      $year = explode('-', $quey_string_slug['year'][0]);
      if (count($year) == 1) {
        $ads_results->where('year', '>=', $year[0]);
        $query_string_array['year'] = " AND year >='" . $year[0] . "'";
      } else if (count($year) == 2 && $year[0] == "") {
        $ads_results->where('year', '<=', $year[1]);
        $query_string_array['year'] = " AND year <='" . $year[0] . "'";
      } else if (count($year) == 2 && $year[1] == "") {
        $ads_results->where('year', '>=', $year[0]);
        $query_string_array['year'] = " AND year >='" . $year[0] . "'";
      } else {
        $ads_results->whereBetween('year', [$year[0], $year[1]]);
        $query_string_array['year'] = " AND year BETWEEN '" . $year[0] . "' AND '" . $year[1] . "'";
      }

      $searchFilters['year_' . $quey_string_slug['year'][0]] = $quey_string_slug['year'][0];
    }
    if (Arr::has($quey_string_slug, 'price')) {

      $price = explode('-', $quey_string_slug['price'][0]);
      if (count($price) == 1) {
        $ads_results->where('price', '>=', $price[0]);
        $query_string_array['price'] = " AND price >='" . $price[0] . "'";
      } else if (count($price) == 2 && $price[0] == "") {
        $ads_results->where('price', '<=', $price[1]);
        $query_string_array['price'] = " AND price <='" . $price[0] . "'";
      } else if (count($price) == 2 && $price[1] == "") {
        $ads_results->where('price', '>=', $price[0]);
        $query_string_array['price'] = " AND price >='" . $price[0] . "'";
      } else {
        $ads_results->whereBetween('price', [$price[0], $price[1]]);
        $query_string_array['price'] = " AND price BETWEEN '" . $price[0] . "' AND '" . $price[1] . "'";
      }

      $searchFilters['price_' . $quey_string_slug['price'][0]] = $quey_string_slug['price'][0];
    }
    if (Arr::has($quey_string_slug, 'millage')) {
      $millage = explode('-', $quey_string_slug['millage'][0]);
      if (count($millage) == 1) {
        $ads_results->where('millage', '>=', $millage[0]);
        $query_string_array['millage'] = " AND millage >='" . $millage[0] . "'";
      } else if (count($millage) == 2 && $millage[0] == "") {
        $ads_results->where('millage', '<=', $millage[1]);
        $query_string_array['millage'] = " AND millage <='" . $millage[0] . "'";
      } else if (count($millage) == 2 && $millage[1] == "") {
        $ads_results->where('millage', '>=', $millage[0]);
        $query_string_array['millage'] = " AND millage >='" . $millage[0] . "'";
      } else {
        $ads_results->whereBetween('millage', [$millage[0], $millage[1]]);
        $query_string_array['millage'] = " AND millage BETWEEN '" . $millage[0] . "' AND '" . $millage[1] . "'";
      }

      $searchFilters['millage_' . $quey_string_slug['millage'][0]] = $quey_string_slug['millage'][0];
    }
    if (Arr::has($quey_string_slug, 'ver')) {
      $versions = array();
      foreach ($quey_string_slug['ver'] as $vers) {
        $versionArray = explode('-', $vers);
        $versions[]   = str_replace("!", " / ", trim($versionArray[0]));
        $enginecc[]   = trim($versionArray[1]);
        $power[]      = trim($versionArray[3]);
      }
      $enginecc                = array_filter($enginecc);
      $power                   = array_filter($power);
      $search_query            = $quey_string_slug['ver'];
      $quey_string_slug['ver'] = $versions;
      $ads_results->whereIn('v.label', $quey_string_slug['ver']);

      if (!empty($power)) {
        $ads_results->whereIn('v.cc', $power);
      }
      if (!empty($enginecc)) {
        $ads_results->whereIn('v.kilowatt', $enginecc);
      }
      $quey_string_slug['ver'] = $search_query;

      $searchFilters['ver_' . $quey_string_slug['ver'][0]] = $quey_string_slug['ver'][0];
    }
    if (Arr::has($quey_string_slug, 'power')) {
      $power = explode('-', $quey_string_slug['power'][0]);
      if (count($power) == 1) {
        $ads_results->where('v.kilowatt', '>=', $power[0]);
        $query_string_array['power'] = " AND v.kilowatt >='" . $power[0] . "'";
      } else if (count($power) == 2 && $power[0] == "") {
        $ads_results->where('v.kilowatt', '<=', $power[1]);
        $query_string_array['power'] = " AND v.kilowatt <='" . $power[0] . "'";
      } else if (count($power) == 2 && $power[1] == "") {
        $ads_results->where('v.kilowatt', '>=', $power[0]);
        $query_string_array['power'] = " AND v.kilowatt >='" . $power[0] . "'";
      } else {
        $ads_results->whereBetween('v.kilowatt', [$power[0], $power[1]]);
        $query_string_array['power'] = " AND v.kilowatt BETWEEN '" . $power[0] . "' AND '" . $power[1] . "'";
      }

      $searchFilters['power_' . $quey_string_slug['power'][0]] = $quey_string_slug['power'][0];
    }
    if (Arr::has($quey_string_slug, 'enginecc')) {
      $enginecc = explode('-', $quey_string_slug['enginecc'][0]);
      if (count($enginecc) == 1) {
        $ads_results->where('v.cc', '>=', $enginecc[0]);
        $query_string_array['enginecc'] = " AND v.cc >='" . $enginecc[0] . "'";
      } else if (count($enginecc) == 2 && $enginecc[0] == "") {
        $ads_results->where('v.cc', '<=', $enginecc[1]);
        $query_string_array['enginecc'] = " AND v.cc <='" . $enginecc[0] . "'";
      } else if (count($enginecc) == 2 && $enginecc[1] == "") {
        $ads_results->where('v.cc', '>=', $enginecc[0]);
        $query_string_array['enginecc'] = " AND v.cc >='" . $enginecc[0] . "'";
      } else {
        $ads_results->whereBetween('v.cc', [$enginecc[0], $enginecc[1]]);
        $query_string_array['enginecc'] = " AND v.cc BETWEEN '" . $enginecc[0] . "' AND '" . $enginecc[1] . "'";
      }

      $searchFilters['enginecc_' . $quey_string_slug['enginecc'][0]] = $quey_string_slug['enginecc'][0];
    }
    if (Arr::has($quey_string_slug, 'fuel')) {
      /* $ads_results->whereIn('fuel_type',$quey_string_slug['fuel']);
            $list = "'". implode("', '", $quey_string_slug['fuel']) ."'";
            $query_string_array['fuel'] = " AND fuel_type IN(".$list.")";

            $searchFilters['fuel_'.$quey_string_slug['fuel'][0]] = 'Engine Type '.$quey_string_slug['fuel'][0];*/


      $ads_results->whereIn('etd.title', $quey_string_slug['fuel']);
      $list = "'" . implode("', '", $quey_string_slug['fuel']) . "'";
      $query_string_array['fuel'] = " AND etd.title IN(" . $list . ") ";
      $searchFilters['fuel_' . $quey_string_slug['fuel'][0]] = $quey_string_slug['fuel'][0];
      $searchTables      .= ' INNER JOIN engine_types_description etd ON etd.engine_type_id=a.fuel_type ';
      $searchFuel = '';
      $fuelWhere  = ' AND etd.language_id=' . $activeLanguage['id'];
    } 
    else {
      $searchFuel = ' INNER JOIN engine_types_description etd ON etd.engine_type_id=a.fuel_type ';
      $fuelWhere  = ' AND etd.language_id=' . $activeLanguage['id'];
    }

    if (Arr::has($quey_string_slug, 'transmission')) {
      /*$ads_results->whereIn('transmission_type',$quey_string_slug['transmission']);
          $list = "'". implode("', '", $quey_string_slug['transmission']) ."'";
          $query_string_array['transmission'] = " AND transmission_type IN(".$list.")";
          $searchFilters['transmission_'.$quey_string_slug['transmission'][0]] = 'Transmission '.$quey_string_slug['transmission'][0];*/


      $ads_results->whereIn('gbd.title', $quey_string_slug['transmission']);
      $list = "'" . implode("', '", $quey_string_slug['transmission']) . "'";
      $query_string_array['transmission'] = " AND gbd.title IN(" . $list . ") ";
      $searchFilters['transmission_' . $quey_string_slug['transmission'][0]] = $quey_string_slug['transmission'][0];
      $searchTables .= ' INNER JOIN transmission_description AS gbd ON gbd.transmission_id=a.transmission_type ';

      $searchTransmission = '';
      $transmissionWhere = ' AND gbd.language_id=' . $activeLanguage['id'];
    } 
    else {
      $searchTransmission = ' INNER JOIN transmission_description AS gbd ON gbd.transmission_id=a.transmission_type ';
      $transmissionWhere = ' AND gbd.language_id=' . $activeLanguage['id'];
    }

    if (Arr::has($quey_string_slug, 'cl')) {
      $select_array[] = 'cld.name as color_name';
      $select_array[] = 'cld.color_id';
      $ads_results->leftJoin('colors_description AS cld', 'cld.color_id', '=', 'ads.color_id');
      $ads_results->whereIn('cld.name', $quey_string_slug['cl']);
      $list = "'" . implode("', '", $quey_string_slug['cl']) . "'";
      $query_string_array['colors'] = " AND cld.name IN(" . $list . ")";
      $searchFilters['cl_' . $quey_string_slug['cl'][0]] = $quey_string_slug['cl'][0];
      $searchTables .= ' INNER JOIN colors_description AS cld ON cld.color_id=a.color_id ';
      $searchColor = '';
      $colorWhere = ' AND cld.language_id=' . $activeLanguage['id'];
    } 
    else {
      $searchColor = ' INNER JOIN colors_description AS cld ON cld.color_id=a.color_id ';
      $colorWhere = ' AND cld.language_id=' . $activeLanguage['id'];
    }

    if (Arr::has($quey_string_slug, 'bt')) {
      $ads_results->leftJoin('body_types_description AS btd', 'btd.body_type_id', '=', 'ads.body_type_id');

      $ads_results->whereIn('btd.name', $quey_string_slug['bt']);
      $list = "'" . implode("', '", $quey_string_slug['bt']) . "'";
      $query_string_array['bodyTypes'] = " AND btd.name IN(" . $list . ")";

      $searchFilters['bt_' . $quey_string_slug['bt'][0]] = $quey_string_slug['bt'][0];
      $searchTables .= ' INNER JOIN body_types_description AS btd   ON btd.body_type_id=a.body_type_id ';
      $searchBodyType = '';
      $bodyTypeWhere = ' AND btd.language_id=' . $activeLanguage['id'];
    } 
    else {
      $searchBodyType = ' INNER JOIN body_types_description AS btd   ON btd.body_type_id=a.body_type_id ';
      $bodyTypeWhere = ' AND btd.language_id=' . $activeLanguage['id'];
    }

    if (Arr::has($quey_string_slug, 'ct')) {
      $ads_results->whereIn('c.name', $quey_string_slug['ct']);
      $cities = City::whereIn('c.name', $quey_string_slug['ct'])->where('status', 1);
      $list = "'" . implode("', '", $quey_string_slug['ct']) . "'";
      $query_string_array['cities'] = " AND c.name IN(" . $list . ")";
      $searchFilters['ct_' . $quey_string_slug['ct'][0]] = $quey_string_slug['ct'][0];
      $searchTables .= ' INNER JOIN cities c ON c.id=a.poster_city ';
      /*if(isset($_REQUEST['testing'])){
            print_r($ads_results->toSql());
            echo '<br>';
            print_r($ads_results->getBindings());
            echo '<br>';
            $query = DB::getQueryLog();
            $query = end($query);
            dd($query); 
          }*/
      $searchCity = '';
    } 
    else {
      $searchCity = ' INNER JOIN cities c ON c.id=a.poster_city ';
    }

    /*if (Arr::has($quey_string_slug, 'cy')) {      
      $ads_results->leftJoin('countries_description AS cy','cy.country_id','=','ads.country_id');
      $ads_results->whereIn('cy.title', $quey_string_slug['cy']); 
      $list = "'" . implode("', '", $quey_string_slug['cy']) . "'";
      $query_string_array['countries'] = " AND cy.title IN(" . $list . ")";
      $searchFilters['cy_'.$quey_string_slug['cy'][0]] = 'Bought From '.$quey_string_slug['cy'][0];
      $searchTables .= ' INNER JOIN countries_description AS cy ON cy.country_id=a.country_id ';
      $searchCountry = '';
      
      $countryWhere  = " AND cy.language_id=".$activeLanguage['id'];
    } else{
      $searchCountry = ' INNER JOIN countries_description AS cy   ON cy.country_id=a.country_id ';
      $countryWhere  = " AND cy.language_id=".$activeLanguage['id'];
    }*/

    if (Arr::has($quey_string_slug, 'ctreg')) {
      $cities = City::whereIn('c.name', $quey_string_slug['ctreg'])->where('status', 1);
      $list   = "'" . implode("', '", $quey_string_slug['ctreg']) . "'";
      $query_string_array['cities'] = " AND c.name IN(" . $list . ")";
    }
    if (Arr::has($quey_string_slug, 'ec')) {
      $colors = Color::whereIn('name', $quey_string_slug['ec']);
    }

    if (Arr::has($quey_string_slug, 'seller')) {
      $ads_results->join('customers AS cr', 'ads.customer_id', '=', 'cr.id');
      $ads_results->where('cr.customer_role', '=', $quey_string_slug['seller']);
      $searchFilters['seller_' . $quey_string_slug['seller'][0]] = ucfirst($quey_string_slug['seller'][0]);
    }

    if (Arr::has($quey_string_slug, 'pic')) {
      $ads_results->join('ad_images AS p', 'p.ad_id', '=', 'ads.id');
      $searchFilters['pic_' . $quey_string_slug['pic'][0]] = $quey_string_slug['pic'][0];
    } 
    else {
      $ads_results->leftJoin('ad_images AS p', 'p.ad_id', '=', 'ads.id');
    }

    if (Arr::has($quey_string_slug, 'tg')) {
      $ads_results->with('tags');
      $ads_results->leftJoin('ad_tag AS as', 'ads.id', '=', 'as.ad_id');
      $ads_results->leftJoin('tags AS s', 's.id', '=', 'as.tag_id');
      $ads_results->whereIn('s.id', $quey_string_slug['tg']);
      $ads_results->havingRaw('COUNT(DISTINCT as.tag_id)=' . count($quey_string_slug['tg']));

      $tagsQuery   = Tag::query()->select("id", "cd.name");
      $tagsQuery->join('tag_description AS cd', 'tags.id', '=', 'cd.tag_id')->where('language_id', $activeLanguage['id'])->whereIn('tags.id', $quey_string_slug['tg']);
      $tags        = $tagsQuery->get();
      foreach ($tags as $tag) {
        $searchFilters['tg_' . $tag->id] = $tag->name;
      }
    }

    $tagsQuery   = Tag::query()->select("id", "cd.name")->where('status', 1);
    $tagsQuery->join('tag_description AS cd', 'tags.id', '=', 'cd.tag_id')->where('language_id', $activeLanguage['id']);
    $tags        = $tagsQuery->get();


    $sortBy = '';
    if (Arr::has($quey_string_slug, 'sortby')) {
      $sortBy = $quey_string_slug['sortby'][0];
      $ads_results->orderByRaw('ads.' . $sortBy);
    }
    else{
      $ads_results->orderByRaw('ads.' . 'is_featured,ads.updated_at DESC'); 
    }

    $ads_results->select($select_array);
    $search_result  = $ads_results->paginate($perpage_ads);
    $side_bar_array = array();
    $ads_status     = " AND a.status=1 ";
    #################### MAKES ####################################
    $whereCondition = "SELECT count(m.id) as total_ads_in_makes,m.id,m.title 
      FROM ads a
      INNER JOIN makes    AS   m    ON m.id=a.maker_id
      INNER JOIN versions AS   v    ON v.id=a.version_id  
      INNER JOIN models   AS   mo   ON mo.id=a.model_id " . $searchTables;
    $whereCondition .= $this->createWhereCondtion($query_string_array, 'makes1');
    $whereCondition .= $ads_status . " GROUP BY m.id";
    $side_bar_array['makes'] = $this->getSelect($whereCondition);
    if (isset($_REQUEST['test'])) {

      echo $whereCondition . '<pre>';
      print_r($side_bar_array);
      exit;
    }
    #################### MODEL ####################################
    $whereCondition = "SELECT count(mo.id) as total_ads_in_models,mo.id,mo.name 
      FROM ads a
      INNER JOIN makes      AS   m  ON m.id=a.maker_id  
      INNER JOIN versions   AS   v  ON v.id=a.version_id  
      INNER JOIN models     AS   mo ON mo.id=a.model_id " . $searchTables;
    $whereCondition .= $this->createWhereCondtion($query_string_array, 'models1');
    $whereCondition .= $ads_status . " GROUP BY mo.id";
    $side_bar_array['models'] = $this->getSelect($whereCondition);


    #################### COLORS COUNT ##############################
    $whereCondition = "SELECT count(cld.color_id) as total_ads_in_color,cld.color_id,cld.name FROM ads a     
        INNER JOIN makes AS m ON m.id=a.maker_id 
        INNER JOIN versions AS v ON v.id=a.version_id 
        INNER JOIN models AS mo ON mo.id=a.model_id " . $searchTables . $searchColor;
    $whereCondition .= $this->createWhereCondtion($query_string_array, 'colors1');
    $whereCondition .= $ads_status . $colorWhere . " GROUP BY cld.color_id";
    $side_bar_array['colors'] = $this->getSelect($whereCondition);

    #################### BODY TYPES COUNT ############################## 
    $whereCondition = "SELECT count(btd.body_type_id) as total_ads_in_body, btd.body_type_id,btd.name FROM ads a  
      INNER JOIN makes AS m ON m.id=a.maker_id 
      INNER JOIN versions AS v ON v.id=a.version_id  
      INNER JOIN models AS mo ON mo.id=a.model_id " . $searchTables . $searchBodyType;
    $whereCondition .= $this->createWhereCondtion($query_string_array, 'bodyTypes1');
    $whereCondition .= $ads_status . $bodyTypeWhere . " GROUP BY btd.body_type_id";
    $side_bar_array['bodyTypes'] = $this->getSelect($whereCondition);

    #################### COUNTRIES COUNT ##############################
    /*$whereCondition = "SELECT count(cy.country_id) as total_ads_in_countries,cy.country_id,cy.title FROM ads a  
      INNER JOIN makes AS m ON m.id=a.maker_id 
      INNER JOIN versions AS v ON v.id=a.version_id 
      INNER JOIN models AS mo ON mo.id=a.model_id ".$searchTables.$searchCountry;
    $whereCondition .= $this->createWhereCondtion($query_string_array, 'countries');
    $whereCondition .= $ads_status.$countryWhere." GROUP BY cy.country_id"; 
    $side_bar_array['countries'] = $this->getSelect($whereCondition); */

    #################### CITIES LOCATIONS COUNT ##########################
    $whereCondition = "SELECT count(c.id) as total_ads_in_cities,c.id,c.name FROM ads a  
      INNER JOIN makes AS m ON m.id=a.maker_id 
      INNER JOIN versions AS v ON v.id=a.version_id 
      INNER JOIN models AS mo ON mo.id=a.model_id " . $searchTables . $searchCity;
    $whereCondition .= $this->createWhereCondtion($query_string_array, 'cities1');
    $whereCondition .= $ads_status . " GROUP BY c.id";

    $side_bar_array['locations'] = $this->getSelect($whereCondition);

    #################### TRANSMISSION COUNT ############################## 
    $whereCondition = "SELECT count(gbd.transmission_id) as total_ads_in_transmission,gbd.transmission_id,gbd.title FROM ads a   
      INNER JOIN makes    AS m ON m.id=a.maker_id 
      INNER JOIN versions AS v ON v.id=a.version_id 
      INNER JOIN models   AS mo ON mo.id=a.model_id " . $searchTables . $searchTransmission;
    $whereCondition .= $this->createWhereCondtion($query_string_array, 'transmission1');
    $whereCondition .= $ads_status . $transmissionWhere . " GROUP BY gbd.transmission_id";
    $side_bar_array['transmission'] = $this->getSelect($whereCondition);
    #################### FUEL TYPE COUNT ############################## 

    $whereCondition = "SELECT count(etd.engine_type_id) as total_ads_in_fuel,etd.engine_type_id,etd.title FROM ads a  
      INNER JOIN makes AS m ON m.id=a.maker_id 
      INNER JOIN versions AS v ON v.id=a.version_id 
      INNER JOIN models AS mo ON mo.id=a.model_id " . $searchTables . $searchFuel;
    $whereCondition .= $this->createWhereCondtion($query_string_array, 'fuel1');
    $whereCondition .= $ads_status . $fuelWhere . " GROUP BY etd.engine_type_id";
    $side_bar_array['fuel'] = $this->getSelect($whereCondition);
    foreach ($quey_string_slug as $keys => $values) {
      foreach ($values as $data) {
        $new_string    = $params;
        $link          = str_replace($keys . '_' . $data . '/', '', $new_string);
        $link          = str_replace('/' . $keys . '_' . $data, '', $link);
        if ($data == 'list') continue;

        if (isset($searchFilters[$keys . '_' . $data]) && !empty($searchFilters[$keys . '_' . $data])) {
          $data          = $searchFilters[$keys . '_' . $data];
        }

        if(count($quey_string_slug) > 1)
        {
            $searched_keywords .= '<li class="align-items-center d-flex justify-content-between">' . $data . '<a href="' . url('/') . '/find-used-cars/' . $link . '" class="sortBy"> <span class="fa fa-close themecolor2"></a></span></li>';
        }else{
            $searched_keywords .= '<li class="align-items-center d-flex justify-content-between">' . $data . '<a href="' . route('simple.search') . '/' . 'used-car-for-sale' . '" class="sortBy"> <span class="fa fa-close themecolor2"></a></span></li>';
        }
        
      }
    }
    /*$sortBy = '';
    if (!empty(request()->get('sortby'))) {
      $sortBy = request()->get('sortby');
    }*/
    // dd($sortBy);
    return view('guest.search_listing', compact('sortBy', 'search_result', 'searched_keywords', 'side_bar_array', 'quey_string_slug', 'tags','search_page_title'));
  }
  //
  public function simpleSearch1($params)
  {

    if ($params) {
      $quey_string_slug = array();
      $params = explode('/', $params);
      //do stuff 
      foreach ($params as $parm) {
        $new_array      = explode("_", $parm);
        $array_first    = head($new_array);
        $array_last     = last($new_array);
        $quey_string_slug[$array_first][] = $array_last;
      }
    }
    dd($quey_string_slug);

    $request        = request();
    $search_string  = $request->all();
    $query_string = '?search=true';
    $query_string_array = array();
    $searched_keywords_array  = array();
    //DB::enableQueryLog();
    $ads_results    = Ad::query();
    $select_array = array(
      'fuel_type', 'description', 'year', 'millage', 'fuel_average',
      'price', 'vat', 'neg', 'features', 'transmission_type', 'assembly',
      'doors', 'length', 'height', 'width', 'poster_name', 'poster_email', 'poster_phone',
      'is_featured', 'views', 'status', 'maker_id', 'mo.id as model_id', 'version_id',
      'customer_id',
      'm.title as make_name', 'mo.name as model_name', 'color_id', 'cld.name as color_name',
      'v.label as version_label', 'v.cc as engine_capacity', 'v.kilowatt AS engine_power', 'c.name as city_name', DB::raw('DATE_FORMAT(current_date(), "%d-%m-%Y") - DATE_FORMAT(ads.updated_at, "%d-%m-%Y") as last_updated')
    );

    $ads_results->select($select_array);
    $ads_results->join('makes AS m', 'm.id', '=', 'ads.maker_id');
    $ads_results->join('versions AS v', 'v.id', '=', 'ads.version_id');
    $ads_results->join('cities AS c', 'c.id', '=', 'ads.city_id');
    $ads_results->join('models AS mo', 'mo.id', '=', 'ads.model_id');
    $ads_results->join('colors AS cl', 'cl.id', '=', 'ads.color_id');
    $ads_results->where('status', '0');
    $where = ' 1 ';
    /* if ($request->filled('q')) { 
            $like_search = $search_string['q']; 
            $ads_results->where(DB::raw('mo.name LIKE %'.$like_search.'%  OR m.title LIKE  %'.$like_search.'% '));
            //$ads_results->orWhere('mo.name', 'like', '%'.$like_search.'%'); 
            $query_string .= '&q='.$like_search; 
            $searched_keywords_array['q'] = $like_search;            
            $query_string_array['q'] = " AND (m.title = '".$like_search."' OR mo.name = '".$like_search."')";
        }*/
    if ($request->filled('car_make_model')) {
      $car_make_model = $search_string['car_make_model'];
      $makes_array    = explode('-', $car_make_model);
      $query_string .= '&car_make_model=' . $car_make_model;
      $searched_keywords_array['car_make_model'] = $car_make_model;
      $array_first    = head($makes_array);
      $array_last     = last($makes_array);
      if ($array_first == 'makes') {
        $ads_results->where('m.title', $array_last);
        $query_string_array['car_make_model'] = " AND m.title = '" . $array_last . "'";
      } else {
        $ads_results->where('mo.name', $array_last);
        $query_string_array['car_make_model'] = " AND mo.name = '" . $array_last . "'";
      }
    }

    if ($request->filled('selectCity1')) {
      $selectCity1 = $search_string['selectCity1'];
      $ads_results->whereIn('c.name', array($selectCity1));
      $query_string .= '&selectCity1=' . $selectCity1;
      $query_string_array['selectCity1'] = " AND c.name IN('" . $selectCity1 . "')";
      $searched_keywords_array['selectCity1'] = $selectCity1;
    }

    if ($request->filled('tags')) {
      $tags = implode(',', $search_string['tags']);
      $where .= "AND tags = '" . $tags . "' ";
      $query_string .= '&tags=' . $tags;
      $query_string_array['tags'] = " AND tags = '" . $array_last . "'";
      $searched_keywords_array['selectCity1'] = $tags;
    }
    if ($request->filled('selectCity')) {
      $selectCity = $search_string['selectCity'];
      $ads_results->whereIn('c.name', array($selectCity));
      $query_string .= '&selectCity=' . $selectCity;
      $query_string_array['selectCity'] =  " AND c.name IN('" . $selectCity . "')";
      $searched_keywords_array['selectCity'] = $selectCity;
    }

    if ($request->filled('minPrice') && $request->filled('maxPrice')) {
      $ads_results->whereBetween('price', [$search_string['minPrice'], $search_string['maxPrice']]);
      $query_string_array['minPrice'] =  " AND price > '" . $search_string['minPrice'] . "' ";
      $query_string_array['maxPrice'] =  " AND price < '" . $search_string['maxPrice'] . "' ";
      $searched_keywords_array['minPrice'] = $minPrice;
      $searched_keywords_array['maxPrice'] = $maxPrice;
    } // ENDIF
    else {
      if ($request->filled('minPrice')) {
        $minPrice = $search_string['minPrice'];
        $ads_results->where('price', $minPrice);
        $query_string .= '&minPrice=' . $minPrice;
        $query_string_array['minPrice'] = " AND price = '" . $minPrice . "'";
        $searched_keywords_array['minPrice'] = $minPrice;
      }
      if ($request->filled('maxPrice')) {
        $maxPrice = $search_string['maxPrice'];
        $ads_results->where('price', $maxPrice);
        $query_string .= '&maxPrice=' . $maxPrice;
        $query_string_array['maxPrice'] =  " AND price = '" . $maxPrice . "'";
        $searched_keywords_array['maxPrice'] = $maxPrice;
      }
    } // END ELSE

    if ($request->filled('selectCityArea')) {
      $selectCityArea = $search_string['selectCityArea'];
      $query_string .= '&selectCityArea=' . $selectCityArea;
      $query_string_array['selectCityArea'] = $selectCityArea;
      $where .=  " AND c.name IN('" . $selectCityArea . "')";
      $searched_keywords_array['selectCityArea'] = $selectCityArea;
    }
    if ($request->filled('selectVersion')) {
      $selectVersion = $search_string['selectVersion'];
      $where .= "AND selectVersion = '" . $selectVersion . "' ";
      $ads_results->where('v.id', $selectVersion);
      $query_string .= '&selectVersion=' . $selectVersion;
      $query_string_array['selectVersion'] = " AND v.id = '" . $selectVersion . "'";
    }

    if ($request->filled('selectYearFrom') && $request->filled('selectYearTo')) {
      $ads_results->whereBetween('year', [$search_string['selectYearFrom'], $search_string['selectYearTo']]);

      $query_string .= '&selectYearFrom=' . $search_string['selectYearFrom'] . '&selectYearTo=' . $search_string['selectYearTo'];
      $query_string_array['selectYearFrom'] = "AND year >= '" . $search_string['selectYearTo'] . "' ";
      $query_string_array['selectYearTo']   =   " AND year <= '" . $search_string['selectYearFrom'] . "'";
    } // ENDIF

    else {
      if ($request->filled('selectYearFrom')) {
        $selectYearFrom = $search_string['selectYearFrom'];
        $ads_results->where('year', $selectYearFrom);
        $query_string .= '&selectYearFrom=' . $selectYearFrom;
        $query_string_array['selectYearFrom']   =  " AND year = '" . $selectYearFrom . "'";
      }
      if ($request->filled('selectYearTo')) {
        $selectYearTo = $search_string['selectYearTo'];
        $ads_results->where('year', $selectYearTo);
        $query_string .= '&selectYearTo=' . $selectYearTo;
        $query_string_array['selectYearTo']   = " AND year = '" . $selectYearTo . "'";
      }
    } // END ELSE

    if ($request->filled('engine_type')) {
      $fuel_type = $search_string['engine_type'];
      $ads_results->where('fuel_type', $fuel_type);
      $query_string .= '&fuel_type=' . $fuel_type;
      $query_string_array['engine_type']   =  " AND fuel_type = '" . $fuel_type . "'";
    }

    if ($request->filled('CapacityFrom') && $request->filled('CapacityTo')) {
      $ads_results->whereBetween('fuel_average', [$search_string['CapacityFrom'], $search_string['CapacityTo']]);
      $query_string .= '&CapacityFrom=' . $request->filled('CapacityFrom') . '&CapacityTo=' . $request->filled('CapacityTo');
      $query_string_array['CapacityFrom'] =  " AND fuel_average >= '" . $search_string['CapacityTo'] . "'";
      $query_string_array['CapacityTo']   =  " AND fuel_average <= '" . $search_string['CapacityFrom'] . "'";
    } // ENDIF

    else {
      if ($request->filled('CapacityFrom')) {
        $CapacityFrom = $search_string['CapacityFrom'];
        $ads_results->where('fuel_average', $CapacityFrom);
        $query_string .= '&CapacityFrom=' . $CapacityFrom;
        $query_string_array['CapacityFrom']   = " AND fuel_average = '" . $CapacityTo . "' ";
        " AND fuel_average = '" . $CapacityFrom . "' ";
      }
      if ($request->filled('CapacityTo')) {
        $CapacityTo = $search_string['CapacityTo'];
        $ads_results->where('fuel_average', $CapacityTo);
        $query_string .= '&CapacityTo=' . $CapacityTo;
        $query_string_array['CapacityTo']   = " AND fuel_average = '" . $CapacityTo . "' ";
      }
    } // END ELSE

    if ($request->filled('MileageFrom') && $request->filled('MileageTo')) {
      $ads_results->whereBetween('millage', [$search_string['MileageFrom'], $search_string['MileageTo']]);

      $query_string .= '&MileageFrom=' . $request->filled('MileageFrom') . '&MileageTo=' . $request->filled('MileageTo');
      $query_string_array['MileageFrom']   = " AND millage >= '" . $search_string['MileageFrom'] . "'";

      $query_string_array['MileageTo']   =  "AND millage <=  '" . $search_string['MileageTo'] . "'";
    } // ENDIF

    else {
      if ($request->filled('MileageFrom')) {
        $MileageFrom = $search_string['MileageFrom'];
        $ads_results->where('millage', $MileageFrom);
        $query_string .= '&MileageFrom=' . $MileageFrom;
        $query_string_array['MileageFrom']   =   " AND millage = '" . $MileageFrom . "' ";
      }
      if ($request->filled('MileageTo')) {
        $MileageTo = $search_string['MileageTo'];
        $ads_results->where('millage', $MileageTo);
        $query_string .= '&MileageTo=' . $MileageTo;
        $query_string_array['MileageTo']   =   " AND millage = '" . $MileageTo . "' ";
      }
    } // END ELSE

    if ($request->filled('body_type')) {
      $body_type    = $search_string['body_type'];
      $btype = '';
      foreach ($body_type as $bt) {
        if ($btype != '')
          $btype .= ',';
        $btype .= "'$bt'";
      }

      $ads_results->whereIn('b.name', $body_type);
      $query_string .= '&body_type=' . implode(',', $body_type);
      $query_string_array['body_type']  = " AND b.name IN('" . implode(',', $body_type) . "') ";
      $searched_keywords_array['body_type'] = $body_type;
    }

    if ($request->filled('color')) {
      $color = $search_string['color'];
      dd($color);
      $ads_results->whereIn('cld.name', [$color]);
      $query_string .= '&color=' . $color;
      $query_string_array['color']  =  " AND cld.name IN('" . $color . "') ";
      $searched_keywords_array['color'] = $color;
    }

    if ($request->filled('have_picture')) {
      $have_picture = $search_string['have_picture'];
      $query_string .= '&have_picture=' . $have_picture;
      $query_string_array['have_picture'] = " AND have_picture = '" . $have_picture . "' ";
    }

    if ($request->filled('ads_type')) {
      $ads_type = $search_string['ads_type'];
      $query_string .= '&ads_type=' . $ads_type;
      $query_string_array['ads_type']   = " AND ads_type = '" . $ads_type . "' ";
    }

    if ($request->filled('is_featured')) {
      $is_featured = $search_string['is_featured'];
      $ads_results->where('is_featured', $is_featured);
      $query_string .= '&is_featured=' . $is_featured;
      $query_string_array['is_featured']   = " AND is_featured = '" . $is_featured . "' ";
    }

    if ($request->filled('RegCity')) {
      $RegCity = $search_string['RegCity'];
      $ads_results->where('poster_city', $RegCity);
      $query_string .= '&RegCity=' . $RegCity;
      $query_string_array['RegCity']   = " AND poster_city = '" . $RegCity . "' ";
    }

    if ($request->filled('assembly')) {
      $assembly = $search_string['assembly'];
      $ads_results->where('assembly', $assembly);
      $query_string .= '&assembly=' . $assembly;
      $query_string_array['assembly']   =  " AND assembly = '" . $assembly . "' ";
    }

    if ($request->filled('transmission')) {
      $transmission = $search_string['transmission'];
      $ads_results->where('transmission_type', $transmission);
      $query_string .= '&transmission=' . $transmission;
      $query_string_array['transmission']   = " AND transmission_type = '" . $transmission . "' ";
    }

    //$ads_results->paginate(2);
    /*$query = DB::getQueryLog();
      $result = $ads_results->toSql();
      echo $result;exit;*/

    $searched_keywords = '';
    foreach ($searched_keywords_array as $keys => $values) {
      $new_string    = $query_string;
      $link = str_replace('&' . $keys . '=' . $values, '', $new_string);
      $searched_keywords .= '<li class="align-items-center d-flex justify-content-between"><a  href="' . $link . '">' . $values . '</a> <span class="fa fa-close themecolor2"></span></li>';
    }

    $search_result = $ads_results->paginate(20);
    $side_bar_array = array();
    #################### MAKES ####################################
    $whereCondition = "SELECT count(m.id) as total_ads_in_makes,m.id,m.title 
      FROM ads a
      INNER JOIN makes    AS m  ON m.id=a.maker_id
      INNER JOIN colors   AS cl ON cl.id=a.color_id  
      INNER JOIN versions AS v  ON v.id=a.version_id 
      INNER JOIN cities   AS c  ON c.id=a.city_id
      INNER JOIN models   AS mo ON mo.id=a.model_id";
    $whereCondition .= $this->createWhereCondtion($query_string_array, 'makes');

    $whereCondition .= " GROUP BY m.id";
    $side_bar_array['makes'] = $this->getSelect($whereCondition);

    #################### COLORS COUNT ##############################
    $whereCondition = "SELECT count(cl.id) as total_ads_in_color,cl.id,cl.name FROM ads a INNER JOIN colors cl ON cl.id=a.color_id  
        INNER JOIN makes AS m ON m.id=a.maker_id 
        INNER JOIN versions AS v
        ON v.id=a.version_id 
        INNER JOIN cities AS c ON c.id=a.city_id
        INNER JOIN models AS mo ON mo.id=a.model_id ";
    $whereCondition .= $this->createWhereCondtion($query_string_array, 'color');

    $whereCondition .= " GROUP BY cl.id";
    $side_bar_array['colors'] = $this->getSelect($whereCondition);
    #################### BODY TYPES COUNT ############################## 
    $whereCondition = "SELECT count(b.id) as total_ads_in_body, b.id,b.name FROM ads a INNER JOIN body_types b ON b.id=a.body_type_id 
      INNER JOIN colors cl ON cl.id=a.color_id 
        INNER JOIN makes AS m ON m.id=a.maker_id INNER JOIN versions AS v
         ON v.id=a.version_id INNER JOIN cities AS c ON c.id=a.city_id
         INNER JOIN models AS mo ON mo.id=a.model_id ";
    $whereCondition .= $this->createWhereCondtion($query_string_array, 'body_type');

    $whereCondition .= " GROUP BY b.id";
    $side_bar_array['bodyTypes'] = $this->getSelect($whereCondition);
    #################### BODY TYPES COUNT ##############################

    return view('guest.search_listing', compact('search_result', 'searched_keywords', 'side_bar_array'));
  }
  //100 gm mete 100 gm kalwange mix , 5 drops zaton,shehid 
  //5 karjoor , 5 badaam , 1/2 = white till
  //https://phppot.com/jquery/jquery-ajax-autocomplete-country-example/
  private function createWhereCondtion($query_string_array, $skipKey)
  {
    $where = 'WHERE 1  ';
    unset($query_string_array[$skipKey]);
    foreach ($query_string_array as $keys => $queryStr) {
      $where .= $queryStr;
    }
    return $where;
  }


  private function getSelect($where)
  {
    return DB::select(DB::raw($where));
  }

  public function servicesSubCategorySearch($p_id, $c_id, $sub_id)
  {
    $services = Services::select('customer_id')->where('primary_service_id', $p_id)
      ->whereHas('service_details', function ($query) use ($c_id, $sub_id) {
        $query->where('category_id', $c_id)->where('sub_category_id', $sub_id);
      })->get();

    $customer_ids = $services->unique('customer_id');
    $category     = PrimaryService::where('id', $p_id)->first();
    $cat          = SubService::where('id', $c_id)->first();
    if ($cat->is_make == 1) {
      $sub = Make::where('id', $sub_id)->first();
    } else {
      $sub = SubService::where('id', $sub_id)->first();
    }

    return view('guest.service_sub_category', compact('customer_ids', 'id', 'category', 'cat', 'sub'));
  }


  public function servicesSubCategorySearch1($params = null)
  { 
    // dd($params);
    $p_slug = null;
    $ps_array = explode("/",$params);
    $parent_category = PrimaryService::where('slug',$ps_array[0])->first();
    $p_slug = $parent_category->slug;
    // start
    if($ps_array[0] && strpos(@$ps_array[1], 'dealer_') === false && preg_match('/featured_/i',@$ps_array[1]) == 0 && strpos(@$ps_array[1], 'keyword_') === false && strpos(@$ps_array[1], 'city_') === false && strpos(@$ps_array[2], 'dealer_') === false && preg_match('/featured_/i',@$ps_array[2]) == 0 && strpos(@$ps_array[2], 'keyword_') === false && strpos(@$ps_array[2], 'city_') === false && strpos(@$ps_array[3], 'dealer_') === false && preg_match('/featured_/i',@$ps_array[3]) == 0 && strpos(@$ps_array[3], 'keyword_') === false && strpos(@$ps_array[3], 'city_') === false){
      $params = 'ps_'.$parent_category->id;
    }

    if($ps_array[0] && (strpos(@$ps_array[1], 'dealer_') !== false || preg_match('/featured_/i',@$ps_array[1]) == 1 || strpos(@$ps_array[1], 'keyword_') !== false || strpos(@$ps_array[1], 'city_') !== false || strpos(@$ps_array[2], 'dealer_') !== false || preg_match('/featured_/i',@$ps_array[2]) == 1 || strpos(@$ps_array[2], 'keyword_') !== false || strpos(@$ps_array[2], 'city_') !== false || strpos(@$ps_array[3], 'dealer_') !== false || preg_match('/featured_/i',@$ps_array[3]) == 1 || strpos(@$ps_array[3], 'keyword_') !== false || strpos(@$ps_array[3], 'city_') !== false)){
      $params = 'ps_'.$parent_category->id;
    }

    if(@$ps_array[1] && strpos(@$ps_array[1], 'dealer_') === false && preg_match('/featured_/i',@$ps_array[1]) == 0 && strpos(@$ps_array[1], 'keyword_') === false && strpos(@$ps_array[1], 'city_') === false && strpos(@$ps_array[2], 'dealer_') === false && preg_match('/featured_/i',@$ps_array[2]) == 0 && strpos(@$ps_array[2], 'keyword_') === false && strpos(@$ps_array[2], 'city_') === false && strpos(@$ps_array[3], 'dealer_') === false && preg_match('/featured_/i',@$ps_array[3]) == 0 && strpos(@$ps_array[3], 'keyword_') === false && strpos(@$ps_array[3], 'city_') === false){
      $sub_category = SubService::where('slug',@$ps_array[1])->where('primary_service_id',$parent_category->id)->where('status','1')->first();
      $params = 'ps_'.$parent_category->id.'/cat_'.$sub_category->id;
      $sub_slug = $sub_category->slug;
    }

    if(@$ps_array[0] && @$ps_array[1] && @$ps_array[2] && strpos(@$ps_array[1], 'dealer_') === false&& preg_match('/featured_/i',@$ps_array[1]) == 0 && strpos(@$ps_array[1], 'keyword_') === false && strpos(@$ps_array[1], 'city_') === false && strpos(@$ps_array[2], 'dealer_') === false && preg_match('/featured_/i',@$ps_array[2]) == 0 && strpos(@$ps_array[2], 'keyword_') === false && strpos(@$ps_array[2], 'city_') === false && strpos(@$ps_array[3], 'dealer_') === false && preg_match('/featured_/i',@$ps_array[3]) == 0 && strpos(@$ps_array[3], 'keyword_') === false && strpos(@$ps_array[3], 'city_') === false){
      $sub_category = SubService::where('slug',@$ps_array[1])->where('primary_service_id',$parent_category->id)->where('status','1')->first();
      $ssub_category = SubService::where('slug',@$ps_array[2])->where('primary_service_id',$parent_category->id)->where('status','1')->first();
      $params = 'ps_'.$parent_category->id.'/cat_'.$sub_category->id.'/scat_'.$ssub_category->id;
      $sub_slug = $sub_category->slug;
      $ssub_slug = $ssub_category->slug;
    }

    if(@$ps_array[1] && (strpos(@$ps_array[1], 'dealer_') !== false || preg_match('/featured_/i',@$ps_array[1]) == 1 || strpos(@$ps_array[1], 'keyword_') !== false || strpos(@$ps_array[1], 'city_') !== false || strpos(@$ps_array[2], 'dealer_') !== false || preg_match('/featured_/i',@$ps_array[2]) == 1 || strpos(@$ps_array[2], 'keyword_') !== false || strpos(@$ps_array[2], 'city_') !== false || strpos(@$ps_array[3], 'dealer_') !== false || preg_match('/featured_/i',@$ps_array[3]) == 1 || strpos(@$ps_array[3], 'keyword_') !== false || strpos(@$ps_array[3], 'city_') !== false )){
      if(@$ps_array[1] && !@$ps_array[2] && !@$ps_array[3])
      {
        $params.= '/'.@$ps_array[1];
      }
      elseif(@$ps_array[1] && @$ps_array[2] && !@$ps_array[3])
      {
        $params.= '/'.@$ps_array[1].'/'.@$ps_array[2];
      }
      else
      {
        $params.= '/'.@$ps_array[1].'/'.@$ps_array[2].'/'.@$ps_array[3];
      }
    }
    // dd($params);
    // end
    $subCatsChilds   = null;
    $category_id     = null;
    $category        = null;
    $subCategor      = null;
    $p_id            = null;
    $subCats         = null;
    $sub             = null;
    $queyStringArray = array();
    $searchFilters   = array();
    if ($params) {
      $paramsArray     = explode('/', $params);
      foreach ($paramsArray as $parm) {
        $newArray      = explode("_", $parm);
        $arrayFirst    = head($newArray);
        $arrayLast     = last($newArray);
        $queyStringArray[$arrayFirst][] = $arrayLast;
      }
    }
    $activeLanguage = \Session::get('language');
    DB::enableQueryLog();
    $servicesQuery   = Services::query()->groupBy('services.id');
    $servicesQuery->select(
      "customer_id",
      "c.citiy_id",
      "services.id AS service_id",
      "services.updated_at",
      "phone_of_service",
      "address_of_service",
      "psd.title AS primary_service_title",
      "ssd.title AS sub_service_title",
      "sssd.title AS sub_sub_service_title"
    );

    $servicesQuery->join('service_titles AS st', 'services.id', '=', 'st.services_id'); //Mutahir
    $servicesQuery->join('customers AS c', 'services.customer_id', '=', 'c.id');
    $servicesQuery->join('primary_services_description AS psd', 'services.primary_service_id', '=', 'psd.primary_service_id');
    $servicesQuery->join('sub_services_description AS ssd', 'services.sub_service_id', '=', 'ssd.sub_service_id');
    $servicesQuery->join('sub_services_description AS sssd', 'services.sub_sub_service_id', '=', 'sssd.sub_service_id');
    //$servicesQuery->leftJoin('service_images AS p', 'p.service_id', '=', 'services.id');

    $servicesQuery->where('psd.language_id', '=', $activeLanguage['id']);
    $servicesQuery->where('ssd.language_id', '=', $activeLanguage['id']);
    $servicesQuery->where('sssd.language_id', '=', $activeLanguage['id']);
    $servicesQuery->where('st.language_id', '=', $activeLanguage['id']);
    $queryStringSearched = array();
    if (Arr::has($queyStringArray, 'featured')) {
      $featured = $queyStringArray['featured'][0];
      $servicesQuery->where('is_featured', $featured);

      if ($featured == 'true') {
        $searchFilters['featured_' . $featured] = 'Featured';
        $queryStringSearched['featured'] = " AND is_featured='" . $featured . "' ";
      } else {
        $searchFilters['featured_' . $featured] = 'Un Featured';
        $queryStringSearched['unfeatured'] = " AND is_featured='" . $featured . "' ";
      }
    }
    if (Arr::has($queyStringArray, 'ps')) {
      // dd('ps');
      $p_id = $queyStringArray['ps'][0];
      $servicesQuery->where('services.primary_service_id', $p_id);
      $category       = PrimaryService::where('id', $p_id)->first();
      $primaryServiceTitle = $category->get_category_title->where('language_id', $activeLanguage['id'])->first();

      $subCats        = SubService::where('primary_service_id', $p_id)->where('parent_id', 0)->where('status', 1)->get();
      $queryStringSearched['primary_service'] = " AND s.primary_service_id='" . $p_id . "' ";
      $searchFilters['ps_' . $p_id] = $primaryServiceTitle->title;

      if (Arr::has($queyStringArray, 'cat')) {
        // dd('cat');
        $category_id   = $queyStringArray['cat'][0];
        $servicesQuery->where('services.sub_service_id', $category_id);
        $sub           = SubService::where('id', $category_id)->first();
        $queryStringSearched['subCategories'] = " AND s.sub_service_id =" . $category_id . "";

        $subTitle = $sub->get_category_title->where('language_id', $activeLanguage['id'])->first();

        $searchFilters['cat_' . $category_id] = $subTitle->title;
        if ($sub->is_make == 1) {
          $subCatsChilds = make::where('status', 1)->get();
        } else {
          $subCatsChilds = SubService::where('parent_id', $category_id)->where('status', 1)->get();
        }

        if (Arr::has($queyStringArray, 'scat')) {
          $subCategor = $queyStringArray['scat'][0];
          $servicesQuery->where('services.sub_sub_service_id', $subCategor);
          $queryStringSearched['subChildCategories'] = " AND s.sub_sub_service_id =" . $subCategor . "";


          if ($sub->is_make == 1) {
            $make = Make::where('id', $subCategor)->first();
            $searchFilters['scat_' . $subCategor] = $make->title;
          } else {
            $make = SubService::where('id', $subCategor)->first();
            $subSubTitle = $make->get_category_title->where('language_id', $activeLanguage['id'])->first();

            $searchFilters['scat_' . $subCategor] = $subSubTitle->title;
          }
        } // END IF

      } //END IF

    } // END IF
    if (Arr::has($queyStringArray, 'dealer')) {
      $dealer = $queyStringArray['dealer'][0];
      $servicesQuery->where('c.customer_company', 'like', "%$dealer%");
      $searchFilters['dealer_' . $dealer] = $dealer;
    }
    if (Arr::has($queyStringArray, 'keyword')) {
      $keyword = $queyStringArray['keyword'][0];
      $servicesQuery->where('st.title', $keyword);
    }
    if (Arr::has($queyStringArray, 'ct') || Arr::has($queyStringArray, 'city')) {
      if (Arr::has($queyStringArray, 'ct') && Arr::has($queyStringArray, 'city')) {
        $city_id   = array_merge($queyStringArray['ct'], $queyStringArray['city']);
        unset($queyStringArray['city']);
      } else {
        if (Arr::has($queyStringArray, 'ct')) {
          $city_id   = $queyStringArray['ct'];
        }
        if (Arr::has($queyStringArray, 'city')) {
          $city_id   = $queyStringArray['city'];
        }
      }
      $city_id  = array_unique($city_id);
      $servicesQuery->whereIn('citiy_id', $city_id);
      $cityName = City::select('name')->whereIn('id', $city_id)->where('status', 1)->get();
      $list      = "'" . implode("', '", $city_id) . "'";
      $queryStringSearched['cities'] = " AND c.city_id IN(" . $list . ")";
    } // END CITY CONDITION 
    $servicesQuery->where('status', '=', 1);
    $servicesQuery->orderByRaw('services.' . 'is_featured,services.updated_at DESC');
    $service_ads =   $servicesQuery->paginate(50);
    /* SEARCH KEY WORDS. */
    $searchedKeywords = '<div class="bg-white p-4"><ul class="list-unstyled mb-0 font-weight-semibold">';
    $citiesSet = true;

    foreach ($queyStringArray as $keys => $values) {
      foreach ($values as $data) {
        $new_string    = $params;
        $link = $new_string;
        if ($keys != 'ps') {
          if (Arr::has($queyStringArray, 'scat') && $keys == 'cat') {
            $link = $new_string;
          } else {
            $link          = str_replace($keys . '_' . $data . '/', '', $new_string);
            $link          = str_replace('/' . $keys . '_' . $data, '', $link);
          }
        }

        if (isset($searchFilters[$keys . '_' . $data]) && !empty($searchFilters[$keys . '_' . $data])) {
          $data          = $searchFilters[$keys . '_' . $data];
        }

        if (($keys == 'ct' || $keys == 'city') && $citiesSet) {
          foreach ($cityName as $cities) {
            $searchedKeywords .= '<li class="align-items-center d-flex justify-content-between">' . $cities->name . '<a   href="' . url('/') . '/find-car-services/' . @$p_slug . '"> <span class="fa fa-close themecolor2"></a></span></li>';
          }
          $citiesSet = false;
        } // END IF
        elseif ($keys == 'ct' || $keys == 'city') {
          continue;
        } else {
          $searchedKeywords .= '<li class="align-items-center d-flex justify-content-between">' . $data . '<a href="' . url('/') . '/find-car-services/' . @$p_slug . '"> <span class="fa fa-close themecolor2"></a></span></li>';
        } // END ELSE
      }
    }
    $searchedKeywords .= '</ul></div>';

    /* searched in cities */
    $whereCondition  = "SELECT count(ct.id) as totalAdsInCities,ct.id,ct.name FROM services s 
    INNER JOIN customers as c ON s.customer_id = c.id
    INNER JOIN cities AS ct ON ct.id=c.citiy_id ";

    $whereCondition .= $this->createWhereCondtion($queryStringSearched, 'cities');
    $whereCondition .= " GROUP BY c.id";
    //echo $whereCondition;exit;
    $sideBarArray['foundInCity'] = $this->getSelect($whereCondition);
    // dd($subCatsChilds);
    return view('guest.service_sub_category', compact('searchedKeywords', 'sideBarArray', 'service_ads', 'p_id','p_slug', 'category', 'subCats', 'subCatsChilds', 'sub', 'queyStringArray', 'category_id', 'subCategor'));
  }
  public function getSubServiceChildren()
  {
    if (request()->ajax()) {
      $parentCategory = request()->get('parentCategory');
      $isMake         = request()->get('isMake');
      $subCategory    = request()->get('subCategory');
      $html           = '<table class="table table-bordered" style="width: 102%;"><thead><tr><th>DETAILS</th> 
                    </tr></thead><tbody>';

      if ($isMake) {
        $subCats = make::where('status', 1)->get();
      } else {
        $subCats      = SubService::where('parent_id', $parentCategory)->where('status', 1)->get();
      }

      if (!$subCats->isEmpty()) {
        foreach ($subCats as $values) {
          $radioButton = '<input type="radio"  name="ssub_category"  class="search_check_submit radio d-none"  ';
          if ($subCategory) {
            $radioButton .= 'checked="checked"';
          }
          $radioButton .= 'value="scat_' . $values->id . '" id="makesCheckscat_' . $values->id . '" data-value="scat_' . $values->id . '" >';
          $html .= '<tr><td>' . $radioButton . '<a href="javascript:void(0)" class="search_check_submit subcat_check_submit" data-value="' . $values->id . '" >' . $values->title . '</a></td></tr>';
        }
      }
      $html .= '</tbody></table>';
    } else {
      $html = response('Forbidden.', 403);
    }

    return $html;
  }

  public function showLinkRequestForm()
  {
    // dd('here');
    return View::make('Customers.email');
  }

  public function postResetEmail(Request $request)
  {
    $activeLanguage = \Session::get('language');
    $random = rand();
    $customer = Customer::where('customer_email_address', $request->customer_email_address)->first();
    if (@$customer == null) {
      return redirect()->back()->with('msg', 'Email not found!');
    }
    $customer->password_reset_token = $random;
    $customer->save();

    if ($customer) {
      $data = [
        'id' =>  $customer->id,
        'password_reset_token' => $random,
        'firstname' => $request->customer_firstname,
        'lastname' => $request->customer_lastname,
        'email' => $request->customer_email_address,
        'fullname' => $customer->customer_company,
      ];


      //dd($data);
      $templatee = EmailTemplate::where('type', 9)->first();
      $template = EmailTemplateDescription::where('email_template_id', $templatee->id)->where('language_id', $activeLanguage['id'])->first();
      Mail::to($request->customer_email_address)->send(new ResetPasswordMail($data, $template));
    }

    return redirect()->route('signin')->with('msg', 'A link is send to your email to reset password!');
  }
  public function resetPasswordForm($id, $token)
  {
    return view('users.reset_password_form', compact('id', 'token'));
  }
  public function resetPasswordFormPost(Request $request)
  {

    $customer = Customer::find($request->id);

    if ($customer->password_reset_token == $request->p_token) {
      $customer->customer_password = bcrypt($request->password);
      $customer->save();

      // return redirect()->route('signin')->with('msg','Password Changed Successfully !');
      return response()->json(['done' => true]);
    } else {
      return response()->json(['error' => true]);
    }
  }

  public function getSpecificParts(Request $request)
  {
    // dd($request->all());
    $allSpareParts = SparePartAd::where('parent_id', @$request->parent_id)->where('category_id', @$request->secondary_id)->where('status', 1)->get();
    $i = 0;
    
    if ($allSpareParts->count() > 0) {

      $html_string ='<div class="item"><div class="row">';
      foreach ($allSpareParts as $singleService) {
        $html_string .= '<div class="col-md-4 col-sm-4 offered-services-col mt-0" style="margin-bottom: 58px;">
                          <figure class="align-items-center border d-flex justify-content-center mb-0 position-relative text-left">
                            <img src="'. url('public/uploads/ad_pictures/spare-parts-ad/'.@$singleService->id.'/'.@$singleService->get_one_image->img).'" alt="carish used cars for sale in estonia" class="img-fluid">
                          </figure>
                          <div class="p-lg-3 p-2 border border-top-0">
                            <h5 class="font-weight-semibold mb-2 overflow-ellipsis">
                              <a href="'.url('spare-parts-details/'.@$singleService->id).'" class="stretched-link">'.@$singleService->title.'</a>
                            </h5>
                            <ul class="list-unstyled mb-0 font-weight-semibold">
                              <li class="align-items-baseline d-flex"><span class="mr-2"><em class="fa fa-amp-maker fa-map-marker"></em></span>'. @$singleService->get_customer->city->name.'</li>
                              <li class="d-flex themecolor3"><span class="mr-2"></span>$'.@$singleService->price.'</li>
                            </ul>
                          </div>
                        </div>';
        $i++;
        if ($i == 6) {
          $html_string .= '</div></div><div class="item"><div class="row">';
          $i = 0;
        }
      }
    } else {
      $html_string = '<div class="col-lg-12 text-center">
                        <h5 class="" style="margin-top: 6%;">' . Lang::get('findAutoPartPage.noRecordFound') . '</h5>
                        </div>';
    }
    return response()->json(['html' => $html_string, 'success' => true]);
  }

  public function getSpecificOfferServices(Request $request)
  {
    $primary_service_id = $request->get('primary_id');
    $sub_service_id     = $request->get('cat_id');
    $sub_sub_service_id = $request->get('sub_id');
    $activeLanguage     = \Session::get('language');
    $i                  = 0;
    $allSpareParts      = Services::where('status', '1')->where('primary_service_id', $primary_service_id)
      ->where('sub_service_id', $sub_service_id)->where('sub_sub_service_id', $sub_sub_service_id)
      ->get();

    if ($allSpareParts->count() > 0) {
      $html_string ='<div class="item"><div class="row">';
      foreach ($allSpareParts as $singleService) {
        $serviceimage      = $singleService->get_service_image;
        $html_string .= '<div class="col-md-4 col-sm-4 offered-services-col">
                          <figure class="align-items-center border d-flex justify-content-center mb-0 position-relative text-left">';
        if (@$singleService->services_images[0]->image_name != null && file_exists(public_path() .
            "/uploads/ad_pictures/services/" . $singleService->id . "/" . $singleService->services_images[0]->image_name)
        ) {
          $html_string .= '<img src="' . url("public/uploads/ad_pictures/services/" . $singleService->id . "/" . @$singleService->services_images[0]->image_name) . '" class="img-fluid" alt="carish used cars for sale in estonia" width="170px" style="height: 150px;">';
        } else {
          $html_string .= '<img src="' . url("public/assets/img/serviceavatar.jpg") . '" class="img-fluid" alt="carish used cars for sale in estonia" width="170px" style="height: 150px;">';
        }
        $html_string .= '</figure>
                          <div class="p-lg-3 p-2 border border-top-0">
                            <h5 class="font-weight-semibold mb-2 overflow-ellipsis"><a   href="' . url('service-details/' . @$singleService->id) . '" class="stretched-link">' . @$singleService->get_service_ad_title($singleService->id, $activeLanguage['id'])->title . '</a></h5>
                            <ul class="list-unstyled mb-0 font-weight-semibold">
                              <li class="align-items-baseline d-flex"><span class="mr-2"><em class="fa fa-amp-maker fa-map-marker"></em></span> ' . @$singleService->get_customer->city->name . '</li>
                              
                            </ul>
                          </div>
                        </div>';
        $i++;
        if ($i == 6) {
          $html_string .= '</div>
                    </div>
                    <div class="item">
                      <div class="row">';
          $i = 0;
        }
      }
    } else {
      $html_string = '<div class="col-lg-12 text-center">
                        <h5 class="" style="margin-top: 6%;">' . Lang::get('findServicePage.noRecordFound') . '</h5>
                        </div>';
    }


    return response()->json(['html' => $html_string, 'success' => true]);
  }

  public function userVerify($id)
  {
    // dd($id);
    // return redirect()->back();
    $customer = Customer::find($id);
    $customer->customer_status = 'Active';
    $customer->login_status = 1;
    $customer_role = $customer->customer_role;
    $customer->save();
    if($customer_role == 'business')
    return redirect('user/login')->with('business_email_verified', 'Yes Done');
    else
    return redirect('user/login')->with('verified', 'Yes Done');
  }
  public function getSpModels($id)
  {
      $models = Carmodel::where('make_id', $id)->where('status', 1)->orderBy('name', 'ASC')->get(); //abc
      $html = '';
      $html .= '<option value="" >'.Lang::get('postSparePartAdPage.selectOption').'</option>';
      foreach ($models as $showmodels) {
        $html .= '<option value="' . $showmodels->id . '" >' . $showmodels->name . '</option>';
      }
    return $html;
  }
}
