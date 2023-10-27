<?php

namespace App\Http\Controllers\Guest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Ad;
use App\Car;
use App\Tag;
use App\Models\Cars\Make;
use App\Models\Cars\Carmodel;
use App\Models\Cars\Version;
use App\Models\Cars\Features;
use Illuminate\Support\Arr;
use App\Suggesstion;
use App\Models\EngineType;
use App\Models\Cars\BodyTypes;
use App\Models\Transmission;
use App\SparePartAd;
use App\SparePartCategory;
use App\Models\Customers\PrimaryService;
use App\Models\Customers\SubService;
use App\Models\Customers\Customer;
use App\Page;
use App\PageDescription;
use Lang;
use App\AdImage;
use App\Models\Faq\Faq;
use App\Models\Faq\FaqsDescription;
use App\Models\Faq\FaqCategory;
use App\Models\Faq\FaqCategoryDescription;
use Carbon\Carbon;
use App\Models\Services;
use DB;
use App\Exceptions\CustomException;
use Illuminate\Support\Facades\Auth;
use CarTwoDb\Apis\BasebuyAutoApi;
use CarTwoDb\Apis\connectors\CurlGetConnector;
//use Spatie\ImageOptimizer\OptimizerChainFactory;
//use Spatie\ImageOptimizer\Optimizer;    
use ImageOptimizer;
use Image;
use Mail;
use App\Mail\CronJobTest;
use App\Models\TyreManufacturer;
use App\Models\WheelManufacturer;
use App\Models\Brand;

class IndexController extends Controller
{
    //

    public function index()
    {
        define("API_KEY", "info@carish.eecbb78eb66cac4770bc284b962ccec006");
        define("API_URL", "https://api.car2db.com/api/auto/v1/");
        $downloadFolder = $_SERVER['DOCUMENT_ROOT'] . '/';
        $lastDateUpdate = strtotime('01.01.2019 00:00:00'); // Date of the last API call to check first, and only then download file
        $idType         = 1; // Passenger cars (a complete list can be obtained through $basebuyAutoApi->typeGetAll())

        $basebuyAutoApi = new BasebuyAutoApi(
            new CurlGetConnector(API_KEY, API_URL, $downloadFolder)
        );

        try {
            if ($basebuyAutoApi->markGetDateUpdate($idType) > $lastDateUpdate) {
                $downloadedFilePath = $basebuyAutoApi->markGetAll($idType);
            }

            $fp = fopen($downloadedFilePath, 'r');
            if ($fp) {
                $ignoreFirst = true;
                while (!feof($fp)) {
                    if (!$ignoreFirst) {
                        $fileRow = fgets($fp, 999);
                        $fields = explode(",", $fileRow);
                        if (!empty($fields) && !empty($fields[0])) {
                            DB::table('car_make')
                                ->updateOrInsert(
                                    [
                                        'id_car_make' => str_replace("'", "", $fields[0]),
                                        'name' => str_replace("'", "", $fields[1])
                                    ],
                                    [
                                        'date_create' => str_replace("'", "", $fields[2]),
                                        'date_update' => str_replace("'", "", $fields[3]),
                                        'id_car_type' => str_replace("'", "", $fields[4])
                                    ]
                                );
                        }
                    }
                    $ignoreFirst = false;
                }
            } else {
                echo "Error opening file";
            }
            fclose($fp);
        } catch (Exception $e) {
            switch ($e->getCode()) {
                case 401:
                    echo '<pre>' . $e->getMessage() . "\nAn invalid API key was specified, or your key has expired. Contact support atsupport@basebuy.ru</pre>";
                    break;

                case 404:
                    echo '<pre>' . $e->getMessage() . "\nIt is impossible to build a result based on the specified query parameters. Check for the id_type parameter, which is required for all entities, except for the type itself.</pre>";
                    break;

                case 500:
                    echo '<pre>' . $e->getMessage() . "\nTemporary service interruptions.</pre>";
                    break;

                case 501:
                    echo '<pre>' . $e->getMessage() . "\nA non-existent action was requested for the specified entity.</pre>";
                    break;

                case 503:
                    echo '<pre>' . $e->getMessage() . "\nTemporary suspension of the service due to database update.</pre>";
                    break;

                default:
                    echo '<pre> The last message.' . $e->getMessage() . "</pre>";
            }
        }
    }
    public function getSparePartsDetais($id)
    {
        try {
            $spare_parts     = SparePartAd::where('id', $id)->where('status', 1)->first();
            if (empty($spare_parts) && Auth::guard('customer')->check()) {
                $user_id       = Auth::guard('customer')->user()->id;
                $spare_parts   = SparePartAd::where('id', $id)->where('customer_id', $user_id)->first();
            }

            $views           = $spare_parts->views + 1;
            SparePartAd::where('status', 1)->where('id', $id)
                ->update(['views' => $views, 'updated_at' => \Carbon\Carbon::parse($spare_parts->updated_at)->format("Y-m-d H:i:s")]);
            $sub_category    = @$spare_parts->category->parent_id;
            $parent_category = SparePartCategory::where('id', $sub_category)->first();
            $similar_Ads     = SparePartAd::where('id', '!=', $id)->where('parent_id', $parent_category->id)->where('status', 1)->limit(6)->get();
            $user            = Auth::guard('customer')->user();
            $checkSaved      = \Cookie::get('sparepartad' . $id);

            return view(
                'spare-parts-details',
                compact('spare_parts', 'parent_category', 'similar_Ads', 'id', 'user', 'checkSaved')
            );
        } catch (\Illuminate\Database\QueryException $ex) {
            $error = $ex->getMessage();
            return view('errors.500', compact('error'));
        } catch (\Exception $e) {
            $error = $e->getMessage();
            return view('errors.500', compact('error'));
        }
    }

