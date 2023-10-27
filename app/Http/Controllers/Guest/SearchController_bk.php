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
use App\User,View,Session,Redirect;
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
class SearchController_bk extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function postExtraSparePart(Request $request)
    { 
        $credit             = 0;
        $request_amount     = 0;
        $creditCollection   = CustomerAccount::where('customer_id', Auth::guard('customer')->user()->id)
            ->where('status', 1)->selectRaw('SUM(credit) -  SUM(debit) AS total_balance')->first();
        $credit = $creditCollection->total_balance;

        if (@$request->featured_days == 3) {
            $request_amount = 10;
        } else if (@$request->featured_days == 7) {
            $request_amount = 20;
        } else if (@$request->featured_days == 15) {
            $request_amount = 35;
        }

        if ($request->use_balance == 'on') {
            $ad    = SparePartAd::find(@$request->ad_id);
            $start = Carbon::now();

            $result              = array('success' => true, 'payment_status' => 'full');
            $start->addDays($request->featured_days);
            $featured_until = $start->toDateTimeString();

            $account              = new CustomerAccount;
            $account->customer_id = Auth::guard('customer')->user()->id;
            $account->ad_id       = @$request->ad_id;

            if ($request_amount > $credit) {
                $remaining_balance = $credit - $request_amount;
                $account->credit   = $remaining_balance;
                $request_amount    = $credit;
                $is_featured       = false;
                $result['payment_status'] = 'partial';
            }

            $account->debit          = $request_amount;
            $account->detail         = 'Post An Accessory';
            $account->number_of_days = $request->featured_days;
            $account->paid_amount    = @$request_amount;
            $account->status         = 1;
            $account->type           = 'sparepart_ad';
            $account->save();
            $ad->status              = 0;
            $ad->save();
            $new_history             = new AdsStatusHistory;
            $new_history->user_id    = Auth::guard('customer')->user()->id;
            $new_history->ad_id      = $ad->id;
            $new_history->type       = 'sparepart';
            $new_history->status     = 'Unpaid';
            $new_history->new_status = 'Pending';
            $new_history->save();
            $result['invoice_id']    = $account->id;
            return response()->json($result); 
        } else {
           // $ad                          = SparePartAd::find(@$request->ad_id);
            $new_request                 = new CustomerAccount;
            //$new_request->ad_id          = @$request->ad_id;
            $new_request->customer_id    = Auth::guard('customer')->user()->id;
            $new_request->number_of_days = $request->featured_days;
            if (@$request->featured_days == 3) {
                $new_request->paid_amount = '10';
                $new_request->credit      = '-10';
            } else if (@$request->featured_days == 7) {
                $new_request->paid_amount = '20';
                $new_request->credit      = '-20';
            } else {
                $new_request->paid_amount = '35';
                $new_request->credit      = '-35';
            }
            $new_request->type            = 'sparepart_ad';
            $new_request->detail          = 'Post An Accessory';
            $new_request->save();

            return response()->json(['request' => true, 'invoice_id2' => $new_request->id]);
        }
    }

    public function featuredAd(Request $request)
    {
        $credit = 0;
        $request_amount = 0;
        /* foreach (Auth::guard('customer')->user()->customer_account as $account) {
            if ($account->status == 1) {
                $credit = $credit + $account->credit - @$account->debit;
            }
        } */
        $creditCollection   = CustomerAccount::where('customer_id', Auth::guard('customer')->user()->id)
            ->where('status', 1)->selectRaw('SUM(credit) -  SUM(debit) AS total_balance')->first();
        $credit = $creditCollection->total_balance;


        if (@$request->featured_days == 3) {
            $request_amount = 10;
        } else if (@$request->featured_days == 7) {
            $request_amount = 20;
        } else if (@$request->featured_days == 15) {
            $request_amount = 35;
        }

        if ($request->use_balance == 'on') {
            $ad = Ad::find(@$request->ad_id);

            $result              = array('success' => true, 'payment_status' => 'full');
            if ($ad->is_featured == 'false') {
                $start = Carbon::now();
                $start->addDays($request->featured_days);
                $featured_until = $start->toDateTimeString();

                $account                 = new CustomerAccount;
                $account->customer_id    = Auth::guard('customer')->user()->id;
                $account->ad_id          = @$request->ad_id;
                if ($request_amount > $credit) {
                    $remaining_balance = $credit - $request_amount;
                    $account->credit   = $remaining_balance;
                    $request_amount    = $credit;
                    $is_featured       = false;

                    $result['payment_status'] = 'partial';
                }
                $account->debit          = $request_amount;
                $account->detail         = 'feature ad';
                $account->number_of_days = $request->featured_days;
                $account->paid_amount    = @$request_amount;
                $account->status         = 1;
                $account->type           = 'car';
                $account->save();
                $ad->is_featured         = 'true';
                $ad->feature_expiry_date = @$featured_until;
                $ad->save();
                $result['invoice_id']    = $account->id;
                return response()->json($result);
            } else {
                return response()->json(['already_featured' => true]);
            }
        } else {
            $ad = Ad::find(@$request->ad_id);
            $pending = CustomerAccount::select('id')->where('ad_id', @$request->ad_id)->where('type', 'car')->count();
            if (@$ad->is_featured == 'true') {
                return response()->json(['already_in_request' => true]);
            } else if ($ad->is_featured == 'false') {
                $new_request                 = new CustomerAccount;
                $new_request->ad_id          = @$request->ad_id;
                $new_request->customer_id    = Auth::guard('customer')->user()->id;
                $new_request->number_of_days = $request->featured_days;
                if (@$request->featured_days == 3) {
                    $new_request->paid_amount = '10';
                    $new_request->credit = '-10';
                } else if (@$request->featured_days == 7) {
                    $new_request->paid_amount = '20';
                    $new_request->credit = '-20';
                } else {
                    $new_request->paid_amount = '35';
                    $new_request->credit = '-35';
                }
                $new_request->type   = 'car';
                $new_request->status = 0;
                $new_request->detail = 'feature ad';
                $new_request->save();
                return response()->json(['request' => true, 'invoice_id2' => $new_request->id]);
            } else {
                return response()->json(['already_featured' => true,]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function offerservicesListing()
    {
       // $services = Services::where('status',1)->orderBy('primary_service_id','asc')->get();
       // $primary_services = $services->unique('primary_service_id');
       $primary_services = PrimaryService::where('status',1)->orderBy('title','ASC')->get();

        return view('guest.offerservices_listings',compact('primary_services'));
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
      $services = Services::select('customer_id')->where('primary_service_id',$id)->get();
      $customer_ids = $services->unique('customer_id');
      $category = PrimaryService::where('id',$id)->first();
      // dd($customer_ids);
        return view('guest.machinics_listing',compact('customer_ids','id','category'));
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
          $result[] = ['id' => 'dealer_'.$businessUser->id, 'value' => $businessUser->customer_company];
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
          '(title LIKE "%'.$term. '%"  OR product_code LIKE  "%'.$term.'%" )'));
     /*  $spareParts->orWhere('title', 'like', "%$term%");
      $spareParts->orWhere('product_code', 'like',"%$term%"); */
      if (request()->has('subCategoryId') && request()->get('subCategoryId') !='') {
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
      $spareParts    =  SparePartCategory::select('spare_part_categories.id', 'spare_part_categories_description.title', 'spare_part_categories.parent_id','spare_part_categories_description.spare_part_category_id')->join('spare_part_categories_description','spare_part_categories.id','=','spare_part_categories_description.spare_part_category_id')
        ->where('spare_part_categories_description.language_id',$activeLanguage['id'])
        ->where('spare_part_categories_description.title', 'like', "%$term%")
        ->where('spare_part_categories.status',1)
        ->where('spare_part_categories.parent_id', '>', "0")->get();
      $result = array();
      if (!$spareParts->isEmpty()) {
        foreach ($spareParts as $sparePart) { 
            $parent = ' - '.$sparePart->parent->get_category_title()->where('language_id',$activeLanguage['id'])->pluck('title')->first(); 
          $result[] = ['id' => 'cat_'. $sparePart->parent_id.'/scat_'.$sparePart->id, 'value' => $sparePart->title . $parent];
        }
      }
    } else {
      return response('Forbidden.', 403);
    }
    return response()->json($result);
  }


  public function autoPartsListing($params=null)
    {
    $queyStringArray = array();
    $searchFilters   = array();
    if ($params) {
      
      $paramsArray     = explode('/', $params);
      //do stuff 
      foreach ($paramsArray as $parm) {
        $newArray      = explode("_", $parm);
        $arrayFirst    = head($newArray);
        $arrayLast     = last($newArray);
        $queyStringArray[$arrayFirst][] = $arrayLast;
      }
    }
    $sparepartsQuery     = SparePartAd::query()->distinct('spare_part_ads.id')->groupBy('spare_part_ads.id');
    $select = array("spare_part_ads.id", "spare_part_ads.is_featured",  "spare_part_ads.title as spare_part_title", "customer_id","price");
    $sparepartsQuery->select($select);
    $sparepartsQuery->where('status','=',1);
    $queryStringArray = array();
    
    if (Arr::has($queyStringArray, 'cat')) {
      $parentCategory = $queyStringArray['cat'][0];
      $sparepartsQuery->where('parent_id', $parentCategory);
      $category        = SparePartCategory::where('id', $parentCategory)->first();
      $childCategories = SparePartCategory::where('parent_id', $parentCategory)->where('status',1)->get();
      $queryStringArray['cat'] = " AND parent_id =".$parentCategory." ";
    }

    if (Arr::has($queyStringArray, 'dealer')) {
      $dealer = $queyStringArray['dealer'][0];
      $sparepartsQuery->join('customers AS cm', 'cm.id', '=', 'spare_part_ads.customer_id');
      $sparepartsQuery->where('customer_company', 'like', "%$dealer%");
      $searchFilters['dealer_' . $dealer] = $dealer;
    }

    if (Arr::has($queyStringArray, 'partid')) {
      $part_id = $queyStringArray['partid'][0];
      $sparepartsQuery->where('spare_part_ads.id', '=',$part_id);
      $spa        = SparePartAd::select('title', 'product_code')->where('id', $part_id)->first();
      $spa =  $spa->title . '-' . $spa->product_code;
      $params = str_replace('partid_' . $queyStringArray['partid'][0], 'partid_' . $spa, $params); 
      $queyStringArray['partid'][0] = $spa;
      $searchFilters['partid_' . $part_id] = $spa;
    }


    if (Arr::has($queyStringArray, 'scat')) {
      #$subCategories = array_filter($queyStringArray['scat']); 
      $subCategories = $queyStringArray['scat'][0];
      $sparepartsQuery->where('category_id', $subCategories);
      #$list      = "'" . implode("', '", $queyStringArray['scat']) . "'";
      $queryStringArray['subCategories'] = " AND sc.category_id = " . $subCategories . " ";
      $scat  = SparePartCategory::select('title')->where('id', $subCategories)->first();
      /*$title =  $scat->title; 
       $params = str_replace('scat_'. $queyStringArray['scat'][0] , 'scat_' . $title, $params);
      $queyStringArray['scat'][0] = $title;
      $queryStringArray['scat']    = " AND category_id IN (" . implode(',',$subCategories) . ") "; */
      $searchFilters['scat_' . $subCategories] = $scat->title;
    }

    if (Arr::has($queyStringArray, 'ct') || Arr::has($queyStringArray, 'city')) {

      if (Arr::has($queyStringArray, 'ct') && Arr::has($queyStringArray, 'city')){
          $city_id   = array_merge($queyStringArray['ct'],$queyStringArray['city']);
          unset($queyStringArray['city']);
      }
      else{
        if (Arr::has($queyStringArray, 'ct')) {
          $city_id   = $queyStringArray['ct'];
        }
        if (Arr::has($queyStringArray, 'city')) {
          $city_id   = $queyStringArray['city'];
        }
      }
      $city_id        = array_unique($city_id);
      $sparepartsQuery->whereIn('city_id', $city_id);
      $cityName  = City::select('name')->whereIn('id',$city_id)->where('status',1)->get();
     // $cityName  = $cityName->name;
      $list      = "'" . implode("', '", $city_id) . "'";
      $queryStringArray['cities'] = " AND c.city_id IN(" . $list . ")";
      
    } 
   /*  DB::enableQueryLog();

    $users = $sparepartsQuery->get();
    $query = DB::getQueryLog();
    $query = end($query);
    dd($query);
 */
    $allAds          =  $sparepartsQuery->paginate(10);//$sparepartsQuery->get(); 
      //$allAds       = SparePartAd::where('parent_id',$id)->get();
    $customer_ids     = $allAds->unique('customer_id');
    $searchedKeywords = '<div class="bg-white p-4"><ul class="list-unstyled mb-0 font-weight-semibold">';
    $citiesSet = true;
    $test = array();
    foreach ($queyStringArray as $keys => $values) {
  
      foreach ($values as $data) {
        $new_string    = $params;
        $link = $new_string;  
        if ($keys == 'cat') continue;

        if (Arr::has($queyStringArray, 'scat') && $keys == 'scat') {
          $link = $new_string;
        } else {
          $link          = str_replace($keys . '_' . $data . '/', '', $new_string);
          $link          = str_replace('/' . $keys . '_' . $data, '', $link);
        }
        
        if (isset($searchFilters[$keys . '_' . $data]) && !empty($searchFilters[$keys . '_' . $data])) {
          $data          = $searchFilters[$keys . '_' . $data]; 
        }
        
        if(($keys == 'ct' || $keys == 'city') && $citiesSet) {  
            foreach($cityName as $cities){
              $searchedKeywords .= '<li class="align-items-center d-flex justify-content-between">' . $cities->name . '<a target="_blank" href="' . url('/') . '/find_autoparts/listing/' . $link . '"> <span class="fa fa-close themecolor2"></a></span></li>';        
            }
          $citiesSet = false;
        }// END IF
        elseif($keys == 'ct' || $keys == 'city') {
          continue;
        }
        else
        {
          
          $searchedKeywords .= '<li class="align-items-center d-flex justify-content-between">' . $data . '<a target="_blank" href="' . url('/') . '/find_autoparts/listing/' . $link . '"> <span class="fa fa-close themecolor2"></a></span></li>';
        } // END ELSE
      }
    }
    $searchedKeywords .= '</ul></div>';
    #################### CITIES LOCATIONS COUNT ##############################
    $whereCondition  = "SELECT count(c.id) as totalAdsInCities,c.id,c.name FROM spare_part_ads sc 
      INNER JOIN cities AS c ON c.id=sc.city_id ";

    $whereCondition .= $this->createWhereCondtion($queryStringArray, 'cities');
    $whereCondition .= " GROUP BY c.id";
    $sideBarArray['foundInCity'] = $this->getSelect($whereCondition);
    
    return view('guest.auto_parts_listing',compact('customer_ids','allAds','category', 'childCategories', 'subCategories', 'queyStringArray', 'searchedKeywords', 'sideBarArray'));

  }
     public function subAutoPartsListing($id,$sub)
    {
      $allAds = SparePartAd::where('parent_id',$id)->where('category_id',$sub)->get();
      // dd($allAds);
      $customer_ids = $allAds->unique('customer_id');
      $category     = SparePartCategory::where('id',$id)->first();
      $sub_category = SparePartCategory::where('id',$sub)->first();
      // dd($customer_ids);
        return view('guest.sub_auto_parts_listing',compact('customer_ids','allAds','category','sub_category'));
    }

    public function companyProfile($id){
        $ads       = Ad::join('makes', 'ads.maker_id', '=', 'makes.id')->orderBy('makes.title', 'ASC')->select('ads.*')->where('customer_id',$id)->where('ads.status',1)->get();
        // dd($ads);
      $customer = Customer::where('id',$id)->first();
      $timings = CustomerTiming::where('customer_id',$id)->get();
      return view('guest.company_profile',compact('customer','timings','ads'));
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
      $ads       = Ad::where('is_featured','true')->get();
      $customers = Customer::all();
      $featured_dealers = array();
      foreach ($customers as $customer) {
        $ad = Services::where('customer_id',$customer->id)->where('is_featured','true')->get();
        if(@$ad->count() > 0){
          array_push($featured_dealers, $customer);
        }
      }
      
      $makes     = Make::limit(31)->orderBy('title','ASC')->get();
      $models    = Carmodel::where('status',1)->orderBy('name','ASC')->limit(55)->get();
      $cities    = City::where('status',1)->orderBy('name','ASC')->get();
      // $bodytypes = BodyTypes::where('status',1)->(31)->get();
      $bodytypes    = BodyTypes::where('status',1)->limit(31)->get()->sortBy(function($query) use ($activeLanguage){
      return $query->bodyType_description()->where('language_id',$activeLanguage['id'])->pluck('name')->first();
      });
      $tags      = Tag::where('status',1)->get();

      $engineTypesQuery       = EngineType::query()->select("engine_type_id", "et.title");
      $engineTypesQuery->join('engine_types_description AS et', 'engine_types.id', '=', 'et.engine_type_id')->where('language_id', $activeLanguage['id']);
      $engineTypes            = $engineTypesQuery->where('status', 1)->orderBy('et.title')->get();

      $transmissionQuery      = Transmission::query()->select("transmission_id", "t.title");
      $transmissionQuery->join('transmission_description AS t', 'transmissions.id', '=', 't.transmission_id')->where('language_id', $activeLanguage['id']);
      $transmissions          = $transmissionQuery->where('status', 1)->orderBy('t.title')->get();

      return view('guest.find_used',compact('ads','makes','models','cities','bodytypes','featured_dealers', 'tags', 'engineTypes', 'transmissions'));
    }

    public function findAutoParts()
    {
      // $spareParts      = SparePartAd::all();
      $spareCategories = SparePartCategory::where('parent_id',0)->where('status',1)->orderBy('title','ASC')->get();
      // dd($spareCategories);
      // dd($spareParts);
        return view('guest.find_auto_parts',compact('spareCategories'));
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
        //
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
            $makes    =  Make::select('id','title')->where('title', 'like', "%$term%")->get();
            $result = array();
            if (!$makes->isEmpty()) {
                foreach($makes as $make){
                  $result[] = ['id'=>$make->title,'value'=>$make->title, 'label'=>$make->title];
                }
              } 
          }
          else {
                $html = response('Forbidden.', 403);
          }  
        return response()->json($result);
      }


    public function getModels()
    {
         
        if (request()->ajax()) {
          $result = array();
          $term     = request()->get('term'); 
          $models = Carmodel::select('id','name')->where('name', 'like', "%$term%")->get(); 
            if (!$models->isEmpty()) { 
                 foreach($models as $model)
                 {
                  $result[] = ['id'=>$model->name,'value'=>$model->name, 'label'=>$model->name];
                }
              }
          } 
          else {
            $html = response('Forbidden.', 403);
          }  
        return response()->json($result);
      }

    public function getMakesVersions()
    { 
         
        if (request()->ajax()) {
            $term     = request()->get('term'); 
            $makes    =  Make::select('id','title')->where('title', 'like', "%$term%")->get();
      /* $versions = Version::select('id','model_id','label','cc','kilowatt')->where('label', 'like', "%$term%")->get();*/
      $result = array();
      $versions = Make::select(DB::raw('CONCAT(title, " ", m.name) AS full_name'),
        'm.name', 'm.id as model_id','title',
        'make_id')->join('models AS m', 'makes.id', '=', 'm.make_id')
        ->where(DB::raw('CONCAT(title, " ", m.name)'), 'like', "%$term%")->get();
      //$versions = Carmodel::select('id','name')->where('name', 'like', "%$term%")->get(); 

            if (!$makes->isEmpty()) {

                foreach($makes as $make){
                    //$html .= '<option value="'.$make->id.'">'.$make->title.'</option>';
                     $result[] = ['id'=>'mk_'.$make->title,'value'=>$make->title, 'label'=>$make->title];
                }
            }

              if (!$versions->isEmpty()) { 
                 foreach($versions as $version)
                 {
                  //models();
                    /*$result[] = ['id'=>'mo_'.$version->model->name.'#'.$version['label'].'-'.$version['cc'].'-'.$version->kilowatt,'value'=>$version['label'], 'label'=>$version['label'].' '.$version['cc']." cc".' '.$version->kilowatt.' KW'];*/

                    $result[] = ['id'=>'mo_'.$version->name,'value'=>$version->full_name, 'label'=>$version->full_name,'make'=> 'mk_' . $version->title];

                 }
                }
            //$html .= '<option value="'.$version['id'].'">'.$version['label'].'</option>'; 
    } else {
            $html = response('Forbidden.', 403);
        } 
       // $result['items'] = $makes;
        return response()->json($result);
        
    }


    public function getAllCities($type){

        if (request()->ajax()) {

            $term   = request()->get('q');
            $cities = City::select('id','name AS text')->where('name', 'like', "%$term%")->where('status',1)->get(); 
              if (!$cities->isEmpty()) {
                foreach($cities as $city){ 
                     $result[] = ['id'=>$type."_".$city->text, 'text'=>$city->text];
                }
            }
            return response()->json($result);
        }

    }

  public function getCities()
  {
    if (request()->ajax()) {

      $term   = request()->get('term');
      $cities = City::select('id', 'name')->where('name', 'like', "%$term%")->where('status',1)->get();
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

    public function getTags(){
         if (request()->ajax()) {
            $html = '<option value="" selected="">Select Tags</option>';
            $tags = Tag::where('status',1)->get();
             if (!$tags->isEmpty()) {
                    foreach($tags as $tag){ 
                         $html .= '<option value="tg_'.$tag->name.'"  >'.$tag->name.'</option>';
                    }
                }
        }
        else {
               $html = response('Forbidden.', 403);
            }

            return $html;
    } 

    public function getAllVersions(){
         if (request()->ajax()) {
            $response = response()->json(array()); 
            $term   = request()->get('q');
            $models = array();
            $versions = Version::select('id','label','cc','kilowatt')
                        ->where('label', 'like', "%$term%")->get();
             if (!$versions->isEmpty()) {
               foreach($versions as $version){ 
                         $models[] = array('id'=>"ver_".str_replace(" / ", "",$version->label),'text'=>$version->label.' '.$version->cc." CC".' '.$version->kilowatt.' KW');
                    }
                }
           
              return response()->json($models); 
        }
    }

  public function getAllVersionsBy($term){
         if (request()->ajax()) {
            $response     = response()->json(array());  
            $term         = explode("_",$term);
            $ads_results  = Version::query()->distinct('versions.id')->groupBy('versions.id');
            $select_array = array('id','label','cc','kilowatt');
            $ads_results->join('models AS mo', 'mo.id', '=', 'versions.model_id');
            $filter       = $term[1];
            if($term[0] == 'mk'){
              $ads_results->join('makes AS m', 'm.id', '=', 'mo.make_id');
              $ads_results->where('m.title','like', "%$filter%");
            }
            if($term[0] == 'mo'){ 
              $ads_results->where('mo.name','like', "%$filter%");
            } 
            $models   = array();
            $versions = $ads_results->get(); 
            $html = '<option value="">'.Lang::get('home.versions').'</option> ';
             if (!$versions->isEmpty()) {
               foreach($versions as $version){ 
                 $html .= '<option value="ver_'. str_replace(" / ", "!", $version->label)."-".$version->cc."-CC-".$version->kilowatt . '-KW'.'">'.$version->label.' '.$version->cc." CC".' '.$version->kilowatt.' KW'.'</option>';
                        /* $models[] = array('id'=>"ver_".$version->label,'text'=>$version->label.' '.$version->cc." cc".' '.$version->kilowatt.' KW');*/
                    }
                } 
              return $html; 
        }
    }


     public function getAllColors(){

        if (request()->ajax()) {
            $response = response()->json(array());
            $term     = request()->get('q');
            $restut = array();
            $activeLanguage = \Session::get('language');
            //$colors   = Color::select('id','name AS text')->where('name', 'like', "%$term%")->get();
            $colorsQuery    = Color::query()->select("color_id", "cd.name as text");
            $colorsQuery->join('colors_description AS cd', 'colors.id', '=', 'cd.color_id')->where('language_id', $activeLanguage['id'])->where('colors.status',1)->orderBy('cd.name','ASC');
      $colorsQuery->where('cd.name', 'like', "%$term%");
            $colors         = $colorsQuery->get();
            // dd($colors);
              if (!$colors->isEmpty()) {
                foreach($colors as $color){
                  $restut [] = array('id'=>'cl_'.$color->text,'text'=>$color->text);
                }

                // dd($restut);
                $response = response()->json($restut);
            }
            return $response;
        }

    }


    public function getVersionsCC(){

        if (request()->ajax()) { 
            $html = '';
            $versions   = Version::select('cc','id')->distinct('cc')->groupBy('cc')->get(); 
             /* 'strict' => false, id db file $logs = DB::table('versions')->select('cc','id')->groupBy('cc')->get();
              $versions = Version::selectRaw('distinct(cc), id')->groupBy('cc')->get();
*/
if (!$versions->isEmpty()) {
                 foreach($versions as $version){ 
                         $html .= '<option value="'.$version->cc.'"  >'.$version->cc.' CC</option>';
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

public function BodyTypes(){

    if (request()->ajax()) { 
      $html = '';

      $activeLanguage = \Session::get('language');
      $bodyTypesQuery = BodyTypes::query()->select("body_type_id", "cd.name");
      $bodyTypesQuery->join('body_types_description AS cd', 'body_types.id', '=', 'cd.body_type_id')->where('status',1)->where('language_id', $activeLanguage['id'])->orderBy('cd.name');
      $body_types      = $bodyTypesQuery->get();
            //$body_types   = BodyTypes::select('id','name')->get();
              if (!$body_types->isEmpty()) {
                 foreach($body_types as $body_type){ 
                         $html .= '<option value="bt_'.$body_type->name.'"  >'. $body_type->name.'</option>';
                    }
            }
            return $html;
     }

}
 
  public function simpleSearch($params){
    /* QUERY OF THE SEARCH */

     //DB::enableQueryLog(); 
      $ads_results     = Ad::query()->distinct('ads.id')->groupBy('ads.id');
      $select_array    = array('ads.id','fuel_type','description','year','millage','fuel_average',
            'price','vat','neg','features','transmission_type','assembly',
            'doors','length','height','width','poster_name','poster_email','poster_phone',
            'is_featured','views','ads.status','maker_id','mo.id as model_id','version_id',
            'customer_id','m.title as make_name','mo.name as model_name',
            'v.label as version_label','v.cc as engine_capacity',
            'v.kilowatt AS engine_power',/*  'c.name as city_name', */
            DB::raw('DATE_FORMAT(current_date(), "%d-%m-%Y") - DATE_FORMAT(ads.updated_at, "%d-%m-%Y") as last_updated'),
            'p.img');
      $ads_results->leftJoin('makes AS m', 'm.id', '=', 'ads.maker_id');
      $ads_results->leftJoin('versions AS v', 'v.id', '=', 'ads.version_id');
      $ads_results->leftJoin('models AS mo', 'mo.id', '=', 'ads.model_id'); 
      $ads_results->where('ads.status',1);
      //############ LANGUAGE BASED SEARCH TABLES #########################
  
        /* END */
      if($params)
        {
          $quey_string_slug = array();
          $params_array = explode('/', $params);
          //do stuff 
          foreach($params_array as $parm)
          {
            $new_array      = explode("_",$parm);
            $array_first    = head($new_array);
            $array_last     = last($new_array);
            $quey_string_slug[$array_first][] = $array_last;
          }
        }

      $searched_keywords  = '';
      $query_string_array = array();
      $searchFilters      = array(); 
      $searchTables       = '';

      if(Arr::has($quey_string_slug, 'isf'))
          {
           $featured = true; 
           $ads_results->where('is_featured',$featured);           
           $query_string_array['is_featured'] = " AND is_featured= '".$featured."' ";
           $searchFilters['isf_featured']     = Lang::get('search.featured_ads');
          }


      if(Arr::has($quey_string_slug, 'mk'))
          {
            $ads_results->whereIn('m.title',$quey_string_slug['mk']);          
            $list = "'". implode("', '", $quey_string_slug['mk']) ."'";
            $query_string_array['makes'] = " AND m.title IN(".$list.")";
            $searchFilters['mk_'.$quey_string_slug['mk'][0]]      = $quey_string_slug['mk'][0];

          }
      if(Arr::has($quey_string_slug, 'mo'))
          {
            $ads_results->whereIn('mo.name',$quey_string_slug['mo']);          
            $list = "'". implode("', '", $quey_string_slug['mo']) ."'"; 
            $query_string_array['models'] = " AND mo.name IN(".$list.")";

            $searchFilters['mo_'.$quey_string_slug['mo'][0]] = $quey_string_slug['mo'][0];
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

      $searchFilters['year_'.$quey_string_slug['year'][0]] = $quey_string_slug['year'][0];
    }

    if(Arr::has($quey_string_slug, 'price'))
      {
        $price = explode('-',$quey_string_slug['price'][0]);
        if( count($price) == 1)
          { 
            $ads_results->where('price','>=', $price[0]);
            $query_string_array['price'] = " AND price >='".$price[0]."'";

        }else if(count($price) == 2 && $price[0]== ""){ 
            $ads_results->where('price','<=', $price[1]);
            $query_string_array['price'] = " AND price <='".$price[0]."'";
        }
        else if(count($price) == 2 && $price[1]== ""){
             $ads_results->where('price','>=', $price[0]);
             $query_string_array['price'] = " AND price >='".$price[0]."'";
        }
        else 
        {
           $ads_results->whereBetween('price', [$price[0], $price[1]]);
           $query_string_array['price'] = " AND price BETWEEN '".$price[0]."' AND '".$price[1]."'";
        }

        $searchFilters['price_'.$quey_string_slug['price'][0]] = $quey_string_slug['price'][0]; 

      }
      if(Arr::has($quey_string_slug, 'millage'))
        {
          $millage = explode('-',$quey_string_slug['millage'][0]);
          if( count($millage) == 1)
          { 
            $ads_results->where('millage','>=', $millage[0]);
            $query_string_array['millage'] = " AND millage >='".$millage[0]."'";

          }else if(count($millage) == 2 && $millage[0]== ""){ 
            $ads_results->where('millage','<=', $millage[1]);
            $query_string_array['millage'] = " AND millage <='".$millage[0]."'";
          }
          else if(count($millage) == 2 && $millage[1]== ""){
             $ads_results->where('millage','>=', $millage[0]);
             $query_string_array['millage'] = " AND millage >='".$millage[0]."'";
          }
          else 
          {
           $ads_results->whereBetween('millage', [$millage[0], $millage[1]]);
           $query_string_array['millage'] = " AND millage BETWEEN '".$millage[0]."' AND '".$millage[1]."'";
         }

         $searchFilters['millage_'.$quey_string_slug['millage'][0]] = $quey_string_slug['millage'][0];

        }

    if(Arr::has($quey_string_slug, 'ver'))
        {
          $versions = array();
          foreach($quey_string_slug['ver'] as $vers)
            {
              $versionArray = explode('-',$vers);
              $versions[]   = str_replace("!", " / ", trim($versionArray[0]));
              $enginecc[]   = trim($versionArray[1]);
              $power[]      = trim($versionArray[3]);
            } 
          $enginecc                = array_filter($enginecc);
          $power                   = array_filter($power);
          $search_query            = $quey_string_slug['ver'];
          $quey_string_slug['ver'] = $versions; 
          $ads_results->whereIn('v.label',$quey_string_slug['ver']);

          if(!empty($power)){ 
            $ads_results->whereIn('v.cc',$power); 
          }
          if(!empty($enginecc)){
            $ads_results->whereIn('v.kilowatt',$enginecc); 
          }
          $quey_string_slug['ver'] = $search_query; 

          $searchFilters['ver_'.$quey_string_slug['ver'][0]] = $quey_string_slug['ver'][0];
             
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

           $searchFilters['power_'.$quey_string_slug['power'][0]] = $quey_string_slug['power'][0];
        }


        if(Arr::has($quey_string_slug, 'enginecc'))
        {
          $enginecc = explode('-',$quey_string_slug['enginecc'][0]);
          if( count($enginecc) == 1)
          { 
            $ads_results->where('v.cc','>=', $enginecc[0]);
            $query_string_array['enginecc'] = " AND v.cc >='".$enginecc[0]."'";

          }else if(count($enginecc) == 2 && $enginecc[0]== ""){ 
            $ads_results->where('v.cc','<=', $enginecc[1]);
            $query_string_array['enginecc'] = " AND v.cc <='".$enginecc[0]."'";
          }
          else if(count($enginecc) == 2 && $enginecc[1]== ""){
             $ads_results->where('v.cc','>=', $enginecc[0]);
             $query_string_array['enginecc'] = " AND v.cc >='".$enginecc[0]."'";
          }
          else 
          {
           $ads_results->whereBetween('v.cc', [$enginecc[0], $enginecc[1]]);
           $query_string_array['enginecc'] = " AND v.cc BETWEEN '".$enginecc[0]."' AND '".$enginecc[1]."'";
         } 

         $searchFilters['enginecc_'.$quey_string_slug['enginecc'][0]] = $quey_string_slug['enginecc'][0];

        }
        $activeLanguage = \Session::get('language');
        
        if(Arr::has($quey_string_slug, 'fuel'))
          {
           /* $ads_results->whereIn('fuel_type',$quey_string_slug['fuel']);
            $list = "'". implode("', '", $quey_string_slug['fuel']) ."'";
            $query_string_array['fuel'] = " AND fuel_type IN(".$list.")";

            $searchFilters['fuel_'.$quey_string_slug['fuel'][0]] = 'Engine Type '.$quey_string_slug['fuel'][0];*/ 
            
          $ads_results->leftJoin('engine_types_description AS etd','etd.engine_type_id','=','ads.fuel_type');

          $ads_results->whereIn('etd.title',$quey_string_slug['fuel']);
          $list = "'". implode("', '", $quey_string_slug['fuel']) ."'";
          $query_string_array['fuel'] = " AND etd.title IN(".$list.") ";
          $searchFilters['fuel_'.$quey_string_slug['fuel'][0]] = $quey_string_slug['fuel'][0];
          $searchTables      .= ' INNER JOIN engine_types_description etd ON etd.engine_type_id=a.fuel_type ';
          $searchFuel = ' INNER JOIN engine_types_description etd ON etd.engine_type_id=a.fuel_type ';
          $fuelWhere  = ' AND etd.language_id='.$activeLanguage['id'];
          }
          else{
            $searchFuel = ' INNER JOIN engine_types_description etd ON etd.engine_type_id=a.fuel_type ';
            $fuelWhere  = ' AND etd.language_id='.$activeLanguage['id'];
          }

        if(Arr::has($quey_string_slug, 'transmission'))
        {
          /*$ads_results->whereIn('transmission_type',$quey_string_slug['transmission']);
          $list = "'". implode("', '", $quey_string_slug['transmission']) ."'";
          $query_string_array['transmission'] = " AND transmission_type IN(".$list.")";
          $searchFilters['transmission_'.$quey_string_slug['transmission'][0]] = 'Transmission '.$quey_string_slug['transmission'][0];*/
            $ads_results->leftJoin('transmission_description AS gbd','gbd.transmission_id','=','ads.transmission_type');

          $ads_results->whereIn('gbd.title',$quey_string_slug['transmission']);
          $list = "'". implode("', '", $quey_string_slug['transmission']) ."'";
          $query_string_array['transmission'] = " AND gbd.title IN(".$list.") ";
          $searchFilters['transmission_'.$quey_string_slug['transmission'][0]] =$quey_string_slug['transmission'][0];
          $searchTables .= ' INNER JOIN transmission_description AS gbd ON gbd.transmission_id=a.transmission_type ';

          $searchTransmission = ' INNER JOIN transmission_description AS gbd ON gbd.transmission_id=a.transmission_type ';
          $transmissionWhere = ' AND gbd.language_id='.$activeLanguage['id'];
      
        }
        else{
          $searchTransmission = ' INNER JOIN transmission_description AS gbd ON gbd.transmission_id=a.transmission_type ';
          $transmissionWhere = ' AND gbd.language_id='.$activeLanguage['id'];
        }
        if(Arr::has($quey_string_slug, 'cl'))
        {
          $select_array[] = 'cld.name as color_name';
          $select_array[] = 'cld.color_id';
          $ads_results->leftJoin('colors_description AS cld', 'cld.color_id', '=', 'ads.color_id');
          $ads_results->whereIn('cld.name',$quey_string_slug['cl']);
          $list = "'". implode("', '", $quey_string_slug['cl']) ."'";
          $query_string_array['colors'] = " AND cld.name IN(".$list.")";
          $searchFilters['cl_'.$quey_string_slug['cl'][0]] = $quey_string_slug['cl'][0];
          $searchTables .= ' INNER JOIN colors_description AS cld ON cld.color_id=a.color_id ';
          $searchColor = ' INNER JOIN colors_description AS cld ON cld.color_id=a.color_id ';
          $colorWhere = ' AND cld.language_id='.$activeLanguage['id'];
        }
        else{
          $searchColor = ' INNER JOIN colors_description AS cld ON cld.color_id=a.color_id ';
          $colorWhere = ' AND cld.language_id='.$activeLanguage['id'];
        }

    if(Arr::has($quey_string_slug, 'bt'))
        {
          $ads_results->leftJoin('body_types_description AS btd', 'btd.body_type_id', '=', 'ads.body_type_id');

          $ads_results->whereIn('btd.name',$quey_string_slug['bt']);
          $list = "'". implode("', '", $quey_string_slug['bt']) ."'";
          $query_string_array['bodyTypes'] = " AND btd.name IN(".$list.")"; 

          $searchFilters['bt_'.$quey_string_slug['bt'][0]] = $quey_string_slug['bt'][0];
          $searchTables .= ' INNER JOIN body_types_description AS btd   ON btd.body_type_id=a.body_type_id ';
          $searchBodyType = ' INNER JOIN body_types_description AS btd   ON btd.body_type_id=a.body_type_id ';
          $bodyTypeWhere = ' AND btd.language_id='.$activeLanguage['id'];

        }else{
          $searchBodyType = ' INNER JOIN body_types_description AS btd   ON btd.body_type_id=a.body_type_id ';
          $bodyTypeWhere = ' AND btd.language_id='.$activeLanguage['id'];
        }


    if(Arr::has($quey_string_slug, 'ct'))
      {
        $ads_results->leftJoin('cities AS c', 'c.id', '=', 'ads.poster_city');
        $ads_results->whereIn('c.name', $quey_string_slug['ct']);
        $cities = City::whereIn('c.name',$quey_string_slug['ct'])->where('status',1); 
        $list = "'". implode("', '", $quey_string_slug['ct']) ."'";
        $query_string_array['cities'] = " AND c.name IN(".$list.")"; 
        $searchFilters['ct_'.$quey_string_slug['ct'][0]] = $quey_string_slug['ct'][0];
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
          $searchCity = ' INNER JOIN cities c ON c.id=a.poster_city '; 
    } else{
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


    if(Arr::has($quey_string_slug, 'ctreg'))
        {
          $cities = City::whereIn('c.name',$quey_string_slug['ctreg'])->where('status',1);
          $list   = "'". implode("', '", $quey_string_slug['ctreg']) ."'";
          $query_string_array['cities'] = " AND c.name IN(".$list.")";

        }
    if(Arr::has($quey_string_slug, 'ec'))
        {
            $colors = Color::whereIn('name',$quey_string_slug['ec']);

        }

    if (Arr::has($quey_string_slug, 'seller')) {
        $ads_results->join('customers AS cr', 'ads.customer_id', '=', 'cr.id');
        $ads_results->where('cr.customer_role','=', $quey_string_slug['seller']);
        $searchFilters['seller_'.$quey_string_slug['seller'][0]] = ucfirst($quey_string_slug['seller'][0]);
      }

         if(Arr::has($quey_string_slug, 'pic'))
        { 
          $ads_results->join('ad_images AS p', 'p.ad_id', '=', 'ads.id');
          $searchFilters['pic_'.$quey_string_slug['pic'][0]] = $quey_string_slug['pic'][0];

         } else {
          $ads_results->leftJoin('ad_images AS p', 'p.ad_id', '=', 'ads.id');
         }

         
        if(Arr::has($quey_string_slug, 'tg'))
        {
          $ads_results->with('tags');
          $ads_results->leftJoin('ad_tag AS as', 'ads.id', '=', 'as.ad_id');
          $ads_results->leftJoin('tags AS s', 's.id', '=', 'as.tag_id');

          $ads_results->whereIn('s.id',$quey_string_slug['tg']);
         /* $list = "'". implode("', '", $quey_string_slug['tg']) ."'"; 
          $query_string_array['models'] = " AND mo.name IN(".$list.")"; */
          $tagsQuery   = Tag::query()->select("id", "cd.name");
        $tagsQuery->join('tag_description AS cd', 'tags.id', '=', 'cd.tag_id')->where('language_id', $activeLanguage['id'])->whereIn('tags.id',$quey_string_slug['tg']);
        $tags        = $tagsQuery->get();

          foreach($tags as $tag)
          {
            $searchFilters['tg_'.$tag->id] =$tag->name;
          }
        } 

    $tagsQuery   = Tag::query()->select("id", "cd.name");
        $tagsQuery->join('tag_description AS cd', 'tags.id', '=', 'cd.tag_id')->where('language_id', $activeLanguage['id']);
        $tags        = $tagsQuery->get(); 

    //echo $result    = $ads_results->toSql();exit;
    if(!empty(request()->get('sortby'))){
      $sortBy = request()->get('sortby');
      $ads_results->orderByRaw('ads.' . $sortBy);
    }
    else{
      $ads_results->orderByRaw('ads.' . 'updated_at desc');
    }


    $ads_results->select($select_array);
    $search_result  = $ads_results->paginate(10); 
    $side_bar_array = array();
    $ads_status     = " WHERE a.status=1 ";
    #################### MAKES ####################################
    $whereCondition = "SELECT count(m.id) as total_ads_in_makes,m.id,m.title 
      FROM ads a
      INNER JOIN makes AS  m    ON m.id=a.maker_id ";
     // $whereCondition .= $this->createWhereCondtion($query_string_array,'makes');
      $whereCondition .= $ads_status." GROUP BY m.id";   
      $side_bar_array['makes'] = $this->getSelect($whereCondition);
      if(isset($_REQUEST['test'])){

        echo $whereCondition.'<pre>';
        print_r($side_bar_array);
        exit;
        
      }
       #################### MODEL ####################################
      $whereCondition = "SELECT count(mo.id) as total_ads_in_models,mo.id,mo.name 
      FROM ads a 
      INNER JOIN models  AS  mo ON mo.id=a.model_id ";
       $whereCondition .= $ads_status." GROUP BY mo.id";  
      $side_bar_array['models'] = $this->getSelect($whereCondition);

      #################### COLORS COUNT ##############################
      $whereCondition = "SELECT count(cld.color_id) as total_ads_in_color,cld.color_id,cld.name FROM ads a ".$searchColor;
       $whereCondition .= $ads_status.$colorWhere." GROUP BY cld.color_id";  
      $side_bar_array['colors'] = $this->getSelect($whereCondition);  

       #################### BODY TYPES COUNT ############################## 
      $whereCondition = "SELECT count(btd.body_type_id) as total_ads_in_body, btd.body_type_id,btd.name FROM ads a  ".$searchBodyType;
       $whereCondition .= $ads_status.$bodyTypeWhere." GROUP BY btd.body_type_id"; 
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
      $whereCondition = "SELECT count(c.id) as total_ads_in_cities,c.id,c.name FROM ads a  " .$searchCity;
       $whereCondition .= $ads_status." GROUP BY c.id";

      $side_bar_array['locations'] = $this->getSelect($whereCondition); 


  #################### TRANSMISSION COUNT ############################## 
      $whereCondition = "SELECT count(gbd.transmission_id) as total_ads_in_transmission,gbd.transmission_id,gbd.title FROM ads a ". $searchTransmission; 
       $whereCondition .= $ads_status.$transmissionWhere." GROUP BY gbd.transmission_id";
      $side_bar_array['transmission'] = $this->getSelect($whereCondition);
      #################### FUEL TYPE COUNT ############################## 

      $whereCondition = "SELECT count(etd.engine_type_id) as total_ads_in_fuel,etd.engine_type_id,etd.title FROM ads a   ".$searchFuel;
        $whereCondition .= $ads_status.$fuelWhere." GROUP BY etd.engine_type_id";  
      $side_bar_array['fuel'] = $this->getSelect($whereCondition); 
      foreach($quey_string_slug as $keys => $values){
        foreach($values as $data){
          $new_string    = $params; 
          $link          = str_replace($keys.'_'.$data.'/', '', $new_string);
          $link          = str_replace('/'.$keys.'_'.$data, '', $link);
          if($data == 'list') continue;

          if (isset($searchFilters[$keys.'_'.$data]) && !empty($searchFilters[$keys.'_'.$data])) {
              $data          = $searchFilters[$keys.'_'.$data];
          }

          $searched_keywords .= '<li class="align-items-center d-flex justify-content-between">'.$data.'<a target="_blank" href="'.url('/').'/search/'.$link. '" class="sortBy"> <span class="fa fa-close themecolor2"></a></span></li>';
        }
    }
    $sortBy = '';
    if(!empty(request()->get('sortby'))){
      $sortBy = request()->get('sortby');
    }

    // dd($side_bar_array);
    // dd($search_result->count());
    return view('guest.search_listing',compact('sortBy','search_result','searched_keywords','side_bar_array','quey_string_slug','tags'));
  }
    //
    public function simpleSearch1($params){ 
    
    if($params) 
        {
            $quey_string_slug = array();
            $params = explode('/', $params);
            //do stuff 
            foreach($params as $parm)
            {
                $new_array      = explode("_",$parm);
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
        $select_array = array('fuel_type','description','year','millage','fuel_average',
            'price','vat','neg','features','transmission_type','assembly',
            'doors','length','height','width','poster_name','poster_email','poster_phone',
            'is_featured','views','status','maker_id','mo.id as model_id','version_id',
            'customer_id',
            'm.title as make_name','mo.name as model_name','color_id','cld.name as color_name',
            'v.label as version_label','v.cc as engine_capacity','v.kilowatt AS engine_power', 'c.name as city_name',DB::raw('DATE_FORMAT(current_date(), "%d-%m-%Y") - DATE_FORMAT(ads.updated_at, "%d-%m-%Y") as last_updated'));

        $ads_results->select($select_array);
        $ads_results->join( 'makes AS m', 'm.id', '=', 'ads.maker_id');
        $ads_results->join( 'versions AS v', 'v.id', '=', 'ads.version_id');
        $ads_results->join( 'cities AS c', 'c.id', '=', 'ads.city_id');
        $ads_results->join( 'models AS mo', 'mo.id', '=', 'ads.model_id');
        $ads_results->join( 'colors AS cl', 'cl.id', '=', 'ads.color_id');
        $ads_results->where('status','0'); 
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
                $makes_array    = explode('-',$car_make_model);
                $query_string .= '&car_make_model='.$car_make_model; 
                $searched_keywords_array['car_make_model'] = $car_make_model;
                $array_first    = head($makes_array);
                $array_last     = last($makes_array);
                if($array_first == 'makes'){ 
                    $ads_results->where('m.title', $array_last);
                    $query_string_array['car_make_model'] = " AND m.title = '".$array_last."'"; 

                }else
                { 
                    $ads_results->where('mo.name',$array_last);
                   $query_string_array['car_make_model'] = " AND mo.name = '".$array_last."'"; 
                }

            }

        if ($request->filled('selectCity1')) { 
            $selectCity1 = $search_string['selectCity1']; 
            $ads_results->whereIn('c.name',array($selectCity1));
            $query_string .= '&selectCity1='.$selectCity1;
            $query_string_array['selectCity1'] = " AND c.name IN('".$selectCity1."')";
            $searched_keywords_array['selectCity1'] = $selectCity1;
        }

         if ($request->filled('tags')) { 
            $tags = implode(',',$search_string['tags']);
            $where .= "AND tags = '".$tags."' "; 
            $query_string .= '&tags='.$tags;
            $query_string_array['tags'] = " AND tags = '".$array_last."'";
            $searched_keywords_array['selectCity1'] = $tags;
        }
        if ($request->filled('selectCity')) { 
                $selectCity = $search_string['selectCity'];
                $ads_results->whereIn('c.name',array($selectCity));                
                $query_string .= '&selectCity='.$selectCity;
                $query_string_array['selectCity'] =  " AND c.name IN('".$selectCity."')";
                $searched_keywords_array['selectCity'] = $selectCity;
            }

        if ($request->filled('minPrice') && $request->filled('maxPrice')) {
            $ads_results->whereBetween('price', [$search_string['minPrice'],$search_string['maxPrice']]);
            $query_string_array['minPrice'] =  " AND price > '".$search_string['minPrice']."' ";
            $query_string_array['maxPrice'] =  " AND price < '".$search_string['maxPrice']."' ";
            $searched_keywords_array['minPrice'] = $minPrice;
            $searched_keywords_array['maxPrice'] = $maxPrice;
        }// ENDIF
        else{
            if ($request->filled('minPrice')) { 
                $minPrice = $search_string['minPrice']; 
                $ads_results->where('price', $minPrice);           
                $query_string .= '&minPrice='.$minPrice;
                $query_string_array['minPrice'] = " AND price = '".$minPrice."'";
                $searched_keywords_array['minPrice'] = $minPrice;
            }
            if ($request->filled('maxPrice')) { 
                $maxPrice = $search_string['maxPrice']; 
                $ads_results->where('price', $maxPrice);                          
                $query_string .= '&maxPrice='.$maxPrice;
                $query_string_array['maxPrice'] =  " AND price = '".$maxPrice."'";            
                $searched_keywords_array['maxPrice'] = $maxPrice;
            }

        } // END ELSE

        if ($request->filled('selectCityArea')) { 
                $selectCityArea = $search_string['selectCityArea']; 
                $query_string .= '&selectCityArea='.$selectCityArea;
                $query_string_array['selectCityArea'] = $selectCityArea;
                $where .=  " AND c.name IN('".$selectCityArea."')";
                $searched_keywords_array['selectCityArea'] = $selectCityArea;
        }
        if ($request->filled('selectVersion')) { 
                $selectVersion = $search_string['selectVersion'];
                $where .= "AND selectVersion = '".$selectVersion."' ";
                $ads_results->where('v.id',$selectVersion);                
                $query_string .= '&selectVersion='.$selectVersion;
                $query_string_array['selectVersion'] = " AND v.id = '".$selectVersion."'";
        } 

        if ($request->filled('selectYearFrom') && $request->filled('selectYearTo')) { 
            $ads_results->whereBetween('year', [$search_string['selectYearFrom'],$search_string['selectYearTo']]);

                $query_string .= '&selectYearFrom='.$search_string['selectYearFrom'].'&selectYearTo='.$search_string['selectYearTo']; 
                $query_string_array['selectYearFrom'] = "AND year >= '".$search_string['selectYearTo']."' ";
                $query_string_array['selectYearTo']   =   " AND year <= '".$search_string['selectYearFrom']."'"; 

        }// ENDIF

        else{
            if ($request->filled('selectYearFrom')) {                
                $selectYearFrom = $search_string['selectYearFrom'];
                $ads_results->where('year', $selectYearFrom);
                $query_string .= '&selectYearFrom='.$selectYearFrom;
                $query_string_array['selectYearFrom']   =  " AND year = '".$selectYearFrom."'";
            }
            if ($request->filled('selectYearTo')) {  
                $selectYearTo = $search_string['selectYearTo'];
                $ads_results->where('year', $selectYearTo);
                $query_string .= '&selectYearTo='.$selectYearTo;
                $query_string_array['selectYearTo']   = " AND year = '".$selectYearTo."'";
            }

        } // END ELSE
 
         if ($request->filled('engine_type')) { 
                $fuel_type = $search_string['engine_type']; 
                $ads_results->where('fuel_type',$fuel_type);
                $query_string .= '&fuel_type='.$fuel_type;
                $query_string_array['engine_type']   =  " AND fuel_type = '".$fuel_type."'";   
        } 

        if ($request->filled('CapacityFrom') && $request->filled('CapacityTo')) { 
            $ads_results->whereBetween('fuel_average', [$search_string['CapacityFrom'],$search_string['CapacityTo']]);
            $query_string .= '&CapacityFrom='.$request->filled('CapacityFrom').'&CapacityTo='.$request->filled('CapacityTo');
            $query_string_array['CapacityFrom'] =  " AND fuel_average >= '".$search_string['CapacityTo']."'"; 
            $query_string_array['CapacityTo']   =  " AND fuel_average <= '".$search_string['CapacityFrom']."'"; 

        }// ENDIF

        else{
            if ($request->filled('CapacityFrom')) {                
                $CapacityFrom = $search_string['CapacityFrom'];
                $ads_results->where('fuel_average', $CapacityFrom);
                $query_string .= '&CapacityFrom='.$CapacityFrom;
                $query_string_array['CapacityFrom']   = " AND fuel_average = '".$CapacityTo."' "; " AND fuel_average = '".$CapacityFrom."' "; 
            }
            if ($request->filled('CapacityTo')) {  
                $CapacityTo = $search_string['CapacityTo'];
                $ads_results->where('fuel_average', $CapacityTo);                
                $query_string .= '&CapacityTo='.$CapacityTo;
                $query_string_array['CapacityTo']   = " AND fuel_average = '".$CapacityTo."' "; 
            }

        } // END ELSE
 
        if ($request->filled('MileageFrom') && $request->filled('MileageTo')) { 
            $ads_results->whereBetween('millage', [$search_string['MileageFrom'],$search_string['MileageTo']]);

            $query_string .= '&MileageFrom='.$request->filled('MileageFrom').'&MileageTo='.$request->filled('MileageTo');
            $query_string_array['MileageFrom']   = " AND millage >= '".$search_string['MileageFrom']."'";

            $query_string_array['MileageTo']   =  "AND millage <=  '".$search_string['MileageTo']."'"; 

        }// ENDIF

        else{
            if ($request->filled('MileageFrom')) {                
                $MileageFrom = $search_string['MileageFrom'];
                $ads_results->where('millage', $MileageFrom);
                $query_string .= '&MileageFrom='.$MileageFrom;
                $query_string_array['MileageFrom']   =   " AND millage = '".$MileageFrom."' ";
            }
            if ($request->filled('MileageTo')) {  
                $MileageTo = $search_string['MileageTo'];
                $ads_results->where('millage', $MileageTo);
                $query_string .= '&MileageTo='.$MileageTo;
                $query_string_array['MileageTo']   =   " AND millage = '".$MileageTo."' "; 
            }

        } // END ELSE

        if ($request->filled('body_type')) { 
                $body_type    = $search_string['body_type'];
                $btype = '';
                foreach($body_type as $bt){
                    if($btype !='')
                     $btype .= ',';   
                  $btype .= "'$bt'";
                }

                $ads_results->whereIn('b.name', $body_type);
                $query_string .= '&body_type='.implode(',',$body_type);
                $query_string_array['body_type']  = " AND b.name IN('".implode(',',$body_type)."') "; 
                $searched_keywords_array['body_type'] = $body_type;   
        }

        if ($request->filled('color')) { 
                $color = $search_string['color']; 
                dd( $color);
                $ads_results->whereIn('cld.name', [$color]); 
                $query_string .= '&color='.$color;
                $query_string_array['color']  =  " AND cld.name IN('".$color."') ";
                $searched_keywords_array['color'] = $color;
        }

        if ($request->filled('have_picture')) { 
                $have_picture = $search_string['have_picture'];
                $query_string .= '&have_picture='.$have_picture;
                $query_string_array['have_picture'] = " AND have_picture = '".$have_picture."' ";   
        }

        if ($request->filled('ads_type')) { 
                $ads_type = $search_string['ads_type'];
                $query_string .= '&ads_type='.$ads_type;
                $query_string_array['ads_type']   = " AND ads_type = '".$ads_type."' ";  
        }

         if ($request->filled('is_featured')) { 
                $is_featured = $search_string['is_featured'];
                $ads_results->where('is_featured', $is_featured);
                $query_string .= '&is_featured='.$is_featured;
                $query_string_array['is_featured']   = " AND is_featured = '".$is_featured."' "; 
        }

        if ($request->filled('RegCity')) { 
            $RegCity = $search_string['RegCity'];
            $ads_results->where('poster_city', $RegCity); 
            $query_string .= '&RegCity='.$RegCity;
            $query_string_array['RegCity']   = " AND poster_city = '".$RegCity."' ";
        }

        if ($request->filled('assembly')) { 
            $assembly = $search_string['assembly']; 
            $ads_results->where('assembly', $assembly);
            $query_string .= '&assembly='.$assembly; 
            $query_string_array['assembly']   =  " AND assembly = '".$assembly."' ";
        }

        if ($request->filled('transmission')) { 
            $transmission = $search_string['transmission']; 
            $ads_results->where('transmission_type', $transmission); 
            $query_string .= '&transmission='.$transmission;
            $query_string_array['transmission']   = " AND transmission_type = '".$transmission."' "; 
        } 

     //$ads_results->paginate(2);
      /*$query = DB::getQueryLog();
      $result = $ads_results->toSql();
      echo $result;exit;*/

      $searched_keywords = '';
      foreach($searched_keywords_array as $keys => $values){
        $new_string    = $query_string; 
        $link = str_replace('&'.$keys.'='.$values, '', $new_string);
        $searched_keywords .= '<li class="align-items-center d-flex justify-content-between"><a target="_blank" href="'.$link.'">'.$values.'</a> <span class="fa fa-close themecolor2"></span></li>';
    }
    
      $search_result= $ads_results->paginate(20);
      $side_bar_array = array();
      #################### MAKES ####################################
      $whereCondition = "SELECT count(m.id) as total_ads_in_makes,m.id,m.title 
      FROM ads a
      INNER JOIN makes    AS m  ON m.id=a.maker_id
      INNER JOIN colors   AS cl ON cl.id=a.color_id  
      INNER JOIN versions AS v  ON v.id=a.version_id 
      INNER JOIN cities   AS c  ON c.id=a.city_id
      INNER JOIN models   AS mo ON mo.id=a.model_id";
      $whereCondition .= $this->createWhereCondtion($query_string_array,'makes');

      $whereCondition .= " GROUP BY m.id";  
      $side_bar_array['makes'] = $this->getSelect($whereCondition); 

      #################### COLORS COUNT ##############################
      $whereCondition = "SELECT count(cl.id) as total_ads_in_color,cl.id,cl.name FROM ads a INNER JOIN colors cl ON cl.id=a.color_id  
        INNER JOIN makes AS m ON m.id=a.maker_id 
        INNER JOIN versions AS v
        ON v.id=a.version_id 
        INNER JOIN cities AS c ON c.id=a.city_id
        INNER JOIN models AS mo ON mo.id=a.model_id ";
      $whereCondition .= $this->createWhereCondtion($query_string_array,'color');

      $whereCondition .= " GROUP BY cl.id";  
      $side_bar_array['colors'] = $this->getSelect($whereCondition);  
       #################### BODY TYPES COUNT ############################## 
      $whereCondition = "SELECT count(b.id) as total_ads_in_body, b.id,b.name FROM ads a INNER JOIN body_types b ON b.id=a.body_type_id 
      INNER JOIN colors cl ON cl.id=a.color_id 
        INNER JOIN makes AS m ON m.id=a.maker_id INNER JOIN versions AS v
         ON v.id=a.version_id INNER JOIN cities AS c ON c.id=a.city_id
         INNER JOIN models AS mo ON mo.id=a.model_id ";
      $whereCondition .= $this->createWhereCondtion($query_string_array,'body_type');

      $whereCondition .= " GROUP BY b.id";  
      $side_bar_array['bodyTypes'] = $this->getSelect($whereCondition); 
       #################### BODY TYPES COUNT ##############################

      return view('guest.search_listing',compact('search_result','searched_keywords','side_bar_array')); 
    }
    //100 gm mete 100 gm kalwange mix , 5 drops zaton,shehid 
    //5 karjoor , 5 badaam , 1/2 = white till
//https://phppot.com/jquery/jquery-ajax-autocomplete-country-example/
    private function createWhereCondtion($query_string_array, $skipKey)
    {
        $where = 'WHERE 1  '; 
        unset($query_string_array[$skipKey]);
        foreach ($query_string_array as $keys => $queryStr)
        {
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
    $services = Services::select('customer_id')->where('primary_service_id', $p_id)->whereHas('service_details', function ($query) use ($c_id, $sub_id) {
      $query->where('category_id', $c_id)->where('sub_category_id', $sub_id);
    })->get();
    // dd($services);
    $customer_ids = $services->unique('customer_id');
    $category     = PrimaryService::where('id', $p_id)->first();
    $cat          = SubService::where('id', $c_id)->first();
    if ($cat->is_make == 1) {
      $sub = Make::where('id', $sub_id)->first();
    } else {
      $sub = SubService::where('id', $sub_id)->first();
    }
    // dd($customer_ids);
    return view('guest.service_sub_category', compact('customer_ids', 'id', 'category', 'cat', 'sub'));
  }
  

    public function servicesSubCategorySearch1($params = null)
    {
      $subCatsChilds   = null;
      $category_id     = null;
      $subCategor      = null;
      $p_id            = null;
      $subCats         = null;
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

    $servicesQuery   = Services::query()->distinct('services.customer_id')->groupBy('services.customer_id');
    $servicesQuery->select("customer_id","c.citiy_id");
    $servicesQuery->join('service_details AS sd', 'services.id', '=', 'sd.service_id');
    $servicesQuery->join('customers AS c', 'services.customer_id', '=', 'c.id');

    $queryStringSearched = array();

    if (Arr::has($queyStringArray, 'featured')) {
      $featured = $queyStringArray['featured'][0];
      $servicesQuery->where('is_featured', $featured);

      if($featured == 'true'){ 
        $searchFilters['featured_' . $featured] = 'Featured';
        $queryStringSearched['featured'] = " AND is_featured='" . $featured . "' ";
      }else {
        $searchFilters['featured_' . $featured] = 'Un Featured';
        $queryStringSearched['unfeatured'] = " AND is_featured='" . $featured . "' ";
      } 
    }

    if (Arr::has($queyStringArray, 'ps')) {
      $p_id = $queyStringArray['ps'][0];
      $servicesQuery->where('sd.primary_service_id', $p_id);
      $category       = PrimaryService::where('id', $p_id)->first();
      $primaryServiceTitle = $category->title;
      $subCats        = SubService::where('primary_service_id', $p_id)->where('parent_id',0)->where('status',1)->get();
      $queryStringSearched['primary_service'] = " AND sd.primary_service_id='" . $p_id . "' ";
      $searchFilters['ps_'.$p_id] = $primaryServiceTitle;
      
      /* $params = str_replace('ps_' . $p_id, 'ps_' . $primaryServiceTitle, $params);
      $queyStringArray['ps'][0] = $primaryServiceTitle; */

      if (Arr::has($queyStringArray, 'cat')) {
        $category_id   = $queyStringArray['cat'][0]; 
        $servicesQuery->where('category_id', $category_id);
        $sub           = SubService::where('id', $category_id)->first();
        $queryStringSearched['subCategories'] = " AND sd.id =". $category_id."";
        $searchFilters['cat_'. $category_id] = $sub->title;
        if ($sub->is_make == 1) {
          $subCatsChilds = make::where('status',1)->get();
        } else  {
          $subCatsChilds = SubService::where('parent_id', $category_id)->where('status',1)->get();
        }

        if (Arr::has($queyStringArray, 'scat')) {
          $subCategor = $queyStringArray['scat'][0];
          $servicesQuery->where('sub_category_id', $subCategor);
          $queryStringSearched['subChildCategories'] = " AND sd.sub_category_id =" . $subCategor . "";
          if ($sub->is_make == 1) {
            $make = Make::where('id', $subCategor)->first();
            $searchFilters['scat_' . $subCategor] = $make->title;
          }
          else {
            $make = SubService::where('id', $subCategor)->first();
            $searchFilters['scat_' . $subCategor] = $make->title;
            }
        }// END IF

      }//END IF

    } // END IF

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
      $cityName = City::select('name')->whereIn('id', $city_id)->where('status',1)->get();
      // $cityName  = $cityName->name;
      $list      = "'" . implode("', '", $city_id) . "'";
      $queryStringSearched['cities'] = " AND c.city_id IN(" . $list . ")";
    }// END CITY CONDITION 

    //echo $result    = $servicesQuery->toSql();exit;
    $customer_ids =  $servicesQuery->get(); //$servicesQuery->paginate(10); 
    if(!$customer_ids->isEmpty()){
      $customers     = Customer::select('id', 'customer_firstname', 'customer_lastname', 'customer_company', 'logo', 'customers_telephone', 'customer_default_address')
        ->whereIn('id', $customer_ids)->paginate(10);
      }

    /* SEARCH KEY WORDS. */
    $searchedKeywords = '<div class="bg-white p-4"><ul class="list-unstyled mb-0 font-weight-semibold">';
    $citiesSet = true;
    foreach ($queyStringArray as $keys => $values) {
      foreach ($values as $data) {
        
        $new_string    = $params;
        $link = $new_string;
        if ($keys != 'ps'){
          if (Arr::has($queyStringArray, 'scat') && $keys == 'cat') { 
            $link = $new_string;
          }else{
            $link          = str_replace($keys . '_' . $data . '/', '', $new_string);
            $link          = str_replace('/' . $keys . '_' . $data, '', $link);
          }
          
        }
        if(isset($searchFilters[$keys . '_' . $data]) && !empty($searchFilters[$keys . '_' . $data])){
          $data          = $searchFilters[$keys . '_' . $data];
        }
          
        if (($keys == 'ct' || $keys == 'city') && $citiesSet) {
          foreach ($cityName as $cities) {
            $searchedKeywords .= '<li class="align-items-center d-flex justify-content-between">' . $cities->name . '<a target="_blank" href="' . url('/') . '/allservices/listing/' . $link . '"> <span class="fa fa-close themecolor2"></a></span></li>';
          }
          $citiesSet = false;
        } // END IF
        elseif ($keys == 'ct' || $keys == 'city') {
          continue;
        } else {
          $searchedKeywords .= '<li class="align-items-center d-flex justify-content-between">' . $data . '<a target="_blank" href="' . url('/') . '/allservices/listing/' . $link . '"> <span class="fa fa-close themecolor2"></a></span></li>';
        } // END ELSE
      }
    }
    $searchedKeywords .= '</ul></div>';

    /* searched in cities */
    $whereCondition  = "SELECT count(ct.id) as totalAdsInCities,ct.id,ct.name FROM services s
    INNER JOIN service_details AS sd ON s.id=sd.service_id
    INNER JOIN customers as c ON s.customer_id = c.id
    INNER JOIN cities AS ct ON ct.id=c.citiy_id ";

    $whereCondition .= $this->createWhereCondtion($queryStringSearched, 'cities');
    $whereCondition .= " GROUP BY c.id";
    //echo $whereCondition;exit;
    $sideBarArray['foundInCity'] = $this->getSelect($whereCondition);
    return view('guest.service_sub_category',compact('searchedKeywords','sideBarArray','customers','customer_ids', 'p_id','category', 'subCats', 'subCatsChilds','sub', 'queyStringArray','category_id','subCategories','subCategor'));
    
  }
  public function getSubServiceChildren(){
    if (request()->ajax()) {
      $parentCategory = request()->get('parentCategory');
      $isMake         = request()->get('isMake');
      $subCategory    = request()->get('subCategory');
      $html           = '<table class="table table-bordered" style="width: 102%;"><thead><tr><th>DETAILS</th> 
                    </tr></thead><tbody>';

      if($isMake){
        $subCats = make::where('status',1)->get();
      }
      else{
            $subCats      = SubService::where('parent_id', $parentCategory)->where('status',1)->get();
          }

      if (!$subCats->isEmpty()) {
        foreach ($subCats as $values) {
          $radioButton = '<input type="radio"  name="ssub_category"  class="search_check_submit radio d-none"  ';
          if($subCategory){
            $radioButton .= 'checked="checked"';
           }
          $radioButton .= 'value="scat_'. $values->id. '" id="makesCheckscat_' . $values->id . '" data-value="scat_' . $values->id . '" >';
          $html .= '<tr><td>'.$radioButton . '<a href="javascript:void(0)" class="search_check_submit subcat_check_submit" data-value="' . $values->id . '" >'. $values->title . '</a></td></tr>';
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

    public function postResetEmail(Request $request){
      $activeLanguage = \Session::get('language');
  $random = rand();
  $customer = Customer::where('customer_email_address',$request->customer_email_address)->first();
  if(@$customer == null){
    return redirect()->back()->with('msg','Email not found!');
  }
  $customer->password_reset_token = $random;
  $customer->save();

   if($customer){
         $data = [
           'id' =>  $customer->id,
           'password_reset_token' => $random,
            'firstname' => $request->customer_firstname,
            'lastname' => $request->customer_lastname,
            'email' => $request->customer_email_address,
            'fullname'=>$customer->customer_company,
        ];


        //dd($data);
        $templatee = EmailTemplate::where('type', 9)->first();
        $template = EmailTemplateDescription::where('email_template_id',$templatee->id)->where('language_id',$activeLanguage['id'])->first();
        Mail::to($request->customer_email_address)->send(new ResetPasswordMail($data, $template));
      }

      return redirect()->route('signin')->with('msg','A link is send to your email to reset password!');
}
    public function resetPasswordForm($id,$token){
      return view('users.reset_password_form',compact('id','token'));
    }
      public function resetPasswordFormPost(Request $request){

        $customer = Customer::find($request->id);

        if($customer->password_reset_token == $request->p_token){
          $customer->customer_password = bcrypt($request->password);
          $customer->save();

          // return redirect()->route('signin')->with('msg','Password Changed Successfully !');
          return response()->json(['done'=>true]);

        }
        else{
          return response()->json(['error'=>true]);
        }
      } 

      public function getSpecificParts(Request $request){
        // dd($request->all());
        $allSpareParts = SparePartAd::where('parent_id',@$request->parent_id)->where('category_id',@$request->secondary_id)->where('status',1)->get();
        $i = 0;
        $html_string = ' <div class="loader d-none loader_'.@$request->parent_id.'"></div>';
         if($allSpareParts->count() > 0){
                      foreach($allSpareParts as $singleService)
                      {
                       $html_string .= '<div class="col-md-4 col-sm-4 offered-services-col">
                          <figure class="align-items-center border d-flex justify-content-center mb-0 position-relative text-left">
                            <img src="'.url('public/uploads/ad_pictures/spare-parts-ad/'.@$singleService->id.'/'.@$singleService->get_one_image->img).'" alt="carish used cars for sale in estonia" class="img-fluid">
                          </figure>
                          <div class="p-lg-3 p-2 border border-top-0">
                            <h5 class="font-weight-semibold mb-2 overflow-ellipsis"><a target="_blank" href="'.url('spare-parts-details/'.@$singleService->id).'" class="stretched-link">'.@$singleService->title.'</a></h5>
                            <ul class="list-unstyled mb-0 font-weight-semibold">
                              <li class="d-flex themecolor3"><span class="mr-2"></span>$'.@$singleService->price.'</li>
                            </ul>
                          </div>
                        </div>';
                $i++;
                if($i == 6){
                $html_string .= '</div>
                    </div>
                    <div class="item">
                      <div class="row">';
                    $i = 0;
                }
            }
        }
                    
                    else{
                    $html_string .= '<div class="col-lg-12 text-center">
                        <h5 class="" style="margin-top: 6%;">'.Lang::get('search.no_record_found').'</h5>
                        </div>';
                        }

            return response()->json(['html' => $html_string, 'success' => true]);
    }

    public function getSpecificOfferServices(Request $request){
        $allSpareParts = Services::whereHas('service_details',function($query) use ($request){
          // dd($request->all());
          $query->where('primary_service_id',@$request->primary_id)->where('category_id',@$request->cat_id)->where('sub_category_id',@$request->sub_id);
        })->where('status',1)->get();
        // dd($allSpareParts);
        $i = 0;
        $html_string = ' <div class="loader d-none loader_'.@$request->parent_id.'"></div>';
         if($allSpareParts->count() > 0){
                      foreach($allSpareParts as $singleService)
                      {
                     $html_string .= '<div class="col-md-4 col-sm-4 offered-services-col">
                          <figure class="align-items-center border d-flex justify-content-center mb-0 position-relative text-left">
                            <img src="'.url('public/uploads/customers/logos/'.@$singleService->get_customer->logo).'" alt="carish used cars for sale in estonia" class="img-fluid">
                          </figure>
                          <div class="p-lg-3 p-2 border border-top-0">
                            <h5 class="font-weight-semibold mb-2 overflow-ellipsis"><a target="_blank" href="'.url('company_profile/'.@$singleService->customer_id).'" class="stretched-link">'.@$singleService->get_customer->customer_company.'</a></h5>
                            <ul class="list-unstyled mb-0 font-weight-semibold">
                              <li class="align-items-baseline d-flex"><span class="mr-2"><em class="fa fa-amp-maker fa-map-marker"></em></span> '.@$singleService->get_customer->customer_default_address.'</li>
                              <li class="d-flex themecolor3"><span class="mr-2"><em class="fa fa-phone"></em></span> '.@$singleService->get_customer->customers_telephone.'</li>
                            </ul>
                          </div>
                        </div>';
                        $i++;
                        if($i == 6){
                      $html_string .= '</div>
                    </div>
                    <div class="item">
                      <div class="row">';
                    $i = 0;
                    
                        }
                      }
                    }
                    else{
                        $html_string .= '<div class="col-lg-12 text-center">
                        <h5 class="" style="margin-top: 6%;">'.Lang::get('search.no_record_found').'</h5>
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
      $customer->save();
      return redirect('user/login')->with('verified','Yes Done'); 
    } 
}