    public function getCarDetails($id)
    {
        try {
            $page_title = '';
            $ads         = Ad::where('id', $id)->where('status', 1)->first();
            if (empty($ads) && Auth::guard('customer')->check()) {
                $user_id = Auth::guard('customer')->user()->id;
                $ads     = Ad::where('id', $id)->where('customer_id', $user_id)->first();
            }
            //$page_title = $ads->maker->title.' '.$ads->model->name.' '.$ads->year.' '.(empty($ads->versions))?'':$ads->versions->label;
            $page_title  = $ads->maker->title . ' ' . $ads->model->name . ' ' . $ads->year . ' ' . @$ads->versions->label;
            $similar_ads = Ad::where('id', '!=', $id)->where('model_id', $ads->model_id)->where('status', 1)->get();
            $views       = $ads->views + 1;
            Ad::where('status', 1)->where('id', $id)
                ->update(['views' => $views, 'updated_at' => Carbon::parse($ads->updated_at)->format("Y-m-d H:i:s")]);

            return view('car-details', compact('ads', 'similar_ads', 'page_title'));
        } catch (\Illuminate\Database\QueryException $ex) {
            $error = $ex->getMessage();
            return view('errors.500', compact('error'));
        } catch (\Exception $e) {
            $error = $e->getMessage();
            return view('errors.500', compact('error'));
        }
    }

    // public function getSlugWiseCarDetails(Request $request,$slug)
    // {
    //     $id = decrypt($request->ad_id);
    //     try {
    //         $page_title = '';
    //         $ads         = Ad::where('id', $id)->where('status', 1)->first();
    //         if (empty($ads) && Auth::guard('customer')->check()) {
    //             $user_id = Auth::guard('customer')->user()->id;
    //             $ads     = Ad::where('id', $id)->where('customer_id', $user_id)->first();
    //         }  
    //         //$page_title = $ads->maker->title.' '.$ads->model->name.' '.$ads->year.' '.(empty($ads->versions))?'':$ads->versions->label;
    //         $page_title  = $ads->maker->title.' '.$ads->model->name.' '.$ads->year.' '.@$ads->versions->label;
    //         $similar_ads = Ad::where('id', '!=', $id)->where('model_id', $ads->model_id)->where('status', 1)->get();
    //         $views       = $ads->views + 1;
    //         Ad::where('status', 1)->where('id', $id)
    //             ->update(['views' => $views, 'updated_at' => Carbon::parse($ads->updated_at)->format("Y-m-d H:i:s")]);

    //         return view('car-details', compact('ads', 'similar_ads','page_title'));
    //     } catch (\Illuminate\Database\QueryException $ex) {
    //         $error = $ex->getMessage();
    //         return view('errors.500', compact('error'));
    //     } catch (\Exception $e) {
    //         $error = $e->getMessage();
    //         return view('errors.500', compact('error'));
    //     }
    // }

    public function addSlug()
    {
        // dd('here');
        // $ads = Ad::all();
        // foreach($ads as $ad)
        // {
        //     $ad_maker = strtolower($ad->maker->title);
        //     $ad_maker = str_replace(" ", "-", $ad_maker);
        //     $ad_model = strtolower($ad->model->name);
        //     $ad_model = str_replace(" ", "-", $ad_model);
        //     $ad_title = $ad_maker.'-'.$ad_model;

        //     $ad->slug = $ad_title;
        //     $ad->save();
        // }

        $count = 0;
        $sp_categories = SparePartCategory::all();
        foreach($sp_categories as $category)
        {
            $category_title = strtolower($category->title);
            $hypen_seperated = str_replace(" ", "-", $category_title);
            $correct_slug = str_replace("&", "and", $hypen_seperated);

            $category->slug = $correct_slug;
            $category->save();
            $count = $count + 1;
        }

        // $primary_services = PrimaryService::all();
        // foreach($primary_services as $service)
        // {
        //     $ps_title = strtolower($service->title);
        //     $hypen_seperated = str_replace(" ", "-", $ps_title);
        //     $correct_slug = str_replace("&", "and", $hypen_seperated);
        //     $correct_slug = str_replace(",", "and", $hypen_seperated);

        //     $service->slug = $correct_slug;
        //     $service->save();
        //     $count = $count + 1;
        // }

        dd($count);

        // $sub_services = SubService::all();
        // foreach($sub_services as $service)
        // {
        //     $service_title = strtolower($service->title);
        //     $hypen_seperated = str_replace(" ", "-", $service_title);
        //     $correct_slug = str_replace("&", "and", $hypen_seperated);

        //     $service->slug = $correct_slug;
        //     $service->save();
        //     $count = $count + 1;
        // }

        // dd($count);
       


    }

    public function getServiceDetails($id)
    {
        try {
            $service_ads = Services::where('id', $id)->where('status', 1)->first();
            if (empty($service_ads) && Auth::guard('customer')->check()) {
                $user_id      = Auth::guard('customer')->user()->id;
                $service_ads  = Services::where('id', $id)->where('customer_id', $user_id)->first();
            }

            $views       = $service_ads->views + 1;
            Services::where('status', 1)->where('id', $id)
                ->update(['views' => $views, 'updated_at' => Carbon::parse($service_ads->updated_at)->format("Y-m-d H:i:s")]);
            $similar_ads     = Services::where('id', '!=', $id)->where('primary_service_id', $service_ads->primary_service_id)->where('status', 1)->get();
            return view('service-details', compact('service_ads', 'similar_ads'));
        } catch (\Illuminate\Database\QueryException $ex) {
            $error = $ex->getMessage();
            return view('errors.500', compact('error'));
        } catch (\Exception $e) {
            $error = $e->getMessage();
            return view('errors.500', compact('error'));
        }
    }

    public function search(Request $request)
    {
        //        dd($request->all());
        $maker_ids = Car::where('title', 'LIKE', '%' . $request->makemodel . '%')->where('parent_id', 0)->pluck('id')->toArray();
        $model_ids = Car::where('title', 'LIKE', '%' . $request->makemodel . '%')->where('parent_id', '!=', 0)->pluck('id')->toArray();

        $ads = Ad::query();
        if (count($model_ids) > 0) {
            $ads = $ads->whereIn('model_id', $model_ids);
        }
        if (count($maker_ids) > 0) {
            $ads = $ads->whereIn('maker_id', $maker_ids);
        }
        if ($request->city) {
            $ads->where('city_id', $request->city);
        }
        if ($request->minPrice) {
            $ads->where('price', '<=', (float) $request->minPrice);
        }
        $ads = $ads->where('status', 2)->get();
        return view('guest.allAds', compact('ads'));

        //        dd($ads->get());
        //        dd($maker_ids,$model_ids);
        //        dd($request->all());
    }

    public function getModels($id)
    {
        $models = Car::where('parent_id', $id)->get();
        $html = '';
        $html = $html . '<option value="" selected disabled="">Select Model</option>';

        foreach ($models as $model) {
            $html = $html . '<option value="' . $model->id . '" >' . $model->title . '</option>';
        }
        return $html;
    }

    public function advSearch(Request $request)
    {
        $ads = Ad::query();
        if ($request->city) {
            $ads->where('city_id', $request->city);
        }
        if ($request->maker) {
            if ($request->model) {
                $ads->where('model_id', $request->models);
            } else {
                $ads->where('maker_id', $request->maker);
            }
        }

        if ($request->color) {
            $ads->where('color_id', $request->color);
        }

        if ($request->price_from) {
            $ads->where('price', '>=', $request->price_from);
        }

        if ($request->price_to) {
            $ads->where('price', '<=', $request->price_to);
        }

        if ($request->m_from) {
            $ads->where('millage', '>=', $request->m_from);
        }

        if ($request->m_to) {
            $ads->where('millage', '<=', $request->m_to);
        }

        if ($request->year) {
            $ads->where('year_id', $request->year);
        }

        $ads = $ads->get();
        return view('guest.allAds', compact('ads'));
    }

    //MUTAHIR CODE
    public function listings()
    {
        return view('guest.listing');
    }

    //MUTAHIR CODE
    public function home()
    {

         /*$img = Image::make(public_path('Kaghan Valley, District Mansehra.jpg'));
         //$img->resize(14043, 9933);
         $img->resize(9000, 6009);
         $img->save(public_path('9000_6009_ao_siz.jpg'));*/
        
        $activeLanguage = \Session::get('language');
        $tagsQuery      = Tag::query()->select("id", "cd.name");
        $tagsQuery->join('tag_description AS cd', 'tags.id', '=', 'cd.tag_id')->where('language_id', $activeLanguage['id']);
        $tags        = $tagsQuery->where('status', 1)->get();
        // dd($tags);

        $cities       = \App\City::select('id', 'name', 'status')->where('status', 1)->get();


        $engineTypesQuery       = EngineType::query()->select("engine_type_id", "et.title");
        $engineTypesQuery->join('engine_types_description AS et', 'engine_types.id', '=', 'et.engine_type_id')->where('language_id', $activeLanguage['id']);
        $engineTypes            = $engineTypesQuery->where('status', 1)->orderBy('et.title')->get();

        $transmissionQuery      = Transmission::query()->select("transmission_id", "t.title");
        $transmissionQuery->join('transmission_description AS t', 'transmissions.id', '=', 't.transmission_id')->where('language_id', $activeLanguage['id']);
        $transmissions          = $transmissionQuery->where('status', 1)->orderBy('t.title')->get();

        $featured_ads           = Ad::select('ads.id', 'maker_id', 'model_id', 'year', 'price', 'is_featured', 'ads.status')->join('makes AS m', 'm.id', '=', 'ads.maker_id')->where('is_featured', 'true')->where('ads.status', 1)->where('m.status', 1)->limit(16)->orderBy('ads.updated_at', 'DESC')->get();

        $ads = Ad::select('ads.id', 'maker_id', 'model_id', 'year', 'price', 'is_featured', 'ads.status')->join('makes AS m', 'm.id', '=', 'ads.maker_id')->where('is_featured', 'false')->where('ads.status', 1)->where('m.status', 1)->limit(16)->orderBy('ads.updated_at', 'DESC')->get();

        $spare_parts_categories = SparePartCategory::where('parent_id', 0)->where('status', 1)->where('status', 1)->orderBy('title', 'ASC')->get();

        $offered_services       = PrimaryService::where('status', 1)->orderBy('title', 'ASC')->get();


        $page_descriptionQuery = Page::query()->select("pd.title", "pd.description");
        $page_descriptionQuery->join('page_desciption AS pd', 'pages.id', '=', 'pd.page_id')->where('pd.language_id', $activeLanguage['id']);
        $page_description = $page_descriptionQuery->where('slug', 'about_us')->first();

        return view('welcome', compact('tags', 'cities', 'ads', 'featured_ads', 'spare_parts_categories', 'offered_services', 'engineTypes', 'transmissions', 'page_description'));
    }

    /**
     *  
     *
     * @return \Illuminate\Http\Response
     */
    public function carComparison()
    {
        $activeLanguage = \Session::get('language');
        $page_descriptionQuery = Page::query()->select("pd.title", "pd.description");
        $page_descriptionQuery->join('page_desciption AS pd', 'pages.id', '=', 'pd.page_id')->where('language_id', $activeLanguage['id']);

        $page_description = $page_descriptionQuery->where('page_id', 6)->first();
        return view('guest.carcomparison', compact('page_description'));
    }

    /**
     *  
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function comparisonDetails(Request $request)
    {
        $activeLanguage  = \Session::get('language');
        $inputs          = $request->all();
        $ads_results     = Ad::query();
        $select_array    = array(
            'ads.id as ads_id', 'year', 'price', 'maker_id', 'mo.id as model_id',
            'version_id', 'm.title as make_name', 'mo.name as model_name', 'features', 'fuel_average',
            'v.*', 'etd.title AS engine_title', 'gbd.title AS transmission_title'
        );
        $ads_results->select($select_array);
        $ads_results->join('makes AS m', function ($join) {
            $join->on('m.id', '=', 'ads.maker_id');
            $join->where('m.status', 1);
        });
        $ads_results->join('models AS mo', 'mo.id', '=', 'ads.model_id');
        $ads_results->join('versions AS v', 'v.id', '=', 'ads.version_id');

        $ads_results->leftJoin('engine_types_description AS etd', function ($join) use ($activeLanguage) {
            $join->on('etd.engine_type_id', '=', 'ads.fuel_type');
            $join->WHERE('etd.language_id', '=', $activeLanguage['id']);
        });
        $ads_results->leftJoin('transmission_description AS gbd', function ($join) use ($activeLanguage) {
            $join->on('gbd.transmission_id', '=', 'ads.transmission_type');
            $join->WHERE('gbd.language_id', '=', $activeLanguage['id']);
        });

        $ads_results->where('ads.status', 1);
        $ads_results->whereIn('ads.id', $inputs['compared_cars']);
        $result = $ads_results->get();
        $i      = 1;
        $cars   = null;
        foreach ($result as $values) {
            if ($values->features != null) {
                $feature_array = explode(",", $values->features);
                $cars['car' . $i]['features'] = $feature_array;
                //Features::select('id','name')->whereIn('id',$feature_array)->get();
            }

            $ads = AdImage::select('img')->where('ad_id', $values->ads_id)->orderBy('id', 'ASC')->limit(1)->first();
            if (@$ads->img != null && file_exists(public_path() . '/uploads/ad_pictures/cars/' . $values->ads_id . '/' . @$ads->img)) {
                $image = url('/') . '/public/uploads/ad_pictures/cars/' . $values->ads_id . '/' . @$ads->img;
            } else {
                $image = url('/') . '/public/assets/img/caravatar.jpg';
            }
            $cars['car' . $i]['data']  = $values;
            $cars['car' . $i]['image'] = $image;
            $i++;
        }

        $all_features =  Features::where('status', 1)->get();
        if ($cars != null) {
            return view('guest.comparisondetails', compact('cars', 'all_features'));
        } else {
            return redirect()->back();
        }
    }

    public function getAdsCompared()
    {
        if (!Auth::guard('customer')->check()) {
            return 'Please login to compare your saved ads.';
        }
        $user_id = Auth::guard('customer')->user()->id;
        $request      = request()->all();
        $ads_results  = Ad::query();
        $select_array = array(
            'ads.id as ads_id', 'year', 'maker_id', 'mo.id as model_id', 'version_id', 'm.title as make_name', 'mo.name as model_name',
            'v.label as version_label', 'v.engine_capacity', 'v.kilowatt', 'v.engine_power', 'v.from_date', 'v.to_date'
        );
        $ads_results->select($select_array);
        $ads_results->join('makes AS m', 'm.id', '=', 'ads.maker_id');
        $ads_results->join('models AS mo', 'mo.id', '=', 'ads.model_id');
        $ads_results->join('versions AS v', 'v.id', '=', 'ads.version_id');
        $ads_results->join('user_saved_ads AS us', 'us.ad_id', '=', 'ads.id');
        $ads_results->where('ads.status', 1);
        $ads_results->where('us.customer_id', $user_id);

        if (!empty($request)) {
            $excludedAd = $request['excludedAd'];
            $ads_results->where('ads.id', '<>', $excludedAd);
        }
        /*$result = $ads_results->toSql();*/
        $search_result = $ads_results->get();
        if (!$search_result->isEmpty()) {
            $dataWithImage = array();
            foreach ($search_result as $values) {
                $ads = AdImage::select('img')->where('ad_id', $values->ads_id)->orderBy('id', 'ASC')->limit(1)->first();

                if (@$ads->img != null && file_exists(public_path() . '/uploads/ad_pictures/cars/' . $values->ads_id . '/' . @$ads->img)) {
                    $image = url('/') . '/public/uploads/ad_pictures/cars/' . $values->ads_id . '/' . @$ads->img;
                } else {
                    $image = url('/') . '/public/assets/img/caravatar.jpg';
                }

                $dataWithImage[] = array(
                    'ads_id' => $values->ads_id,
                    'year'            => $values->year,
                    'maker_id'        => $values->maker_id,
                    'model_id'        => $values->model_id,
                    'version_id'      => $values->version_id,
                    'make_name'       => $values->make_name,
                    'model_name'      => $values->model_name,
                    'version_label'   => $values->version_label,
                    'engine_capacity' => $values->engine_capacity,
                    'engine_power'    => $values->engine_power,
                    'from_date'       => $values->from_date,
                    'to_date'         => $values->to_date,
                    'image'           => $image
                );
            }
            return response()->json($dataWithImage);

        } else{
            return  Lang::get('popupCarComparison.no_data_available');
        }

    }

    public function greeting()
    {
        return view('Customers.greeting');
    }

    public function userLoginFromAdmin($token_for_admin_login, $user_id)
    {
        $user = Customer::where('id', $user_id)->first();
        // dd($user);
        if ($user->token_for_admin_login == $token_for_admin_login and $user->login_status == 1) {

            Auth::guard('customer')->login($user);
            // Auth::guard('customer')->attempt(['customer_email_address' => $user->customer_email_address, 'password' => $user->password]);
            $user->token_for_admin_login = null;
            $user->save();
            return redirect('user/my-ads');
        } else {
            return redirect('login')->with('successmessage', 'Invalid Token Provided');
        }
    }

    public function faqsListing()
    {
        $activeLanguage = \Session::get('language');
        $faq_category_decs = FaqCategoryDescription::whereHas('FaqCategory', function ($q) {
            $q->where('status', 1);
        })->where('language_id', $activeLanguage['id'])->get();
        return view('guest.faqs_listings', compact('faq_category_decs'));
    }

    public function faqsSearch(Request $request)
    {

        $activeLanguage = \Session::get('language');
        $fields = array(
            "faqs.faq_category_id AS faqcategoryid", "faqs.id AS faqid", "faqs.image AS faqimage", "fd.answer", "fd.question",
            "fc.image AS faqcategoryimage", "fcd.title"
        );
        $faqQuery = Faq::query()->groupBy('faqs.id')->where('faqs.status', 1)->where('fc.status', 1)->where('fcd.language_id', $activeLanguage['id']);
        $faqQuery->join('faqs_description AS fd', 'fd.faq_id', '=', 'faqs.id');
        $faqQuery->join('faq_categories AS fc', 'fc.id', '=', 'faqs.faq_category_id');
        $faqQuery->join('faq_categories_description AS fcd', 'fcd.faq_category_id', '=', 'faqs.faq_category_id');
        if (!empty($request->get('term'))) {
            $term = $request->get('term');
            $faqQuery->whereRaw(DB::raw(' (answer LIKE "%' . $term . '%" OR question LIKE "%' . $term . '%" OR title LIKE "%' . $term . '%")'));
        }
        $result = $faqQuery->select($fields)->get();

        $categoryId = array();
        foreach ($result as $show) {
            $categoryId[$show->faqcategoryid] = $show->faqcategoryid;
        }
        DB::enableQueryLog();
        $faq_category_decs = FaqCategoryDescription::whereHas('FaqCategory', function ($q) {
            $q->where('status', 1);
        })->where('language_id', $activeLanguage['id'])->whereIn('faq_category_id', $categoryId)->get();
        $quries     = DB::getQueryLog();
        return view('guest.faqs_listings', compact('faq_category_decs', 'term'));
    }



    public function faqsAutocomplete(Request $request)
    {
        DB::enableQueryLog();
        if (request()->ajax()) {

            $activeLanguage = \Session::get('language');
            $fieldsFaq      = array("faqs.id AS faqid", "fd.answer", "fd.question");
            $fields         = array("fcd.title");
            $faqQuery       = Faq::query()->distinct('faqs.id')->groupBy('faqs.id')->where('status', 1)
                ->where('fd.language_id', $activeLanguage['id']);
            $faqQuery->join('faqs_description AS fd', 'fd.faq_id', '=', 'faqs.id');

            $faqCatQuery = FaqCategory::query()->where('status', 1);
            $faqCatQuery->join('faq_categories_description AS fcd', 'fcd.faq_category_id', '=', 'faq_categories.id')
                ->where('fcd.language_id', $activeLanguage['id']);

            if (!empty($request->get('term'))) {
                $term = $request->get('term');
                $faqQuery->whereRaw(DB::raw(' (answer LIKE "%' . $term . '%" OR question LIKE "%' . $term . '%")'));
                $faqCatQuery->where('title', 'like', "%$term%");
            }
            $faqCategory = $faqCatQuery->select($fields)->get();
            $quries      = DB::getQueryLog();
            $faqResult   = $faqQuery->select($fieldsFaq)->get();
            $result = array();
            if (!$faqCategory->isEmpty()) {
                foreach ($faqCategory as $faqsCat) {
                    $title = $faqsCat->title;
                    $result[] = ['id' => $title, 'value' => $title, 'label' => $title];
                }
            }
            if (!$faqResult->isEmpty()) {
                foreach ($faqResult as $faqsShow) {
                    $title = $faqsShow->question;
                    $result[] = ['id' => $title, 'value' => $title, 'label' => $title];
                }
            }
        } else {
            $html = response('Forbidden.', 403);
        }
        return response()->json($result);
    }

    public function sellACar()
    {
        return view('guest.sell_a_car');
    }

    public function sellAnAutopart()
    {
        return view('guest.sell_an_autopart');
    }

    public function sellCarService()
    {
        return view('guest.sell_car_service');
    }
}
