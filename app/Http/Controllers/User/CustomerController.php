<?php
namespace App\Http\Controllers\User;
use App\Ad;
use App\Reason;
use App\ReasonsDescription;
use App\AdMsg;
use App\AdImage;
use App\AdTag;
use App\AdsPricing;
use App\Car;
use App\ServiceDetail;
use App\ServiceTitle;
use App\CarYear;
use Hash;
use App\MyAlert;
use App\ServiceMessage;
use App\AccessoriesAlert;
use App\SparepartsAdsMessage;
use App\City;
use App\Color;
use App\Models\Customers\CustomerAccount;
use App\Models\Customers\FeaturedRequest;
use App\Http\Controllers\Controller;
use App\Models\ServiceImage;
use App\Models\Customers\Customer;
use App\Models\Customers\PrimaryService;
use App\Models\Customers\SubService;
use App\Models\CustomerTiming;
use App\Models\Services;
use App\SparePartAd;
use App\SparePartAdImage;
use App\SparePartCategory;
use App\Suggesstion;
use App\UserSavedAds;
use App\UserSavedSpareParts;
use App\Year;
use App\GeneralSetting;
use App\SparePartAdTitle;
use App\SparepartsAdsDescription;
use App\ServiceDescription;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Models\Cars\Make;
use App\Models\Cars\Carmodel;
use App\Models\Cars\BodyTypes;
use App\Models\Cars\Version;
use App\Models\Cars\Features;
use App\Models\Cars\Makemodelversion;
use App\Models\Customers\InvoiceSetting;
use App\Models\Country;
use App\EmailTemplate;
use App\EmailTemplateDescription;
use App\Chat;
use App\CustomerMessages;
use Mail;
use App\Mail\CarAd;
use App\Mail\PayForAd;
use App\Mail\SpartPartAd;
use App\Mail\OfferServiceMail;
use Illuminate\Support\Arr;
use App\Models\Language;
use App\Models\AdDescription;
use App\PageDescription;
use Excel;
use File;
use PDF;
use MyHelpers;
use Lang;
use Carbon\Carbon;
use App\Tag;
use App\Models\Transmission;
use App\Models\EngineType;
use App\Page;
use App\SuggestionDescriptions;
use Yajra\Datatables\Datatables;
use App\Models\AdsStatusHistory;
use App\Rules\Captcha;
use App\PostsHistory;
use App\Models\SpAdDescription;
use App\Models\BoughtFrom;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Spatie\ImageOptimizer\Optimizer;    
use ImageOptimizer;
use Image;
use App\Models\TyreManufacturer;
use App\Models\WheelManufacturer;
use App\Models\Brand;

class CustomerController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:customer');
    }

    public function sendMessageToCustomer(Request $request)
    {
        $chat = Chat::where('from_id', $request->from_id)->where('to_id', $request->to_id)->where('ad_id', $request->ad_id)->where('type', $request->type)->first();
        if ($chat == null) {
            $chat = new Chat;
            $chat->from_id = $request->from_id;
            $chat->to_id = $request->to_id; //1 is the id of Admin in users table
            $chat->read_status = 0;
            $chat->ad_id = $request->ad_id;
            $chat->type = $request->type;
            $chat->save();
        }
        $user_message = new CustomerMessages;
        $user_message->chat_id = $chat->id;
        $user_message->from_id = $request->from_id;
        $user_message->to_id = $request->to_id; //1 is the id of Admin in users table
        $user_message->message = $request->customer_message;
        $user_message->read_status = 0;
        $user_message->save();

        return redirect()->back()->with('successmessage', 'Message sent successfully');
    }
    public function updateProfile(Request $request)
    {
        $customer_id = Auth::guard('customer')->user()->id;
        $customer = Customer::where('id', $customer_id)->first();
        $customer->customer_company = $request->customer_firstname;
        $customer->customer_gender = $request->gender;
        $customer->customers_dob = $request->dob;
        $customer->country_id = $request->country;
        $customer->citiy_id = $request->city;
        $customer->customers_telephone = $request->customer_contact;
        $customer->language_id = $request->prefered_language;

        if ($request->hasFile('logo') && $request->logo->isValid()) {
            $validatedData     = $request->validate([
                'logo'         => 'mimes:jpeg,jpg,png,gif|required|max:50000',
            ]);
            $fileNameWithExt = $request->file('logo')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('logo')->getClientOriginalExtension();
            $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
            $customer->logo = $fileNameToStore;

            $data = getimagesize($request->file('logo'));
            $width = $data[0];
            $height = $data[1];
            
            if($width > $height)
            {
                $new_width  = 1000;
                $new_height = ($height/$width*$new_width);
            }
            else if($width < $height)
            {
                $new_height = 750;
                $new_width  = ($width/$height*$new_height);
            }
            else if($width == $height){
                $new_width  = 750;
                $new_height = 750;
            }
            else{
                $new_width  = 750;
                $new_height = 750;
            }
   

            $pathToImage = 'public/uploads/customers/logos/'.$fileNameToStore;
            $img = Image::make($request->file('logo'));
            $img->resize($new_width, $new_height);
            $img->save($pathToImage);
        }
        $customer->save();
        return response()->json([
            "error" => false,
        ]);
    }
    public function updateBusinessProfile(Request $request)
    {
        $customer_id = Auth::guard('customer')->user()->id;

        if ($request->timing !=  null)
            CustomerTiming::where('customer_id', $customer_id)->delete();

        foreach ($request->timing as $key => $value) {

            $service_timing = new CustomerTiming;
            $service_timing->customer_id = $request->customer_id;
            $service_timing->day_name = $value;
            $service_timing->opening_time = $request->opening_time[$key];
            $service_timing->closing_time = $request->closing_time[$key];
            $service_timing->save();
        }

        $customer = Customer::where('id', $customer_id)->first();
        $customer->customer_company = $request->company_name;
        $customer->customer_vat = $request->vat;
        $customer->customer_default_address = $request->address;
        $customer->customers_telephone = $request->phone;
        $customer->customer_registeration = $request->registration;
        $customer->website = $request->website;
        $customer->citiy_id = $request->city;
        $customer->language_id = $request->prefered_language;

        $customer->website = $request->website;
        if ($request->hasFile('logo') && $request->logo->isValid()) {
            $validatedData     = $request->validate([
                'logo'         => 'mimes:jpeg,jpg,png,gif|required|max:50000',
            ]);
            $fileNameWithExt = $request->file('logo')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('logo')->getClientOriginalExtension();
            $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
            //$path = $request->file('logo')->move('public/uploads/customers/logos/', $fileNameToStore);
            $customer->logo = $fileNameToStore;


            $data = getimagesize($request->file('logo'));
            $width = $data[0];
            $height = $data[1];
            
            if($width > $height)
            {
                $new_width  = 1000;
                $new_height = ($height/$width*$new_width);
            }
            else if($width < $height)
            {
                $new_height = 750;
                $new_width  = ($width/$height*$new_height);
            }
            else if($width == $height){
                $new_width  = 750;
                $new_height = 750;
            }
            else{
                $new_width  = 750;
                $new_height = 750;
            }
   

            $pathToImage = 'public/uploads/customers/logos/'.$fileNameToStore;
            $img = Image::make($request->file('logo'));
            $img->resize($new_width, $new_height);
            $img->save($pathToImage);


        }
        $customer->save();

        return response()->json([
            "error" => false,
        ]);
    }
    public function getCarInfo(Request $request)
    {
        if (request()->ajax()) {
            $finalAaary         = array();
            $number             = $request->input('carnumber');
            $captcha = $request->input('gRecaptchaResponse');

            $secretKey = "6LdSgtYdAAAAAPDHbMhEfZq0Cp_6zojttPS7f1GI";
            $ip = $_SERVER['REMOTE_ADDR'];

            // post request to server
            $url = 'https://www.google.com/recaptcha/api/siteverify';
            $data = array('secret' => $secretKey, 'response' => $captcha);

            $options = array(
                'http' => array(
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($data)
                )
            );
            $context  = stream_context_create($options);
            $response = file_get_contents($url, false, $context);
            $responseKeys = json_decode($response, true);
            header('Content-type: application/json');
            if ($responseKeys["success"]) {
                /*$url = "https://aris.mnt.ee/ark/andmevahetus/veh_service12?username=carish&password=R2ytrKpHtNb5HFRH&executor=14584163&regmark=".$number;
                $ch  = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $output = curl_exec($ch);
                curl_close($ch);

                $ob           = simplexml_load_string($output);
                $json         = json_encode($ob);
                $configData   = json_decode($json, true);
                $combineArray = array();
                if (isset($configData['ERROR']['CODE']) &&  $configData['ERROR']['CODE'] == '006') {*/
                    $finalAaary['status'] = 'error';
                    $finalAaary['captacha'] = true;
                    $finalAaary['message'] = Lang::get('postCarAdPage.userAlertNotify');
                /*} else {
                    $myHelpers                  = new  MyHelpers;
                    $permittedCategories        = $myHelpers->permittedCategories(); // return array 
                    $combineArray['category']   = $configData['SOIDUKID']['SOIDUK']['KAT_LYHEND'];

                    $finalAaary['status']              = 'success';
                    $finalAaary['captacha']            = true;
                    $finalAaary['message']             = Lang::get('ads.car_found');
                    $combineArray['car_number']        = $configData['SISENDPARAMEETRID']['REGMARK'];
                    $combineArray['model']             = $configData['SOIDUKID']['SOIDUK']['NIMETUS'];
                    $combineArray['make']              = $configData['SOIDUKID']['SOIDUK']['MARK'];

                    $combineArray['variant']           = @$configData['SOIDUKID']['SOIDUK']['VARIANT'];
                    $combineArray['version']           = @$configData['SOIDUKID']['SOIDUK']['VERSIOON'];

                    $combineArray['cc']                = round(($configData['SOIDUKID']['SOIDUK']['MOOTORI_MAHT']) * (0.001), 1, PHP_ROUND_HALF_UP);
                    $combineArray['enginPower']        = $configData['SOIDUKID']['SOIDUK']['MOOTORI_VOIMSUS'];

                    $combineArray['number_of_door']    = @$configData['SOIDUKID']['SOIDUK']['UKSI'];
                    $combineArray['length']            = @$configData['SOIDUKID']['SOIDUK']['PIKKUS'];
                    $combineArray['width']             = @$configData['SOIDUKID']['SOIDUK']['LAIUS'];
                    $combineArray['height']            = @$configData['SOIDUKID']['SOIDUK']['KORGUS'];
                    $combineArray['weight']            = @$configData['SOIDUKID']['SOIDUK']['TAISMASS'];
                    $combineArray['curb_weight']       = @$configData['SOIDUKID']['SOIDUK']['TYHIMASS'];
                    $combineArray['wheel_base']        = @$configData['SOIDUKID']['SOIDUK']['TELGEDE_VAHED'];
                    $combineArray['seating_capacity']  = @$configData['SOIDUKID']['SOIDUK']['ISTEKOHTI'];
                    $combineArray['torque']            = @$configData['SOIDUKID']['SOIDUK']['MOOTORI_POORDED']; // ENGINE ROTATION
                    $combineArray['max_speed']         = @$configData['SOIDUKID']['SOIDUK']['SUURIM_KIIRUS'];

                    if (isset($configData['SOIDUKID']['SOIDUK']['KAIGUKASTI_TYYP'])) {
                        $combineArray['transmission_type'] = $configData['SOIDUKID']['SOIDUK']['KAIGUKASTI_TYYP'];
                    } else $combineArray['transmission_type'] = '0';
                    if (isset($configData['SOIDUKID']['SOIDUK']['MOOTORI_TYYP'])) {
                        $combineArray['fuel_type']         = $configData['SOIDUKID']['SOIDUK']['MOOTORI_TYYP'];
                    } else $combineArray['fuel_type'] = '0';
                    $wheelsArray = $configData['SOIDUKID']['SOIDUK']['TELJED']['TELG'];
                    if (!empty($wheelsArray)) {
                        $combineArray['front_tyre_size']  = @$wheelsArray[0]['A'];
                        $combineArray['back_tyre_size']   = @$wheelsArray[0]['B'];
                        $combineArray['front_wheel_size'] = @$wheelsArray[1]['A'];
                        $combineArray['back_wheel_size']  = @$wheelsArray[1]['B'];
                    }
                    $combineArray['country_name']    = @$configData['SOIDUKID']['SOIDUK']['RIIK'];
                    $combineArray['fuel_average']    = @$configData['SOIDUKID']['SOIDUK']['KYTUSEKULU_KESK'];
                    $combineArray['cost_in_city']    = @$configData['SOIDUKID']['SOIDUK']['KYTUSEKULU_LINNAS'];
                    $combineArray['cost_on_road']    = @$configData['SOIDUKID']['SOIDUK']['KYTUSEKULU_TEEL'];
                    $combineArray['year']            = date("Y", strtotime(@$configData['SOIDUKID']['SOIDUK']['ESMAREG_KP']));
                    $combineArray['next_inspection'] = Lang::get('ads.next_inspection_date') . ' : ' . @$configData['SOIDUKID']['SOIDUK']['JARGMISE_YLEVAATUSE_AEG'] . '.'; //2019-06-30</JARGMISE_YLEVAATUSE_AEG>
                    $combineArray['color']           = $configData['SOIDUKID']['SOIDUK']['VARV'];
                    $combineArray['body_type']       = $configData['SOIDUKID']['SOIDUK']['KERENIMETUS'];
                    $finalAaary['data']              = $combineArray;
                    //}// END OF ESLE FOR FINDING CATEGORY.
                } */
                // END OF ELSE FOR FINDING CARS
                return response()->json($finalAaary);
            } else {
                $finalAaary['status'] = 'error';
                $finalAaary['captacha'] = false;
                $finalAaary['message'] = Lang::get('postCarAdPage.captchaConfirm');
                return response()->json($finalAaary);
            }
        } // END IF OF CHECK AJAX REQUEST.


        else {
            return response('Forbidden.', 403);
        }
    }
    public function adAutoFillForm()
    {
        return view('users.ads.adauto_fill_form');
    }
    public function postAd()
    {
        $activeLanguage   = \Session::get('language');
        $cities           = City::where('status', 1)->get();
        $years            = Year::all();

        $featuresQuery = Features::query()->select("fd.feature_id", "fd.name", "features.id")->where('status', 1);
        $featuresQuery->join('features_description AS fd', 'features.id', '=', 'fd.feature_id')->where('language_id', $activeLanguage['id'])->orderBy('fd.name', 'ASC');
        $features      = $featuresQuery->get();

        $countriesQuery   = Country::query()->select("country_id", "cd.title")->where('status', 1);
        $countriesQuery->join('countries_description AS cd', 'countries.id', '=', 'cd.country_id')->where('language_id', $activeLanguage['id'])->orderBy('cd.title', 'ASC');
        $countries        = $countriesQuery->get();

        $boughtFromCountriesQuery  = BoughtFrom::query()->select("bought_from_id", "cd.title")->where('status', 1);
        $boughtFromCountriesQuery->join('bought_from_description AS cd', 'bought_from.id', '=', 'cd.bought_from_id')->where('language_id', $activeLanguage['id'])->orderBy('cd.title', 'ASC');
        $boughtFromCountries      = $boughtFromCountriesQuery->get();

        $suggestionsQuery = Suggesstion::query()->select("sd.suggesstion_id", "sd.title", "sd.sentence")->where('status', 1);
        $suggestionsQuery->join('suggesstion_descriptions AS sd', 'suggesstions.id', '=', 'sd.suggesstion_id')->where('language_id', $activeLanguage['id']);
        $suggestions      = $suggestionsQuery->get();


        $colorsQuery    = Color::query()->select("color_id", "cd.name");
        $colorsQuery->join('colors_description AS cd', 'colors.id', '=', 'cd.color_id')->where('language_id', $activeLanguage['id'])->where('status', 1)->orderBy('cd.name', 'ASC');
        $colors         = $colorsQuery->get();

        $bodyTypesQuery = BodyTypes::query()->select("body_type_id", "cd.name")->where('status', 1);
        $bodyTypesQuery->join('body_types_description AS cd', 'body_types.id', '=', 'cd.body_type_id')->where('language_id', $activeLanguage['id'])->orderBy('cd.name', 'ASC');
        $bodyTypes      = $bodyTypesQuery->get();

        $engineTypeQuery = EngineType::query()->select("engine_type_id", "cd.title")->where('status', 1);
        $engineTypeQuery->join('engine_types_description AS cd', 'engine_types.id', '=', 'cd.engine_type_id')->where('language_id', $activeLanguage['id'])->orderBy('cd.title', 'ASC');
        $engineTypes      = $engineTypeQuery->get();

        $transmissionQuery = Transmission::query()->select("transmission_id", "cd.title")->where('status', 1);
        $transmissionQuery->join('transmission_description AS cd', 'transmissions.id', '=', 'cd.transmission_id')->where('language_id', $activeLanguage['id'])->orderBy('cd.title', 'ASC');
        $transmissions      = $transmissionQuery->get();

        $categorise     = SparePartCategory::where('parent_id', 0)->where('status', 1)->get();
        $customerDetail = Auth::guard('customer')->user();

        $page_descriptionQuery = Page::query()->select("pd.title", "pd.description");
        $page_descriptionQuery->join('page_desciption AS pd', 'pages.id', '=', 'pd.page_id')->where('pd.language_id', $activeLanguage['id']);
        $page_description = $page_descriptionQuery->where('page_id', 3)->first();

        $sumCredit = CustomerAccount::where('customer_id', Auth::guard('customer')->user()->id)->where('status', 1)->sum('credit');
        $sumDebit  = CustomerAccount::where('customer_id', Auth::guard('customer')->user()->id)->sum('debit');
        $credit           = $sumCredit - $sumDebit;

        if (Auth::guard('customer')->user()->customer_role == 'individual') {
            $ads_pricing = AdsPricing::where('type','Car Ad')->where('user_category','Individual')->orderBy('number_of_days', 'ASC')->get();
        } else {
            $ads_pricing = AdsPricing::where('type','Car Ad')->where('user_category','Business')->orderBy('number_of_days', 'ASC')->get();
        }

        return view('users.ads.postadsForm', compact('engineTypes', 'transmissions', 'cities', 'countries', 'years', 'suggestions', 'colors', 'categorise', 'customerDetail', 'bodyTypes', 'features', 'page_description', 'credit', 'activeLanguage', 'boughtFromCountries', 'ads_pricing'));
    }

    public function createPost(Request $request)
    {
        $activeLanguage  = \Session::get('language');
        $result = array();
        $myHelpers       = new  MyHelpers;
        $carnumber       = $request->car_number;
        $combineArray    = $request->car_data;
        if (!isset($combineArray) && !empty($combineArray)) {
            $combineArray['status'] = 'error';
            \Session::flash('error', 'No data found please try again.');
        } else {
            \Session::flash('success', 'You data has been matched please verify your car details.');
            /* COLORS LOGIC STARTS HERE */
            $combineArray['car_number'] = $carnumber;
            $combineArray['color_id']   = '';

            if (!empty($combineArray['fuel_type'])) {
                $engineType     = EngineType::where('api_code', '=', trim($combineArray['fuel_type']))->first();
                if ($engineType) { // insert MAKES
                    $combineArray['fuel_type'] = $engineType->id;
                } // end if 
                else $combineArray['fuel_type'] = '1';
            }

            if (!empty($combineArray['transmission_type'])) {
                $transmission     = Transmission::where('api_code', '=', strtolower(trim($combineArray['transmission_type'])))->first();
                if ($transmission) { // insert MAKES
                    $combineArray['transmission_type'] = $transmission->id;
                } // end if 
                else $combineArray['transmission_type'] = '';
            }

            if (isset($combineArray['color']) && !empty($combineArray['color'])) {
                if (!empty($combineArray['color'])) {
                    $db_color     = Color::query()->select("color_id", "cd.name");
                    $db_color->join('colors_description AS cd', 'colors.id', '=', 'cd.color_id')->where('language_id', $activeLanguage['id'])->where('api_code', '=', strtolower(trim($combineArray['color'])));
                    $db_color = $db_color->first();
                    if ($db_color) { // insert MAKES
                        $combineArray['color_id'] = $db_color->color_id;
                        $combineArray['color_name'] = $db_color->name;
                    } // end if 
                }
            } // End if.
            /* BODY TYPE LOGIC STARTS HERE */
            $combineArray['body_type_id'] = '';
            if (isset($combineArray['body_type']) && !empty($combineArray['body_type'])) {
                $body_type = BodyTypes::where('api_code', $combineArray['body_type'])->first();
                if (!empty($body_type)) {
                    $combineArray['body_type_id'] = $body_type->id;
                }
            }
            /*  if ($combineArray['country_name'] != 'null' && !empty($combineArray['country_name'])) {
                $country = Country::select('id as country_id')->where('code', '=', $combineArray['country_name'])->first();
                $combineArray['country_id'] = $country['country_id'];
            } */

            //<MITMEVARVILINE>E</MITMEVARVILINE>  // Multicolor ? if returns J then means multicolor , if returns M Means not multicolor Vehicle

            $combineArray        = $this->confirmMakeModelVersion($combineArray);
            $permittedCategories = $myHelpers->bodyTypes($combineArray['body_type']);

            if ($permittedCategories == 0) {
                $combineArray            = array();
                $combineArray['status']  = 'error';
                $combineArray['message'] = Lang::get('ads.car_cat_not_found');
                $request->session()->forget('success');
                \Session::flash('error', Lang::get('ads.car_cat_not_found'));
            }
        } // END ELSE 

        $cities         = City::where('status', 1)->get();
        $years          = Year::all();
        $featuresQuery  = Features::query()->select("fd.feature_id", "fd.name")->where('status', 1);
        $featuresQuery->join('features_description AS fd', 'features.id', '=', 'fd.feature_id')->where('language_id', $activeLanguage['id']);
        $features      = $featuresQuery->get();

        $countriesQuery  = Country::query()->select("country_id", "cd.title")->where('status', 1);
        $countriesQuery->join('countries_description AS cd', 'countries.id', '=', 'cd.country_id')->where('language_id', $activeLanguage['id'])->orderBy('cd.title', 'ASC');
        $countries      = $countriesQuery->get();


        $boughtFromCountriesQuery  = BoughtFrom::query()->select("bought_from_id", "cd.title")->where('status', 1);
        $boughtFromCountriesQuery->join('bought_from_description AS cd', 'bought_from.id', '=', 'cd.bought_from_id')->where('language_id', $activeLanguage['id'])->orderBy('cd.title', 'ASC');
        $boughtFromCountries      = $boughtFromCountriesQuery->get();

        $suggestionsQuery   = Suggesstion::query()->select("sd.suggesstion_id", "sd.title", "sd.sentence")->where('status', 1);
        $suggestionsQuery->join('suggesstion_descriptions AS sd', 'suggesstions.id', '=', 'sd.suggesstion_id')->where('language_id', $activeLanguage['id']);
        $suggestions = $suggestionsQuery->get();

        $colorsQuery    = Color::query()->select("color_id", "cd.name");
        $colorsQuery->join('colors_description AS cd', 'colors.id', '=', 'cd.color_id')->where('language_id', $activeLanguage['id'])->where('status', 1);
        $colors         = $colorsQuery->get();

        $bodyTypesQuery = BodyTypes::query()->select("body_type_id", "cd.name")->where('status', 1);
        $bodyTypesQuery->join('body_types_description AS cd', 'body_types.id', '=', 'cd.body_type_id')->where('language_id', $activeLanguage['id']);
        $bodyTypes      = $bodyTypesQuery->get();

        $engineTypeQuery = EngineType::query()->select("engine_type_id", "cd.title")->where('status', 1);
        $engineTypeQuery->join('engine_types_description AS cd', 'engine_types.id', '=', 'cd.engine_type_id')->where('language_id', $activeLanguage['id']);
        $engineTypes      = $engineTypeQuery->get();

        $transmissionQuery = Transmission::query()->select("transmission_id", "cd.title")->where('status', 1);
        $transmissionQuery->join('transmission_description AS cd', 'transmissions.id', '=', 'cd.transmission_id')->where('language_id', $activeLanguage['id']);
        $transmissions      = $transmissionQuery->get();

        $categorise     = SparePartCategory::where('parent_id', 0)->where('status', 1)->get();
        $customerDetail = Auth::guard('customer')->user();

        $page_descriptionQuery = Page::query()->select("pd.title", "pd.description");
        $page_descriptionQuery->join('page_desciption AS pd', 'pages.id', '=', 'pd.page_id')->where('pd.language_id', $activeLanguage['id']);
        $page_description = $page_descriptionQuery->where('page_id', 3)->first();
        $sumCredit = CustomerAccount::where('customer_id', Auth::guard('customer')->user()->id)->where('status', 1)->sum('credit');
        $sumDebit  = CustomerAccount::where('customer_id', Auth::guard('customer')->user()->id)->sum('debit');
        $credit           = $sumCredit - $sumDebit;

        if (Auth::guard('customer')->user()->customer_role == 'individual') {
            $ads_pricing = AdsPricing::where('type','Car Ad')->where('user_category','Individual')->orderBy('number_of_days', 'ASC')->get();
        } else {
            $ads_pricing = AdsPricing::where('type','Car Ad')->where('user_category','Business')->orderBy('number_of_days', 'ASC')->get();
        }

        return view('users.ads.postForm', compact('credit', 'engineTypes', 'transmissions', 'cities', 'countries', 'years', 'suggestions', 'colors', 'categorise', 'customerDetail', 'bodyTypes', 'features', 'result', 'combineArray', 'page_description', 'activeLanguage', 'boughtFromCountries', 'ads_pricing'));
    }
    private function confirmMakeModelVersion($combineArray = array())
    {
        $makes                 = Make::where('title', $combineArray['make'])->where('status', 1)->first();
        $year                  = $combineArray['year'];
        $combineArray['model'] = str_replace(' ', '', $combineArray['model']);
        if (is_null($makes)) {
            //$makeModelVersion = Makemodelversion::firstOrCreate(['make_title' => $combineArray['make'], 'car_number' => $combineArray['car_number']]); //Save make to database temporary table. SELECT *  FROM `models` WHERE '%RAM 1500 PICK-UP%' LIKE CONCAT('%',`name`,'%') ORDER BY `name`  DESC
            $models_data      = DB::table('models')->whereRaw(DB::raw("'%" . $combineArray['model'] . "%' LIKE CONCAT('%',`name`,'%')"))->orderBy('name', 'DESC')->first();
            if (is_null($models_data)) {
                $ads_results = Version::where('kilowatt', $combineArray['enginPower'])
                    ->where('engine_capacity', $combineArray['cc'])->whereRaw("'" . $year . "' >= from_date")->whereRaw("(to_date ='.' OR '" . $year . "' <= to_date)")->first();
            } // END MODEL IF CONDITION 

            else // ELSE OF MODEL CONDITION IF MODEL FOUND
            {
                $ads_results = Version::where('kilowatt', $combineArray['enginPower'])
                    ->where('engine_capacity', $combineArray['cc'])->whereRaw("'" . $year . "' >= from_date")->whereRaw("(to_date ='.' OR '" . $year . "' <= to_date)")
                    ->where('model_id', $models_data->id)->first();
                if (is_null($ads_results)) {
                    //SAVE VERSION DATA TO TEMP TABLE
                    /*   $makeModelVersion = Makemodelversion::create([
                        'make_title' => $combineArray['make'], 'model_title' => $combineArray['model'], 'cc' => $combineArray['cc'], 'from_date' => $combineArray['year'],
                        'engin_power' => $combineArray['enginPower'], 'car_number' => $combineArray['car_number']
                    ]); */
                } // END VERSION TABLE CONDITION


            } // END OF MODEL ELSE CON

        }
        // END OF MAKE IF CONDITION
        else // ELSE OF OF MAKE CONDITION IF MAKE NOT NULL.
        {
            ############################## IF MAKE FOUND ####################################
            $combineArray['make']     =   $makes->title;
            $combineArray['make_id']  =   $makes->id;

            $str = preg_replace('/\W\w+\s*(\W*)$/', '$1', $combineArray['model']);
            $models_data = DB::table('models')->whereRaw(DB::raw("'%" . $combineArray['model'] . "%' LIKE CONCAT('%',`name`,'%')"))->where('make_id', $makes->id)->orderBy('name', 'DESC')->first();

            if (is_null($models_data)) {
                //$makeModelVersion = Makemodelversion::firstOrCreate(['make_title' => $combineArray['make'], 'model_title' => $combineArray['model'], 'car_number' => $combineArray['car_number']]);
                $ads_results      = Version::where('kilowatt', $combineArray['enginPower'])
                    ->where('engine_capacity', $combineArray['cc'])->whereRaw("'" . $year . "' >= from_date")->whereRaw("(to_date ='.' OR '" . $year . "' <= to_date)")->first();

                if (is_null($ads_results)) {
                    //$makeModelVersion = Makemodelversion::firstOrCreate(['make_title' => $combineArray['make'], 'model_title' => $combineArray['model'], 'variant' => $combineArray['variant'], 'version' => $combineArray['version'], 'cc' => $combineArray['cc'], 'engin_power' => $combineArray['enginPower'], 'from_date' => $combineArray['year'], 'car_number' => $combineArray['car_number']]);
                } // END VERSION IF CONDITION 

            } // END MODEL IF CONDITION 
            else // ELSE OF MODEL CONDITION IF MODEL FOUND
            {
                $combineArray['model']     =   $models_data->name;
                $combineArray['model_id']  =   $models_data->id;
                $ads_results = Version::where('kilowatt', $combineArray['enginPower'])
                    ->where('engine_capacity', $combineArray['cc'])->whereRaw("'" . $year . "' >= from_date")->whereRaw("(to_date ='.' OR '" . $year . "' <= to_date)")
                    ->where('model_id', $models_data->id)->first();
                if (is_null($ads_results)) {
                    //SAVE VERSION DATA TO TEMP TABLE  
                    //$makeModelVersion = Makemodelversion::create(['cc'=> $combineArray['cc'], 'from_date'=> $combineArray['year']]);
                    //$makeModelVersion = Makemodelversion::firstOrCreate(['model_title' => $combineArray['model'], 'variant' => $combineArray['variant'], 'version' => $combineArray['version'], 'cc' => $combineArray['cc'], 'engin_power' => $combineArray['enginPower'], 'from_date' => $combineArray['year'], 'car_number' => $combineArray['car_number']]);
                } // END VERSION TABLE CONDITION
                else { //ELSE OF VERSION CONDTIONION IF VERSION OF MODEL FOUND THEN
                    //Set version detail in combine array
                    $combineArray['version_id']    = $ads_results->id;
                    $combineArray['enginPower']    = $ads_results->kilowatt;
                    $combineArray['cc']            = $ads_results->engine_capacity;
                    $combineArray['variant']       = $ads_results->label . ' ' . $ads_results->extra_details;
                    $ads_results                   = Version::find($ads_results->id);
                    $ads_results->number_of_door   = $combineArray['number_of_door'];
                    $ads_results->car_length       = $combineArray['length'];
                    $ads_results->car_width        = $combineArray['width'];
                    $ads_results->car_height       = $combineArray['height'];
                    $ads_results->weight           = $combineArray['weight'];
                    $ads_results->curb_weight      = $combineArray['curb_weight'];
                    $ads_results->wheel_base       = $combineArray['wheel_base'];
                    $ads_results->seating_capacity = $combineArray['seating_capacity'];
                    $ads_results->torque           = $combineArray['torque'];
                    $ads_results->max_speed        = $combineArray['max_speed'];
                    $ads_results->fueltype        = $combineArray['fuel_type'];
                    $ads_results->front_tyre_size  = $combineArray['front_tyre_size'];
                    $ads_results->back_tyre_size   = $combineArray['back_tyre_size'];
                    $ads_results->front_wheel_size = $combineArray['front_wheel_size'];
                    $ads_results->back_wheel_size  = $combineArray['back_wheel_size'];
                    $ads_results->transmissiontype = $combineArray['transmission_type'];
                    $ads_results->average_fuel = $combineArray['fuel_average'];
                    //$ads_results->save();
                } // END OF VERSION ELSE CONDITION

            } // END OF MODEL ELSE CON
            ##################################################################

        } // END OF ELSE MAKES.
        return $combineArray;
    }

    public function savePost(Request $request)
    {
        $GeneralSetting = GeneralSetting::select('ads_limit')->first();

        if (Auth::guard('customer')->user()->role == 'individual') {
            $count = $GeneralSetting->ads_limit !== null ? $GeneralSetting->ads_limit : 5;
        } else {
            $count = 15;
        }
        if (Ad::where('customer_id', Auth::guard('customer')->user()->id)->whereIn('status', [0, 1, 3])->get()->count() < $count) {
            $validatedData     = $request->validate([
                'make'         => 'required',
                'model'        => 'required',
                'color'        => 'required',
                'version'      => 'required',
                'country_id'   => 'required',
                'millage'      => 'required|number',
                'price'        => 'required|number',
                'description'  => 'required',
                'poster_name'  => 'required',
                'poster_email' => 'required',
                'poster_phone' => 'required',
                'body_type_id' => 'required',
                'doors'        => 'required',
                'fuel_average' => 'required|number',
                'product_image.*' => 'required|mimes:jpg,jpeg,png,bmp|max:20000', [
                    'product_image.*.required' => 'Please upload an image',
                    'product_image.*.mimes' => 'Only jpeg,png and bmp images are allowed',
                    'product_image.*.max' => 'Sorry! Maximum allowed size for an image is 20MB',
                ]
            ]);




            $ad                  = new Ad();
            $ad->customer_id     = Auth::guard('customer')->user()->id;
            $ad->country_id      = $request->country_id;
            $ad->maker_id        = $request->make_id;
            $ad->version_id      = $request->version_id;
            $ad->model_id        = $request->model_id;
            $ad->year            = $request->year;
            $ad->color_id        = $request->color;
            $ad->length          = $request->length;
            $ad->width           = $request->weight;
            $ad->height          = $request->height;
            $ad->millage         = $request->millage;
            $ad->fuel_average    = $request->fuel_average;
            $ad->price           = $request->price;
            $ad->vat             = isset($request->vat) ? 1 : 0;
            $ad->neg             = isset($request->neg) ? 1 : 0;
            $ad->fuel_type         = $request->fuel_type;
            $ad->transmission_type = $request->transmission_type;
            $ad->poster_name     = $request->poster_name;
            $ad->poster_email    = $request->poster_email;
            $ad->poster_phone    = $request->poster_phone;
            $ad->poster_city     = $request->poster_city;
            $ad->body_type_id    = $request->body_type_id;
            $ad->doors           = $request->doors;
            $ad->car_number      = $request->car_number;
            $description     = $request->description;
            $ad->save();

            /*SAVE ADS */
            $activeLanguage = \Session::get('language');
            $exploded_description = explode('#', $description);
            $et_description = '';
            $en_description = '';
            $ru_description = '';
            foreach ($exploded_description as $key => $value) {

                $find_suggest = SuggestionDescriptions::where('sentence', $value)->first();

                if ($find_suggest !== null) {
                    $all_lang_find_suggest = SuggestionDescriptions::where('suggesstion_id', $find_suggest->suggesstion_id)->get();

                    foreach ($all_lang_find_suggest as $key => $value) {
                        if ($value->language_id == 1) {
                            $et_description .= $value->sentence . '#';
                        } else if ($value->language_id == 2) {
                            $en_description .= $value->sentence . '#';
                        } else if ($value->language_id == 3) {
                            $ru_description .= $value->sentence . '#';
                        }
                    }
                } else {
                    if ($activeLanguage['id'] == 1) {
                    } else if ($activeLanguage['id'] == 2) {
                        $en_description .= @$value . '#';
                    } else if ($activeLanguage['id'] == 3) {
                    }
                }
            }
            if ($et_description !== '') {
                $ad->ads_description()->create(
                    [
                        'description' => $et_description,
                        'language_id'  => 1
                    ]
                );
            }

            if ($en_description !== '') {
                $ad->ads_description()->create(
                    [
                        'description' => $en_description,
                        'language_id'  => 2
                    ]
                );
            }

            if ($et_description !== '') {
                $ad->ads_description()->create(
                    [
                        'description' => $ru_description,
                        'language_id'  => 3
                    ]
                );
            }

            //SAVE FEATURES
            if ($request->features != null) {
                if (count($request->features) > 0) {
                    $ad->features = implode(',', $request->features);
                    $ad->save();
                }
            }
            /*SAVE TAGS*/
            if ($request->tags != null) {
                if (count($request->tags) > 0) {
                    $ad->suggessions()->attach($request->tags);
                }
            }
            // UPOLOAD MULTIPE IMAGES
            $base = $request->get('product_image');
            if (sizeof($base) > 0) {
                foreach ($base as $index => $base64) {
                    if (!empty($base64)) {
                        $image = $this->uploadd($base64, $ad->id);
                        if ($image != '0') {

                            $adImage        = new AdImage();
                            $adImage->ad_id = $ad->id;
                            $adImage->img   = $image;
                            $adImage->save();
                        }
                    } // endif
                    else {
                        // return json_encode(['success' => true]);
                    }
                } // end for loop.

            } //Endif 

            $data = ['poster_name' => $request->poster_name,];
            $template = EmailTemplate::where('type', 1)->first();
            //dd($template);
            Mail::to($request->poster_email)->send(new CarAd($data, $template));

            return redirect('user/my-profile');
        } else {
            return "show page saying you have more than " . @$count . " ads";
        }
    }
    public function saveAd(Request $request)
    { 
        $rules = [
            'make'         => 'required',
            'model'        => 'required',
            'year'         => 'required',
            'version'      => 'required',
            'color'        => 'required',
            'country_id'   => 'required',
            'millage'      => 'required',
            'price'        => 'required',
            'description'  => 'required',
            'poster_name'  => 'required',
            'poster_email' => 'required',
            'poster_phone' => 'required',
            'body_type_id' => 'required',
            'doors'        => 'required',
            'fuel_average' => 'required'
        ];
        /* ,
            'product_image.*' => 'required|mimes:jpg,jpeg,png,bmp|max:500'
            ,[
                'product_image.*.required' => 'Please upload an image',
                'product_image.*.mimes' => 'Only jpeg,png and bmp images are allowed',
                'product_image.*.max' => 'Sorry! Maximum allowed size for an image is 20MB',
            ]
        */
        if ($request->has('product_image') && ($request->get('product_image') != null || $request->get('product_image') == '')) {
            $base  = $request->get('product_image');
            $files = count($base) - 1;
            if ($files > 0) {
                foreach ($base as $index => $image_path) {
                    if (!empty($image_path)) {
                        $rules['product_image.' . $index] = 'base64max:99999048';
                    }
                }
            }
        }
        $activeLanguage  = \Session::get('language');
        $validatedData = $request->validate($rules);
        $ad                      = new Ad();
        $ad->customer_id         = Auth::guard('customer')->user()->id;
        $ad->country_id          = $request->country_id;
        $ad->bought_from_id      = $request->bought_from;
        $ad->register_in_estonia = $request->register_in_estonia;
        $ad->maker_id            = $request->make_id;
        $ad->version_id          = $request->version_id;
        $ad->model_id            = $request->model_id;
        $ad->year                = $request->year;
        $ad->color_id            = $request->color;
        $ad->millage             = $request->millage;
        $ad->fuel_average        = $request->fuel_average;
        $ad->price               = $request->price;
        $ad->car_number          = $request->car_number;
        $ad->vat                 = isset($request->vat) ? 1 : 0;
        $ad->neg                 = isset($request->neg) ? 1 : 0;
        $ad->fuel_type           = $request->fuel_type;
        $ad->transmission_type   = $request->transmission_type;
        $ad->poster_name         = $request->poster_name;
        $ad->poster_email        = $request->poster_email;
        $ad->poster_phone        = $request->poster_phone;
        if ($request->poster_city != null) {
            $ad->poster_city     = $request->poster_city;
        } else {
            $ad->poster_city     = Auth::guard('customer')->user()->citiy_id;
        }
        $ad->body_type_id        = $request->body_type_id;
        $ad->doors               = $request->doors;
        $description             = $request->description;
        $ad->save();
        /*SAVE ADS */
        $exploded_description = explode('#', $description);
        $et_description = '';
        $en_description = '';
        $ru_description = '';
        foreach ($exploded_description as $key => $value) {

            $find_suggest = SuggestionDescriptions::where('sentence', $value)->first();

            if ($find_suggest !== null) {
                $all_lang_find_suggest = SuggestionDescriptions::where('suggesstion_id', $find_suggest->suggesstion_id)->get();

                foreach ($all_lang_find_suggest as $key => $value) {
                    if ($value->language_id == 1) {
                        $et_description .= $value->sentence . '#';
                    } else if ($value->language_id == 2) {
                        $en_description .= $value->sentence . '#';
                    } else if ($value->language_id == 3) {
                        $ru_description .= $value->sentence . '#';
                    }
                }
            } else {
                if ($activeLanguage['id'] == 1) {
                } else if ($activeLanguage['id'] == 2) {
                    $en_description .= @$value . '#';
                } else if ($activeLanguage['id'] == 3) {
                }
            }
        }
        if ($et_description !== '') {
            $ad->ads_description()->create(
                [
                    'description' => $et_description,
                    'language_id'  => 1
                ]
            );
        }
        if ($en_description !== '') {
            $ad->ads_description()->create(
                [
                    'description' => $en_description,
                    'language_id'  => 2
                ]
            );
        }
        if ($et_description !== '') {
            $ad->ads_description()->create(
                [
                    'description' => $ru_description,
                    'language_id'  => 3
                ]
            );
        }

        //SAVE FEATURES
        if ($request->features != null) {
            if (count($request->features) > 0) {
                $ad->features = implode(',', $request->features);
                $ad->save();
            }
        }
        /*SAVE TAGS*/
        $description     = $request->description;
        $greateMileageTag = null;

        $greateMileage       = $this->calcGreatAvg($request->year, $request->millage);
        if ($greateMileage) {
            $greateMileageTag = 1;
        }
        $this->attachTagsWithAds($description, $request->fuel_average, $activeLanguage['id'], $greateMileageTag, $ad);
        // UPOLOAD MULTIPE IMAGES
        $base = $request->get('product_image');
        if (sizeof($base) > 0) {
            foreach ($base as $index => $base64) {
                if (!empty($base64)) {
                    $image = $this->uploadd($base64, $ad->id);
                    if ($image != '0') {
                        $adImage        = new AdImage();
                        $adImage->ad_id = $ad->id;
                        $adImage->img   = $image;
                        $adImage->save();
                    }
                } // endif 
            } // end for loop.

        } //Endif 

        $CarAds   = Ad::where('customer_id', Auth::guard('customer')->user()->id)->whereIn('status', [0, 1, 3])->get()->count();
        $ids = Ad::where('customer_id', Auth::guard('customer')->user()->id)->whereIn('status', [0, 1, 3])->pluck('id')->toArray();
        $account = CustomerAccount::where('customer_id', Auth::guard('customer')->user()->id)->where('type','car_ad')->where('status','!=',2)->whereIn('ad_id',$ids)->count();
        $difference = $CarAds - $account;

        if (Auth::guard('customer')->user()->customer_role == 'individual' && !empty($request->number_of_days)) {
            $GeneralSetting  = GeneralSetting::select('ads_limit')->first();
            $ad_limit           = $GeneralSetting->ads_limit !== null ? $GeneralSetting->ads_limit : 5;
            $customer_type = 'Individual';
            }else{
            $GeneralSetting  = GeneralSetting::select('b_ads_limit')->first();
            $ad_limit           = $GeneralSetting->b_ads_limit !== null ? $GeneralSetting->b_ads_limit : 5;
            $customer_type = 'Business';
        }
            
        if ($difference > $ad_limit) {
            return $this->payForAds($request,$customer_type,$ad->id);
        } else {
            $new_history             = new AdsStatusHistory;
            $new_history->user_id    = Auth::guard('customer')->user()->id;
            $new_history->usertype   = 'customer';
            $new_history->ad_id      = $ad->id;
            $new_history->type       = 'car';
            $new_history->status     = 'Created';
            $new_history->new_status = 'Pending';
            $new_history->save();
        }

        $data = [
            'poster_name' => $request->poster_name,
            'title'       => @$ad->maker->title . ' ' . @$ad->model->name . ' ' . @$ad->year
        ];

        $templatee = EmailTemplate::where('type', 1)->first();
        $template = EmailTemplateDescription::where('email_template_id', $templatee->id)->where('language_id', @$ad->customer->language_id)->first();
        Mail::to($request->poster_email)->send(new CarAd($data, $template));
        // ajax comes
        if ($request->ajax()) {
            return response()->json(array(
                'success' => true,
                'message' => 'Record Successfull Added.'
            ), 200);
        }
    }

    private function payForAds($request,$customer_type,$ad_id)
    {
        $activeLanguage = \Session::get('language');
        $credit             = 0;
        $paid_amount     = 0;
        $customer_id        = Auth::guard('customer')->user()->id;
        $sumCredit          = CustomerAccount::where('customer_id', $customer_id)->where('status', 1)->sum('credit');
        $sumDebit           = CustomerAccount::where('customer_id', $customer_id)->sum('debit');
        $credit             = $sumCredit - $sumDebit;

         if ($customer_type == 'Individual') {
            $paid_amount = AdsPricing::where('type','Car Ad')->where('user_category','Individual')->where('number_of_days',$request->number_of_days)->orderBy('id','DESC')->pluck('pricing')->first();
        } else if($customer_type == 'Business') {
            $paid_amount = AdsPricing::where('type','Car Ad')->where('user_category','Business')->where('number_of_days',$request->number_of_days)->orderBy('id','DESC')->pluck('pricing')->first();
        }
        
        $account   = new CustomerAccount;
        $ad        = Ad::find($ad_id);
        
        
        if ($request->use_balance == 'on') {
            $start                = Carbon::now();
            $partial              = false;
            $result               = array('success' => true, 'payment_status' => 'full');
            $start->addDays($request->number_of_days);
            $active_until         = $start->endOfDay()->toDateTimeString();
            
            $account->customer_id = $customer_id;
            $account->ad_id       = $ad_id;
            $account->debit       = $paid_amount;

            if ($paid_amount > $credit) {
                $remaining_balance        = $paid_amount - $credit;
                $account->debit           = $credit;
                $paid_amount           = $remaining_balance;
                $partial                  = true;
                $result['payment_status'] = 'partial';
            }
            $account->detail         = 'Post An Ad';
            $account->number_of_days = $request->number_of_days;
            $account->paid_amount    = @$paid_amount;
            $account->status         = 1;
            $account->type           = 'car_ad';
            $account->save();

            if ($partial == false) {
                $ad->status              = 0;
                $ad->active_until        = $active_until;
                $ad->save();

                $new_history             = new AdsStatusHistory;
                $new_history->user_id    = Auth::guard('customer')->user()->id;
                $new_history->usertype   = 'customer';
                $new_history->ad_id      = $ad_id;
                $new_history->type       = 'car_ad';
                $new_history->status     = 'Created';
                $new_history->new_status = 'Pending';
                $new_history->save();
            }
            else{
                $ad->status              = 5;
                $ad->save();

                $new_history             = new AdsStatusHistory;
                $new_history->user_id    = Auth::guard('customer')->user()->id;
                $new_history->usertype   = 'customer';
                $new_history->ad_id      = $ad_id;
                $new_history->type       = 'car_ad';
                $new_history->status     = 'Created';
                $new_history->new_status = 'UnPaid';
                $new_history->save();
            }

            $result['invoice_id']    = $account->id;

            
        } 
        else {
            $ad->status = 5;
            $ad->save();

            $new_request                  = $account;
            $new_request->ad_id           = @$ad_id;
            $new_request->customer_id     = $customer_id;
            $new_request->number_of_days  = $request->number_of_days;
            $new_request->paid_amount     = @$paid_amount;
            $new_request->status     = 0;
            $new_request->type       = 'car_ad';
            $new_request->detail     = 'Post An Ad';
            $new_request->save();

            $new_history             = new AdsStatusHistory;
            $new_history->user_id    = Auth::guard('customer')->user()->id;
            $new_history->usertype   = 'customer';
            $new_history->ad_id      = $ad_id;
            $new_history->type       = 'car_ad';
            $new_history->status     = 'Created';
            $new_history->new_status = 'UnPaid';
            $new_history->save();

            $result['invoice_id']    = $account->id;

        }
        $ad        = Ad::find($ad_id);

        $data = [
            'poster_name' => $request->poster_name,
            'title'       => @$ad->maker->title . ' ' . @$ad->model->name . ' ' . @$ad->year
        ];

        $templatee = EmailTemplate::where('type', 1)->first();
        $template = EmailTemplateDescription::where('email_template_id', $templatee->id)->where('language_id', @$ad->customer->language_id)->first();
        Mail::to($request->poster_email)->send(new CarAd($data, $template));

        if ($account->credit != '' || $account->paid_amount) {
                $invoice_attachment = '<a href="' . route('pay-invoice-pdf', ['id' => @$account->id]) . '" target="_blank" style="text-decoration:none;">C' . @$account->id . '</a>';
            } 
            else {
                $invoice_attachment = '';
            }

            $pay_data = [
                'poster_name' => @$request->poster_name,
                'title'       => @$ad->maker->title . ' ' . @$ad->model->name . ' ' . @$ad->year,
                'invoice_pdf' =>  @$invoice_attachment
            ];

            //added by usman
            $pay_templatee = EmailTemplate::where('type', 14)->first(); // email for ad payment
            $pay_template  = EmailTemplateDescription::where('email_template_id', $pay_templatee->id)->where('language_id', @$ad->customer->language_id)->first();
            Mail::to($request->poster_email)->send(new PayForAd($pay_data, $pay_template));

            return response()->json($result);
    }

    private function calcGreatAvg($manfacturing_year, $current_millage)
    {
        $avarage_millage_per_year = 19000;
        $current_year = date("Y");
        $total_year   = $current_year - $manfacturing_year;
        $avarage_millage_for_this_car =  $avarage_millage_per_year *  $total_year;
        $current_millage = $current_millage;    //$current_millage 
        if ($current_millage < 130000 && $current_millage <= $avarage_millage_for_this_car)
            return true;
        else
            return false;
    }

    private function attachTagsWithAds($description = null, $fuel_average = null, $language_id = null, $greateMileageTag, $ad = null)
    {
        $sug_array  = explode('#', $description);
        $result     = array_filter($sug_array); // shsh
        $sug_array  = array();
        foreach ($result as $values) {
            $sug_array[] =  trim($values);
        }
        $sugQuery   = Suggesstion::query()->select('suggesstions.id')->where('suggesstions.status', 1);
        $sugQuery->whereIn('sd.sentence', $sug_array)->where('language_id', '=', $language_id);
        $sugQuery->join('suggesstion_descriptions AS sd', 'sd.suggesstion_id', '=', 'suggesstions.id');
        $sugQuery->join('tags AS t', 't.suggesstion_id', '=', 'suggesstions.id');
        $suggesstionIds = $sugQuery->get();

        if ($suggesstionIds->isNotEmpty()) {
            $suggesstion_id = explode(',', $suggesstionIds->implode('id', ', '));
            $tagResult      = Tag::select('id')->whereIn('suggesstion_id', $suggesstion_id)->get();
            if ($tagResult->isNotEmpty()) {
                $ad->tags()->attach($tagResult);
            }
        }
        if ($fuel_average) {
            if ($fuel_average <= 6) {
                $tagResult = Tag::select('id')->where('id', 4)->get();
                if ($tagResult->isNotEmpty()) {
                    $ad->tags()->attach($tagResult);
                }
            }
        } // END AVARAGE CONDITION.


        if ($greateMileageTag) {
            $tagResult = Tag::select('id')->where('id', $greateMileageTag)->get();
            if ($tagResult->isNotEmpty()) {
                $ad->tags()->attach($tagResult);
            }
        } // END AVARAGE CONDITION.


    }

    private function uploadd($base64_string, $prodId)
    {
        $data          = explode(';', $base64_string);
        $dataa         = explode(',', $base64_string);
        $part          = explode("/", $data[0]);
        $directory     = public_path('uploads/ad_pictures/cars/' . $prodId . '/');

        if (empty($part) or @$part[1] == null or empty(@$part[1])) {
            return false;
        } else {
            $file = md5(uniqid(rand(), true)) . ".{$part[1]}";
            if (!is_dir($directory)) {
                mkdir($directory, 0777, true);
            }

            $data = getimagesizefromstring(base64_decode($dataa[1]));
            $width = $data[0];
            $height = $data[1];
            
            if($width > $height)
            {
                $new_width  = 1000;
                $new_height = ($height/$width*$new_width);
            }
            else if($width < $height)
            {
                $new_height = 750;
                $new_width  = ($width/$height*$new_height);
            }
            else if($width == $height){
                $new_width  = 750;
                $new_height = 750;
            }
            else{
                $new_width  = 750;
                $new_height = 750;
            }


            $pathToImage = $directory.$file;
            $img = Image::make(base64_decode($dataa[1]));
            $img->resize($new_width, $new_height);
            $img->save($pathToImage);

            /*$ifp = fopen($directory . "/{$file}", 'wb');
            fwrite($ifp, base64_decode($dataa[1]));
            fclose($ifp);*/


            return $file;
        }
    }
    public function postEdit($id)
    {

        $adsDetails     = Ad::where('id', $id)->where('customer_id', '=', Auth::guard('customer')->user()->id)->first();
        $activeLanguage = \Session::get('language');

        $page_descriptionQuery = Page::query()->select("pd.title", "pd.description");
        $page_descriptionQuery->join('page_desciption AS pd', 'pages.id', '=', 'pd.page_id')->where('pd.language_id', $activeLanguage['id']);
        $page_description = $page_descriptionQuery->where('page_id', 3)->first();

        if ($adsDetails == null) {
            return redirect('user/my-ads')->with('error', 'Record could not be found.');
        }
        $cities         = City::where('status', 1)->get();
        $countries      = Country::where('status', 1)->get();
        $years          = Year::all();

        $featuresQuery = Features::query()->select("fd.feature_id", "fd.name")->where('status', 1);
        $featuresQuery->join('features_description AS fd', 'features.id', '=', 'fd.feature_id')->where('language_id', $activeLanguage['id']);
        $features      = $featuresQuery->get();

        $countriesQuery  = Country::query()->select("country_id", "cd.title")->where('status', 1);
        $countriesQuery->join('countries_description AS cd', 'countries.id', '=', 'cd.country_id')->where('language_id', $activeLanguage['id']);
        $countries      = $countriesQuery->get();

        $boughtFromCountriesQuery  = BoughtFrom::query()->select("bought_from_id", "cd.title")->where('status', 1);
        $boughtFromCountriesQuery->join('bought_from_description AS cd', 'bought_from.id', '=', 'cd.bought_from_id')->where('language_id', $activeLanguage['id'])->orderBy('cd.title', 'ASC');
        $boughtFromCountries      = $boughtFromCountriesQuery->get();

        $colorsQuery    = Color::query()->select("color_id", "cd.name");
        $colorsQuery->join('colors_description AS cd', 'colors.id', '=', 'cd.color_id')->where('language_id', $activeLanguage['id']);
        $colors         = $colorsQuery->get();
        $bodyTypesQuery = BodyTypes::query()->select("body_type_id", "cd.name");
        $bodyTypesQuery->join('body_types_description AS cd', 'body_types.id', '=', 'cd.body_type_id')->where('language_id', $activeLanguage['id']);
        $bodyTypes      = $bodyTypesQuery->get();

        $categorise     = SparePartCategory::where('parent_id', 0)->where('status', 1)->get();
        $customerDetail = Auth::guard('customer')->user();


        $activeLanguage = \Session::get('language');
        $descript       = AdDescription::where('ad_id', $adsDetails->id)->where('language_id', $activeLanguage['id'])->first();

        $descriptionArray = array_filter(explode('#', $descript->description));

        $ads_suggessions  = $adsDetails->suggessions;
        if ($ads_suggessions) {
            foreach ($ads_suggessions as $values) {
                $sugge[] = $values->id;
            }
        }
        $suggestionsQuery   = Suggesstion::query()->select("sd.suggesstion_id", "sd.title", "sd.sentence")->where('status', 1);;
        $suggestionsQuery->join('suggesstion_descriptions AS sd', 'suggesstions.id', '=', 'sd.suggesstion_id')->where('language_id', $activeLanguage['id']);
        $suggestionsQuery->whereNotIn('sd.sentence', $descriptionArray);
        $suggestions       = $suggestionsQuery->get();

        if (isset($sugge) && !empty($sugge)) {
        }
        $adImages   = AdImage::where('ad_id', $adsDetails->id)->get();

        $models = Carmodel::where('make_id', $adsDetails->maker_id)->where('status', 1)->get();

        $engineTypeQuery = EngineType::query()->select("engine_type_id", "cd.title")->where('status', 1);
        $engineTypeQuery->join('engine_types_description AS cd', 'engine_types.id', '=', 'cd.engine_type_id')->where('language_id', $activeLanguage['id']);
        $engineTypes      = $engineTypeQuery->get();

        $images_count    = @$adImages->count();

        return view('users.ads.postadsEdit', compact('adImages', 'countries', 'cities', 'years', 'suggestions', 'colors', 'categorise', 'customerDetail', 'bodyTypes', 'features', 'adsDetails', 'descript', 'page_description', 'activeLanguage', 'models', 'engineTypes', 'boughtFromCountries','images_count'));
    }

    public function postRemovedAdEdit($id)
    {
        $adsDetails     = Ad::where('id', $id)->where('customer_id', '=', Auth::guard('customer')->user()->id)->first();
        $activeLanguage = \Session::get('language');

        $page_descriptionQuery = Page::query()->select("pd.title", "pd.description");
        $page_descriptionQuery->join('page_desciption AS pd', 'pages.id', '=', 'pd.page_id')->where('pd.language_id', $activeLanguage['id']);
        $page_description = $page_descriptionQuery->where('page_id', 3)->first();

        if ($adsDetails == null) {
            return redirect('user/my-ads')->with('error', 'Record could not be found.');
        }
        $cities         = City::where('status', 1)->get();
        $countries      = Country::where('status', 1)->get();
        $years          = Year::all();

        $featuresQuery = Features::query()->select("fd.feature_id", "fd.name")->where('status', 1);
        $featuresQuery->join('features_description AS fd', 'features.id', '=', 'fd.feature_id')->where('language_id', $activeLanguage['id']);
        $features      = $featuresQuery->get();

        $countriesQuery  = Country::query()->select("country_id", "cd.title")->where('status', 1);
        $countriesQuery->join('countries_description AS cd', 'countries.id', '=', 'cd.country_id')->where('language_id', $activeLanguage['id']);
        $countries      = $countriesQuery->get();

        $boughtFromCountriesQuery  = BoughtFrom::query()->select("bought_from_id", "cd.title")->where('status', 1);
        $boughtFromCountriesQuery->join('bought_from_description AS cd', 'bought_from.id', '=', 'cd.bought_from_id')->where('language_id', $activeLanguage['id'])->orderBy('cd.title', 'ASC');
        $boughtFromCountries      = $boughtFromCountriesQuery->get();

        $colorsQuery    = Color::query()->select("color_id", "cd.name");
        $colorsQuery->join('colors_description AS cd', 'colors.id', '=', 'cd.color_id')->where('language_id', $activeLanguage['id']);
        $colors         = $colorsQuery->get();
        $bodyTypesQuery = BodyTypes::query()->select("body_type_id", "cd.name");
        $bodyTypesQuery->join('body_types_description AS cd', 'body_types.id', '=', 'cd.body_type_id')->where('language_id', $activeLanguage['id']);
        $bodyTypes      = $bodyTypesQuery->get();

        $categorise     = SparePartCategory::where('parent_id', 0)->where('status', 1)->get();
        $customerDetail = Auth::guard('customer')->user();


        $activeLanguage = \Session::get('language');
        $descript       = AdDescription::where('ad_id', $adsDetails->id)->where('language_id', $activeLanguage['id'])->first();

        $descriptionArray = array_filter(explode('#', $descript->description));

        $ads_suggessions  = $adsDetails->suggessions;
        if ($ads_suggessions) {
            foreach ($ads_suggessions as $values) {
                $sugge[] = $values->id;
            }
        }
        $suggestionsQuery   = Suggesstion::query()->select("sd.suggesstion_id", "sd.title", "sd.sentence")->where('status', 1);;
        $suggestionsQuery->join('suggesstion_descriptions AS sd', 'suggesstions.id', '=', 'sd.suggesstion_id')->where('language_id', $activeLanguage['id']);
        $suggestionsQuery->whereNotIn('sd.sentence', $descriptionArray);
        $suggestions       = $suggestionsQuery->get();

        if (isset($sugge) && !empty($sugge)) {
        }
        $adImages   = AdImage::where('ad_id', $adsDetails->id)->get();

        $models = Carmodel::where('make_id', $adsDetails->maker_id)->where('status', 1)->get();

        $engineTypeQuery = EngineType::query()->select("engine_type_id", "cd.title")->where('status', 1);
        $engineTypeQuery->join('engine_types_description AS cd', 'engine_types.id', '=', 'cd.engine_type_id')->where('language_id', $activeLanguage['id']);
        $engineTypes      = $engineTypeQuery->get();

         if (Auth::guard('customer')->user()->customer_role == 'individual') {
            $ads_pricing = AdsPricing::where('type','Car Ad')->where('user_category','Individual')->orderBy('number_of_days', 'ASC')->get();
        } else {
            $ads_pricing = AdsPricing::where('type','Car Ad')->where('user_category','Business')->orderBy('number_of_days', 'ASC')->get();
        }
        //userAdsInfo
        return view('users.ads.postRemovedAdsEdit', compact('adImages', 'countries', 'cities', 'years', 'suggestions', 'colors', 'categorise', 'customerDetail', 'bodyTypes', 'features', 'adsDetails', 'descript', 'page_description', 'activeLanguage', 'models', 'engineTypes', 'boughtFromCountries','ads_pricing'));
    }

    public function postRemovedAdUpdate(Request $request)
    { 
        $rules = [];
        if ($request->has('product_image') && ($request->get('product_image') != null || $request->get('product_image') == '')) {
            $base  = $request->get('product_image');
            $files = count($base) - 1;
            if ($files > 0) {
                foreach ($base as $index => $image_path) {
                    if (!empty($image_path)) {
                        $rules['product_image.' . $index] = 'base64max:99999048';
                    }
                }
            }
        }
        $validatedData = $request->validate($rules);

        $updateAdsCheck = false;
        $column_names = '';
        $old_values = '';
        $new_values = '';

        $id       =  $request->ads_id;
        $queryAds = Ad::where('id', $id)->where('customer_id', '=', Auth::guard('customer')->user()->id);
        $getAds   = $queryAds->first();

        $old_status = $getAds->status;
        if (@$getAds->status == 3) {
            @$getAds->status = 0;
            @$getAds->save();
        }

        $id               = $getAds->id;
        $description      = $request->description;
        $descriptionArray = explode('#', $description);
        $activeLanguage   = \Session::get('language');

        $inputs             = $request->except('_token', 'ads_id', 'engine_capacity', 'engine_power', 'suggessions', 'tags', 'product_image', 'number_of_days');
        if (!empty($request->features)) {
            $inputs['features'] = implode(",", $request->features);
        }

        if (!isset($inputs['neg'])) {
            $inputs['neg'] = 0;
        }
        if (!isset($inputs['vat'])) {
            $inputs['vat'] = 0;
        }

        /* DESCRIPTION UPDATE */
        /*SAVE ADS */
        $descript = AdDescription::where('ad_id', $id)->where('language_id', $activeLanguage['id'])->first();

        if ($descript == null && $description != '') {
            $getAds->ads_description()->create(
                [
                    'description' => trim($description, '#'),
                    'language_id'  => $activeLanguage['id']
                ]
            );
            $updateAdsCheck = true;
        } else if ($descript->description != $description && $description != '') {
            AdDescription::where('ad_id', $id)->where('language_id', $activeLanguage['id'])->update(["description" => $description]);
            AdDescription::where('ad_id', $id)->where('language_id', '!=', $activeLanguage['id'])->delete();
            $updateAdsCheck = true;

            $column_names .= 'Description,';
            $old_values .= $descript->description . ',';
            $new_values .=  ',' . $description . ',';
        }

        /* TAGS LOGIC STARTS HERE */
        $sugQuery = Suggesstion::query()->select('suggesstions.id')->where('suggesstions.status', 1);
        $sugQuery->whereIn('suggesstions.sentence', $descriptionArray)->where('language_id', '=', $activeLanguage['id']);
        $sugQuery->join('suggesstion_descriptions AS sd', 'sd.suggesstion_id', '=', 'suggesstions.id');
        $suggesstionIds = $sugQuery->get();

        $suggesstion_id = explode(',', $suggesstionIds->implode('id', ', '));

        $tagResult      = Tag::select('id')->whereIn('suggesstion_id', $suggesstion_id)->get();

        if ($tagResult->isNotEmpty()) {
            // delete the relationships with Tags (Pivot table) first.
            $getAds->tags()->detach();
            $getAds->tags()->attach($tagResult);
        }

        // UPOLOAD MULTIPE IMAGES
        $base = $request->get('product_image');

        if (!empty($base)) {
            //sizeof(array_filter($base)) > 0 && 
            $updateAdsCheck = true;
            $column_names .= 'Picture,';
            $old_values .= $getAds->ads_images->count() . ',';
            foreach ($base as $index => $base64) {
                if (!empty($base64)) {
                    $image = $this->uploadd($base64, $id);
                    if ($image != '0') {
                        $adImage        = new AdImage();
                        $adImage->ad_id = $id;
                        $adImage->img   = $image;
                        $adImage->save();
                    }
                }
            } // end for loop.
            $new_values .= $getAds->ads_images->count() . ',';
        } //Endif

        if ($inputs['body_type_id'] != $getAds->body_type_id) {
            $column_names .= 'Body Type,';
            $old_values .= $getAds->get_body_type_description($getAds->body_type_id, 2)->name . ',';
            $new_values .= $getAds->get_body_type_description($inputs['body_type_id'], 2)->name . ',';
        }
        if ($inputs['doors'] != $getAds->doors) {
            $column_names .= 'Doors,';
            $old_values .=  $getAds->doors . ',';
            $new_values .=  $inputs['doors'] . ',';
        }
        if ($inputs['millage'] != $getAds->millage) {

            $column_names .= 'Millage,';
            $old_values .= $getAds->millage . ',';
            $new_values .=  $inputs['millage'] . ',';
        }
        if ($inputs['color_id'] != $getAds->color_id) {
            $column_names .= 'Color,';
            $old_values .= $getAds->get_color_type_description($getAds->color_id, 2)->name . ',';
            $new_values .= $getAds->get_color_type_description($inputs['color_id'], 2)->name . ',';
        }
        if ($inputs['fuel_average'] != $getAds->fuel_average) {
            $column_names .= 'Fuel Average,';
            $old_values .= $getAds->fuel_average . ',';
            $new_values .=  $inputs['fuel_average'] . ',';
        }
        if ($inputs['price'] != $getAds->price) {
            $column_names .= 'Price,';
            $old_values .= $getAds->price . ',';
            $new_values .=  $inputs['price'] . ',';
        }
        if ($inputs['fuel_type'] != $getAds->fuel_type) {
            $column_names .= 'Fuel Type,';
            $old_values .= @$getAds->get_fuel_type_description($getAds->fuel_type, 2)->title . ',';
            $new_values .= @$getAds->get_fuel_type_description($inputs['fuel_type'], 2)->title . ',';
        }

        if ($updateAdsCheck) {
            if ($getAds->status == 2) {
                $inputs['status'] = 5;
            } else {
                $inputs['status'] = 0;
            }
        }
        unset($inputs['base']);
        $updateAds = $queryAds->update($inputs);

        if ($column_names != '' && $old_values != '' && $new_values != '') {
            $history = new PostsHistory;
            $history->user_id = Auth::guard('customer')->user()->id;
            $history->usertype = 'customer';
            $history->username = Auth::guard('customer')->user()->customer_company;
            $history->ad_id = $id;
            $history->column_name = $column_names;
            $history->status = $old_values;
            $history->new_status = $new_values;
            $history->type = 'car';
            $history->save();
        }

        $final_ad = Ad::find($id);
        $new_status = $final_ad->status;
        if ($old_status != $new_status) {

            if (!empty($request->number_of_days)) {

                $CarAds   = Ad::where('customer_id', Auth::guard('customer')->user()->id)->whereIn('status', [0, 1, 3])->get()->count();
                $ids = Ad::where('customer_id', Auth::guard('customer')->user()->id)->whereIn('status', [0, 1, 3])->pluck('id')->toArray();
                $account = CustomerAccount::where('customer_id', Auth::guard('customer')->user()->id)->where('type','car_ad')->where('status','!=',2)->whereIn('ad_id',$ids)->count();
                $difference = $CarAds - $account;


                if (Auth::guard('customer')->user()->customer_role == 'individual' && !empty($request->number_of_days)) {
                    $GeneralSetting  = GeneralSetting::select('ads_limit')->first();
                    $ad_limit           = $GeneralSetting->ads_limit !== null ? $GeneralSetting->ads_limit : 5;
                    $customer_type = 'Individual';
                }else{
                    $GeneralSetting  = GeneralSetting::select('b_ads_limit')->first();
                    $ad_limit           = $GeneralSetting->b_ads_limit !== null ? $GeneralSetting->b_ads_limit : 5;
                    $customer_type = 'Business';
                }

                if ($difference >= $ad_limit) {                   

                    $new_history = new AdsStatusHistory;
                    $new_history->user_id = Auth::guard('customer')->user()->id;
                    $new_history->usertype = 'customer';
                    $new_history->ad_id = $id;
                    $new_history->type = 'car';
                    $new_history->status = $new_history->ads_status($old_status);
                    $new_history->new_status = 'Created';
                    $new_history->save();

                    return $this->payForAds($request,$customer_type,$id);
                } 
            }
            
            else{
                $new_status = 0;
                $new_history = new AdsStatusHistory;
                $new_history->user_id = Auth::guard('customer')->user()->id;
                $new_history->usertype = 'customer';
                $new_history->ad_id = $id;
                $new_history->type = 'car';
                $new_history->status = $new_history->ads_status($old_status);
                $new_history->new_status = $new_history->ads_status($new_status);
                $new_history->save();
            }

            
        }
        //return 1;
        if ($request->ajax()) {
            return response()->json(array(
                'success' => true,
                'message' => 'Record Successfull Added.'
            ), 200);
        }
        return redirect('user/my-ads?status=0')->with('message', 'Record updated successfully.');
    }

    public function postUpdate(Request $request)
    {
        $rules = [];
        if ($request->has('product_image') && ($request->get('product_image') != null || $request->get('product_image') == '')) {
            $base  = $request->get('product_image');
            $files = count($base) - 1;
            if ($files > 0) {
                foreach ($base as $index => $image_path) {
                    if (!empty($image_path)) {
                        $rules['product_image.' . $index] = 'base64max:99999048';
                    }
                }
            }
        }
        $validatedData = $request->validate($rules);

        $updateAdsCheck = false;
        $column_names = '';
        $old_values = '';
        $new_values = '';

        $id       =  $request->ads_id;
        $queryAds = Ad::where('id', $id)->where('customer_id', '=', Auth::guard('customer')->user()->id);
        $getAds   = $queryAds->first();

        $old_status = $getAds->status;
        if (@$getAds->status == 3) {
            @$getAds->status = 0;
            @$getAds->save();
        }

        $id               = $getAds->id;
        $description      = $request->description;
        $descriptionArray = explode('#', $description);
        $activeLanguage   = \Session::get('language');

        $inputs             = $request->except('_token', 'ads_id', 'engine_capacity', 'engine_power', 'suggessions', 'tags', 'product_image');
        if (!empty($request->features)) {
            $inputs['features'] = implode(",", $request->features);
        }

        if (!isset($inputs['neg'])) {
            $inputs['neg'] = 0;
        }
        if (!isset($inputs['vat'])) {
            $inputs['vat'] = 0;
        }

        /* DESCRIPTION UPDATE */
        /*SAVE ADS */
        $descript = AdDescription::where('ad_id', $id)->where('language_id', $activeLanguage['id'])->first();
        if ($descript == null && $description != '') {
            $getAds->ads_description()->create(
                [
                    'description' => trim($description, '#'),
                    'language_id'  => $activeLanguage['id']
                ]
            );
            $updateAdsCheck = true;
        } else if ($descript->description != $description && $description != '') {
            AdDescription::where('ad_id', $id)->where('language_id', $activeLanguage['id'])->update(["description" => $description]);
            AdDescription::where('ad_id', $id)->where('language_id', '!=', $activeLanguage['id'])->delete();
            $updateAdsCheck = true;

            $column_names .= 'Description,';
            $old_values .= $descript->description . ',';
            $new_values .=  ',' . $description . ',';
        }
        /* TAGS LOGIC STARTS HERE */
        $sugQuery = Suggesstion::query()->select('suggesstions.id')->where('suggesstions.status', 1);
        $sugQuery->whereIn('suggesstions.sentence', $descriptionArray)->where('language_id', '=', $activeLanguage['id']);
        $sugQuery->join('suggesstion_descriptions AS sd', 'sd.suggesstion_id', '=', 'suggesstions.id');
        $suggesstionIds = $sugQuery->get();

        $suggesstion_id = explode(',', $suggesstionIds->implode('id', ', '));

        $tagResult      = Tag::select('id')->whereIn('suggesstion_id', $suggesstion_id)->get();

        if ($tagResult->isNotEmpty()) {
            // delete the relationships with Tags (Pivot table) first.
            $getAds->tags()->detach();
            $getAds->tags()->attach($tagResult);
        }
        // UPOLOAD MULTIPE IMAGES
        $base = $request->get('product_image');
        $new_imgs = [];
        foreach($base as $b)
        {
            if(!is_null($b))
            {
                $new_imgs[].= $b;
            }
        }

        $no_of_new_imgs = count($new_imgs);
        if (!empty($base && $no_of_new_imgs != 0)) {
            //sizeof(array_filter($base)) > 0 && 
            $updateAdsCheck = true;
            $column_names .= 'Picture,';
            $old_values .= $getAds->ads_images->count() . ',';
            foreach ($base as $index => $base64) {
                if (!empty($base64)) {
                    $image = $this->uploadd($base64, $id);
                    if ($image != '0') {
                        $adImage        = new AdImage();
                        $adImage->ad_id = $id;
                        $adImage->img   = $image;
                        $adImage->save();
                    }
                }
            } // end for loop.
            $new_values .= $getAds->ads_images->count() . ',';
        } //Endif 



        if ($inputs['body_type_id'] != $getAds->body_type_id) {
            $column_names .= 'Body Type,';
            $old_values .= $getAds->get_body_type_description($getAds->body_type_id, 2)->name . ',';
            $new_values .= $getAds->get_body_type_description($inputs['body_type_id'], 2)->name . ',';
        }
        if ($inputs['doors'] != $getAds->doors) {
            $column_names .= 'Doors,';
            $old_values .=  $getAds->doors . ',';
            $new_values .=  $inputs['doors'] . ',';
        }
        if ($inputs['millage'] != $getAds->millage) {

            $column_names .= 'Millage,';
            $old_values .= $getAds->millage . ',';
            $new_values .=  $inputs['millage'] . ',';
        }
        if ($inputs['color_id'] != $getAds->color_id) {
            $column_names .= 'Color,';
            $old_values .= $getAds->get_color_type_description($getAds->color_id, 2)->name . ',';
            $new_values .= $getAds->get_color_type_description($inputs['color_id'], 2)->name . ',';
        }
        if ($inputs['fuel_average'] != $getAds->fuel_average) {
            $column_names .= 'Fuel Average,';
            $old_values .= $getAds->fuel_average . ',';
            $new_values .=  $inputs['fuel_average'] . ',';
        }
        if ($inputs['price'] != $getAds->price) {
            $column_names .= 'Price,';
            $old_values .= $getAds->price . ',';
            $new_values .=  $inputs['price'] . ',';
        }
        if ($inputs['fuel_type'] != $getAds->fuel_type) {
            $column_names .= 'Fuel Type,';
            $old_values .= @$getAds->get_fuel_type_description($getAds->fuel_type, 2)->title . ',';
            $new_values .= @$getAds->get_fuel_type_description($inputs['fuel_type'], 2)->title . ',';
        }
        if ($updateAdsCheck) {
            $inputs['status'] = 0;
        }
        unset($inputs['base']);
        // dd($inputs);
        $updateAds = $queryAds->update($inputs);

        if ($column_names != '' && $old_values != '' && $new_values != '') {
            $history = new PostsHistory;
            $history->user_id = Auth::guard('customer')->user()->id;
            $history->usertype = 'customer';
            $history->username = Auth::guard('customer')->user()->customer_company;
            $history->ad_id = $id;
            $history->column_name = $column_names;
            $history->status = $old_values;
            $history->new_status = $new_values;
            $history->type = 'car';
            $history->save();
        }

        $final_ad = Ad::find($id);
        $new_status = $final_ad->status;
        if ($old_status != $new_status) {

            $new_history = new AdsStatusHistory;
            $new_history->user_id = Auth::guard('customer')->user()->id;
            $new_history->usertype = 'customer';
            $new_history->ad_id = $id;
            $new_history->type = 'car';
            $new_history->status = $new_history->ads_status($old_status);
            $new_history->new_status = $new_history->ads_status($new_status);
            $new_history->save();
        }
        //return 1;
        if ($request->ajax()) {
            return response()->json(array(
                'success' => true,
                'message' => 'Record Successfull Added.'
            ), 200);
        }
        // return redirect('user/my-profile')->with('ad_added', 10);
        return redirect('user/my-ads?status=0')->with('message', 'Record updated successfully.');
        // return \Redirect::back()->with('message', 'Record updated successfully.');redirect('/user/my-ads');
    }

    public function postDescriptionEdit($id)
    {
        $adsDetails     = Ad::where('id', $id)->where('customer_id', '=', Auth::guard('customer')->user()->id)->first();
        if ($adsDetails == null) {
            return redirect()->back()->with('error', 'Record could not be found.');
        }
        $activeLanguage = \Session::get('language');
        $descript       = AdDescription::where('ad_id', $adsDetails->id)->where('language_id', $activeLanguage['id'])->first();
        $ads_suggessions    = $adsDetails->suggessions;
        if ($ads_suggessions) {
            foreach ($ads_suggessions as $values) {
                $sugge[] = $values->id;
            }
        }
        $suggestionsQuery   = Suggesstion::query()->select("sd.suggesstion_id", "sd.title", "sd.sentence")->where('status', 1);
        $suggestionsQuery->join('suggesstion_descriptions AS sd', 'suggesstions.id', '=', 'sd.suggesstion_id')->where('language_id', $activeLanguage['id']);
        $suggestions       = $suggestionsQuery->get();

        return view('users.ads.userAdsDescriptions', compact('adsDetails', 'suggestions', 'descript'));
    }

    public function postDescriptionUpdate(Request $request)
    {
        $id              = $request->id;
        $getAds          = Ad::find($id);
        if ($getAds == null) {
            return redirect()->back()->with('error', 'Record could not be found.');
        }
        $description     = $request->description;
        /*SAVE ADS */
        $activeLanguage = \Session::get('language');
        //Flash::overlay(Lang::get('rocketcandy.success-job-create'));
        $descript = AdDescription::where('ad_id', $request->id)->where('language_id', $activeLanguage['id'])->get();

        if ($descript->isEmpty()) {
            $getAds->ads_description()->create(
                [
                    'description' => trim($description, '.'),
                    'language_id'  => $activeLanguage['id']
                ]
            );
        } else {
            AdDescription::where('ad_id', $request->id)->where('language_id', $activeLanguage['id'])->update(["description" => $description]);
        }

        // delete the relationships with Tags (Pivot table) first.
        $getAds->suggessions()->detach();

        /*SAVE TAGS*/
        if ($request->tags != null) {
            if (count($request->tags) > 0) {
                $getAds->suggessions()->attach($request->tags);
            }
        }
        //Flash::overlay(Lang::get('rocketcandy.success-job-create'));
        return \Redirect::back();
    }
    public function postImagesEdit($id)
    {
        $adsDetails = Ad::where('id', $id)->where('customer_id', '=', Auth::guard('customer')->user()->id)->first();
        if ($adsDetails == null) {
            return redirect()->back()->with('error', 'Record could not be found.');
        }
        $adImages   = AdImage::where('ad_id', $adsDetails->id)->get();
        return view('users.ads.userAdsImages', compact('adImages', 'adsDetails'));
    }
    public function postImagesUpdate(Request $request)
    {
        $adsDetails = Ad::where('id', $request->ad_id)->where('customer_id', '=', Auth::guard('customer')->user()->id)->first();
        if ($adsDetails == null) {
            return redirect()->back()->with('error', 'Record could not be found.');
        }


        $images = $request->file;
        if ($images) {
            foreach ($images as $image) {
                $imageName       = 'ad-' . time() . '-' . rand(000000, 999999) . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('uploads/ad_pictures/cars/' . $request->ad_id . '/');
                $image->move($destinationPath, $imageName);
                $adImage        = new AdImage();
                $adImage->ad_id = $request->ad_id;
                $adImage->img   = $imageName;
                $adImage->save();
            }
            return redirect()->back()->with('message', 'Record Saved Successfully.');
        } else {
            return redirect()->back()->with('error', 'Record could not be saved.');
        }
    }
    public function postImagesDelete()
    {
        $request     = request()->all();
        $imageid     = $request['img_id'];
        $adsid     = $request['ad_id'];
        $adsDetails = Ad::where('id', $adsid)->where('customer_id', '=', Auth::guard('customer')->user()->id)->first();
        if ($adsDetails == null) {
            return response()->json(['success' => false]);
        }

        $ads_image = AdImage::where('id', $imageid)->where('ad_id',$adsid)->first();
        if($ads_image) 
        {
        $image_path =  'public/uploads/ad_pictures/cars/' . @$ads_image->ad_id . '/' . @$ads_image->img;  
        if(File::exists($image_path)) {
        File::delete($image_path);
        }
        }

        $deletedRows = AdImage::where('id', $imageid)->where('ad_id', '=', $adsid)->delete();
        if ($deletedRows) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function serviceImagesDelete()
    {
        $request     = request()->all();
        $imageid     = $request['img_id'];
        $adsid       = $request['ad_id'];
        $adsDetails  = Services::where('id', $adsid)->where('customer_id', '=', Auth::guard('customer')->user()->id)->first();
        if ($adsDetails == null) {
            return response()->json(['success' => false]);
        }
        $findImage = ServiceImage::where('id', $imageid)->where('service_id', '=', $adsid)->first();
        if ($findImage) {
            $fullPath = public_path('uploads/ad_pictures/services/' . $findImage->service_id . '/' . $findImage->image_name);
            unlink($fullPath);
            $deletedRows = $findImage->delete();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function getSpearPartSubCategories($id, Request $request)
    {
        $activeLanguage = \Session::get('language');
        // dd($id);
        $skips = ["[", "]", "\""];
        $class = '';
        if ($request->sub_id != null) {
            $class = "active";
        }
        $sub_categories = SparePartCategory::where('parent_id', $id)->where('status', 1)->get();
        $html = '';
        foreach ($sub_categories as $sub_category) {
            $caty = ($sub_category->get_category_title()->where('language_id', $activeLanguage['id'])->pluck('title')->first());
            if (@$request->sub_id == $sub_category->id) {
                // dd('here');

                $html = $html . '
        <li onclick="selectCategory(this)" data-title="' . $caty . '" data-id="' . $sub_category->id . '" data-filter="' . $sub_category->filter . '" class="list-active"><a class="align-items-center d-flex justify-content-between" href="JavaScript:void(0)" >' . $caty . '</a></li>';
            } else {
                $html = $html . '
        <li onclick="selectCategory(this)" data-title="' . $caty . '" data-id="' . $sub_category->id . '" data-filter="' . $sub_category->filter . '" ><a class="align-items-center d-flex justify-content-between" href="JavaScript:void(0)">' . $caty . '</a></li>';
            }
        }
        return $html;
    }
    public function getSubCategories($id)
    {
        $activeLanguage = \Session::get('language');
        // $sub_categories = SparePartCategory::where('parent_id',$id)->get();
        $sub_categories = SubService::where('primary_service_id', $id)->where('parent_id', 0)->where('status', 1)->orderBy('title', 'ASC')->get();

        $html = '';
        foreach ($sub_categories as $sub_category) {

            $skips = ["[", "]", "\""];
            $p_caty = ($sub_category->get_category_title()->where('language_id', $activeLanguage['id'])->pluck('title')->first());
            $html = $html . '<li onclick="selectCategory(this)" data-title="' . $sub_category->title . '" data-id="' . $sub_category->id . '" ><a class="align-items-center d-flex justify-content-between" href="JavaScript:void(0)">' . ($p_caty !== null ? $p_caty : $sub_category->title) . '<em class="fa fa-angle-right"></em></a></li>';
        }
        return $html;
    }

    public function getSubSubCategories($id)
    {

        $activeLanguage = \Session::get('language');

        $sub_categories = SubService::where('parent_id', $id)->where('status', 1)->orderBy('title', 'ASC')->get();
        //dd($id,$sub_categories);

        if ($sub_categories->count() == 0) {
            $html = '';
            $index = 0;
            $sub = SubService::where('id', $id)->first();
            if ($sub->is_make == 1) {
                $sub_categories = make::where('status', 1)->orderBy('title', 'ASC')->get();
                foreach ($sub_categories as $sub_category) {
                    $html = $html . '
        <li  onclick="selectSubCategory(this)"  data-title="' . $sub_category->title . '" data-id="' . $sub_category->id . '" ><a class="align-items-center d-flex justify-content-between"  data-dismiss="modal" href="JavaScript:void(0)">' . $sub_category->title . '</a></li>';
                    $index++;
                }
            }
            return $html;
        }

        $html = '';
        $index = 0;

        //dd($sub_categories);
        foreach ($sub_categories as $sub_category) {
            $skips = ["[", "]", "\""];
            $p_caty = ($sub_category->get_category_title()->where('language_id', $activeLanguage['id'])->pluck('title')->first());
            // $found = in_array($sub_category->id, $request->ids);
            // $found = array_search($sub_category->id, $request->ids);


            /*            $html = $html . '
        <li><a href="javascript:void(0)"><input type="checkbox" ' . (@$found ? "checked" : "") . ' class="sub_services" id="' . @$sub_category->id . '" value=' . @$sub_category->id . '> ' . ($p_caty !== null ? $p_caty : $sub_category->title) . ' <span style="color:red;" class="d-none" id="found' . @$sub_category->id . '">Already Checked! </span></a></li>';*/
            $html = $html . '
        <li  onclick="selectSubCategory(this)" data-title="' . $sub_category->title . '" data-id="' . $sub_category->id . '" ><a class="align-items-center d-flex justify-content-between"  data-dismiss="modal" href="JavaScript:void(0)">' . ($p_caty !== null ? $p_caty : $sub_category->title) . '</a></li>';

            $index++;
        }
        return $html;
    }

    public function getSubCategoriess(Request $request, $id)
    {
        $activeLanguage = \Session::get('language');
        $make_ids = [];
        $cat_ids = [];
        if ($request->ids != null) {
            foreach ($request->ids as $idd) {
                if ($idd[0] == 'm') {
                    array_push($make_ids, $idd[4]);
                } else {
                    array_push($cat_ids, $idd);
                }
            }
        }

        $sub_categories = SubService::where('parent_id', $id)->where('status', 1)->get();
        if ($sub_categories->count() == 0) {
            $html = '';
            $index = 0;
            $sub = SubService::where('id', $id)->first();
            $sub_categories = make::where('status', 1)->get();
            foreach ($sub_categories as $sub_category) {
                if ($request->ids != null) {
                    if (in_array($sub_category->id, @$make_ids)) {
                        $found = true;
                    } else {
                        $found = false;
                    }
                }
                $html = $html . '
        <li><a href="javascript:void(0)"><input type="checkbox" ' . (@$found ? "checked" : "") . ' class="make_sub_services" id="' . @$sub_category->id . '" value=' . @$sub_category->id . '> ' . $sub_category->title . ' <span style="color:red;" class="d-none" id="found' . @$sub_category->id . '">Already Checked! </span></a></li>';
                $index++;
            }
            return response()->json(['html' => $html, 'id' => $id]);
        }

        $html = '';
        $index = 0;
        foreach ($sub_categories as $sub_category) {
            $skips = ["[", "]", "\""];
            $p_caty = ($sub_category->get_category_title()->where('language_id', $activeLanguage['id'])->pluck('title')->first());
            // $found = in_array($sub_category->id, $request->ids);
            // $found = array_search($sub_category->id, $request->ids);
            if ($request->ids != null) {
                if (in_array($sub_category->id, @$request->ids)) {
                    $found = true;
                } else {
                    $found = false;
                }
            }

            $html = $html . '
        <li><a href="javascript:void(0)"><input type="checkbox" ' . (@$found ? "checked" : "") . ' class="sub_services" id="' . @$sub_category->id . '" value=' . @$sub_category->id . '> ' . ($p_caty !== null ? $p_caty : $sub_category->title) . ' <span style="color:red;" class="d-none" id="found' . @$sub_category->id . '">Already Checked! </span></a></li>';
            $index++;
        }
        return response()->json(['html' => $html, 'id' => 'null']);
        return $html;
    }
    public function getMakersModels()
    {
        if (request()->ajax()) {

            $makes  =  make::where('status', 1)->get();
            $models = carmodel::where('status', 1)->get();
            $grouped_models = array();
            foreach ($models as $showmodels) {
                $grouped_models[$showmodels->make_id][] = array('id' => $showmodels->id, 'name' => $showmodels->name);
            }

            $html = '<div class="col-md-3 col-sm-12 car-info-list-col make-list-col car-list-active"  >
                        <h6 class="post-ad-modal-title d-flex align-items-center mb-4"><em class="d-md-none fa fa-arrow-circle-left gobackIcon mr-2"></em> ' . Lang::get('postCarAdPage.carInfoPopupMake') . '</h6>
                        <div class="post-modal-list" id="post-modal-list">
                        <ul class="make-listings list-unstyled"> 
                        <li class="heading"><h5>Popular</h5></li>';
            foreach ($makes as $make) {
                $html .= '<li>
              <a href="javascript:void(0)" class="align-items-center d-flex makes" data-make="' . $make->id . '" id="make_' . $make->id . '" data-title="' . $make->title . '">
                  <span class="car-make-logo suzuki"></span>' . $make->title . '<i class="fa ml-auto fa-angle-right"></i>
                  </a></li>';
            }
            $html .= '</ul></div></div>';

            foreach ($grouped_models as $keys => $models_array) {
                $html .= '
                    <div class="col-md-3 col-sm-12 car-info-list-col modal-list-col models_for_' . $keys . '" style="display: none">
                        <h6 class="post-ad-modal-title d-flex align-items-center mb-4"><em class="d-md-none fa fa-arrow-circle-left gobackIcon mr-2"></em> ' . Lang::get('postCarAdPage.carInfoPopupModel') . '</h6>
                        <div class="post-modal-list">
                        <ul class="list-unstyled modal-listings">';
                foreach ($models_array as $model_values) {
                    $html .= '<li class="models"  data-model="' . $model_values['id'] . '" id="model_' . $model_values['id'] . '" data-title="' . $model_values['name'] . '"><a href="javascript:void(0)" class="align-items-center d-flex justify-content-between">' . $model_values['name'] . ' <i class="fa fa-angle-right"></i></a></li>';
                }

                $html .= '</ul></div></div>';
            }
        } else {
            $html = response('Forbidden.', 403);
        }

        return $html;
    }
    public function getVersionDetails($id)
    {
        if (request()->ajax()) {
            $versions = Version::find($id);
            return $versions;
        } else {
            return response()->json(['error' => true]);
        }
    }
    public function getModelsVersions($model_id)
    {
        $html = '<h6 class="post-ad-modal-title d-flex align-items-center mb-4"><em class="d-md-none fa fa-arrow-circle-left gobackIcon mr-2"></em> ' . Lang::get('postCarAdPage.carInfoPopupVersion') . '</h6>
                        <div class="post-modal-list">
                        <ul class="list-unstyled version-listings">';
        if (request()->ajax()) {
            $versions = Version::where('model_id', $model_id)->get();
            $set_versions = array();
            if (!$versions->isEmpty()) {
                foreach ($versions as $show_versions) {
                    $set_versions[$show_versions['label']][] = array(
                        'vearsion_title' => $show_versions['name'],
                        'version_id' => $show_versions['id']
                    );
                } // END FOREACH

                foreach ($set_versions as $keys => $versions_array) {
                    $html .= ' <li class="heading"><h5>' . $keys . '</h5></li>';
                    foreach ($versions_array as $versions_values) {
                        $html .= '
                <li class="versions" data-title="' . $versions_values['vearsion_title'] . '" data-version="' . $versions_values['version_id'] . '" id="version_' . $versions_values['version_id'] . '" data-cc="' . $versions_values['cc'] . '"  data-power="' . $versions_values['kilowatt'] . '"><a href="javascript:void(0)">' . $versions_values['vearsion_title'] . '</a></li>
                        ';
                    } // END FOREACH INNER

                } // END FOREACH
            } // end of if
            else {
                $html .= '<li><a href="javascript:void(0)"><strong> ' . Lang::get('postCarAdPage.carInfoPopupNoData') . '</strong></a></li>';
            } // END OF ELSE

        } else {
            $html .= response('Forbidden.', 403);
        }
        $html .= '</ul></div>';
        return $html;
    }
    public function getModelsByYearVersions($model_id, $year)
    {

        $html = '<h6 class="post-ad-modal-title d-flex align-items-center mb-4"><em class="d-md-none fa fa-arrow-circle-left gobackIcon mr-2"></em> ' . Lang::get('postCarAdPage.carInfoPopupVersion') . '</h6>
                        <div class="post-modal-list">
                        <ul class="list-unstyled version-listings">';
        if (request()->ajax()) {
            $versions = Version::where('model_id', $model_id)->where('from_date', $year)->orWhere('to_date', $year)->get();;
            $set_versions = array();
            if (!$versions->isEmpty()) {
                foreach ($versions as $show_versions) {
                    $set_versions[$show_versions['label']][] = array(
                        'vearsion_title' => $show_versions['name'],
                        'version_id' => $show_versions['id']
                    );
                } // END FOREACH


                foreach ($set_versions as $keys => $versions_array) {
                    $html .= ' <li class="heading"><h5>' . $keys . '</h5></li>';
                    foreach ($versions_array as $versions_values) {
                        $html .= '
                <li class="versions" data-title="' . $versions_values['vearsion_title'] . '"  data-version="' . $versions_values['version_id'] . '" id="version_' . $versions_values['version_id'] . '" data-cc="' . $versions_values['cc'] . '"  data-power="' . $versions_values['kilowatt'] . '"><a href="javascript:void(0)">' . $versions_values['vearsion_title'] . '</a></li>
                        ';
                    } // END FOREACH INNER

                } // END FOREACH
            } // end of if
            else {
                $html .= '<li><a href="javascript:void(0)"><strong> ' . Lang::get('postCarAdPage.carInfoPopupNoData') . '</strong></a></li>';
            } // END OF ELSE

        } else {
            $html .= response('Forbidden.', 403);
        }
        $html .= '</ul></div>';
        return $html;
    }
    public function getMakers($id)
    {
        $makers_ids = CarYear::where('year_id', $id)->pluck('car_id')->toArray();
        $makers = Car::whereIn('id', $makers_ids)->get();
        $html = '';
        foreach ($makers as $maker) {
            $html = $html . '
            <li onclick="getModels(this)" data-id="' . $maker->id . '" >' . $maker->title . '</li>
            ';
        }
        return $html;
    }
    public function getModels($id)
    {
        $maker = Car::find($id);
        $models = Car::where('parent_id', $maker->id)->get();
        $html = '';
        foreach ($models as $model) {
            $html = $html . '
            <li onclick="fillInfo(this)" data-id="' . $model->id . '" >' . $model->title . '</li>
            ';
        }
        return $html;
    }
    public function fillInput($year_id, $maker_id, $model_id)
    {
        $year = Year::find($year_id)->title;
        $maker = Car::find($maker_id)->title;
        $model = Car::find($model_id)->title;
        $data = $year . ' / ' . $maker . ' / ' . $model;
        return $data;
    }

    public function createService($id = null)
    {
        $activeLanguage = \Session::get('language');
        // dd($id);
        if ($id != null) {
            $services = Services::where('id', $id)->first();
            $service_description = ServiceDescription::where('service_id', $id)->first();
        } else {
            $services = null;
            $service_description = null;
        }
        $categorise = SparePartCategory::where('parent_id', 0)->where('status', 1)->get();
        $customer = Customer::where('id', Auth::guard('customer')->user()->id)->first();
        $timings = CustomerTiming::where('customer_id', Auth::guard('customer')->user()->id)->get();
        $primaryServices = PrimaryService::where('status', 1)->orderBy('title', 'ASC')->get();

        $page_descriptionQuery = Page::query()->select("pd.title", "pd.description");
        $page_descriptionQuery->join('page_desciption AS pd', 'pages.id', '=', 'pd.page_id')->where('pd.language_id', $activeLanguage['id']);
        $page_description = $page_descriptionQuery->where('page_id', 5)->first();
        
        $sumCredit = CustomerAccount::where('customer_id', Auth::guard('customer')->user()->id)->where('status', 1)->sum('credit');
        $sumDebit  = CustomerAccount::where('customer_id', Auth::guard('customer')->user()->id)->sum('debit');
        $credit           = $sumCredit - $sumDebit;

        $ads_pricing = AdsPricing::where('type','Offer Service Ad')->where('user_category','Business')->orderBy('number_of_days', 'ASC')->get();

        return view('users.ads.serviceForm', compact('categorise', 'customer', 'timings', 'primaryServices', 'services', 'service_description', 'page_description','ads_pricing','credit'));
    }

    
    public function carAlerts()
    {
        $makes = make::where('status', 1)->get();
        $models = carmodel::where('status', 1)->get();
        $cities = City::where('status', 1)->get();
        // dd($cities);
        return view('Customers.alerts', compact('makes', 'models', 'cities'));
    }
    public function saveAccessoryAlerts(Request $request)
    {
        // dd($request->all());
        $alert = new AccessoriesAlert;
        $alert->customer_id = @Auth::guard('customer')->user()->id;
        $alert->category_id = $request->category;
        $alert->sub_category_id = $request->sub_category;
        $alert->price_from = $request->price_from;
        $alert->price_to = $request->price_to;
        $alert->frequency = $request->frequency;
        $alert->save();
        return redirect()->back()->with('message', 'Alert Has Been Created !');
    }
    public function getSparePartSubCategory(Request $request)
    {
        // dd($request->all());
        $sub_categories = SparePartCategory::where('parent_id', @$request->id)->where('status', 1)->get();

        $html_string = '';
        foreach ($sub_categories as $sub) {
            $html_string .= '<option value=' . $sub->id . '>' . $sub->title . '</option>';
        }
        return response()->json(['html' => $html_string]);
    }
    public function accessoryAlerts()
    {
        $categories = SparePartCategory::where('parent_id', 0)->where('status', 1)->get();
        $subCategories = SparePartCategory::where('parent_id', '!=', 0)->where('status', 1)->get();
        $cities = City::where('status', 1)->get();

        return view('Customers.accessories-alerts', compact('categories', 'subCategories', 'cities'));
    }
    public function saveCarAlerts(Request $request)
    {
        $alert = new MyAlert;

        $alert->car_make = $request->car_make;
        $alert->customer_id = Auth::guard('customer')->user()->id;
        $alert->car_model = $request->car_model;
        $alert->city = $request->city;
        $alert->price_from = $request->price_from;
        $alert->price_to = $request->price_to;
        $alert->year_from = $request->year_from;
        $alert->year_to = $request->year_to;
        $alert->mileage_from = $request->mileage_from;
        $alert->mileage_to = $request->mileage_to;
        $alert->transmission = $request->transmission;
        $alert->frequenct = $request->frequency;
        $alert->save();
        return redirect()->back()->with('message', 'Alert Has Been Created !');;

        // dd($request->all());
    }


    //Service Related Functions
    public function saveService(Request $request)
    {

        $rules = array();
        $base = 0;
        if ($request->has('product_image') && ($request->get('product_image') != null || $request->get('product_image') == '')) {
            $base  = $request->get('product_image');
            $files = count($base) - 1;
            if ($files > 0) {
                foreach ($base as $index => $image_path) {
                    if (!empty($image_path)) {
                        $rules['product_image.' . $index] = 'base64max:99999048';
                    }
                }
            }
        }
        $validatedData       = $request->validate($rules);

        $primary_id          = $request->category_id;
        $sub_category_id     = $request->sub_category_id;
        $sub_sub_category_id = $request->sub_sub_category_id;

        $existCheck = Services::where('customer_id', Auth::guard('customer')->user()->id)->where('primary_service_id', $primary_id)->first();
        $services = new Services();
        $services->customer_id = Auth::guard('customer')->user()->id;
        $services->primary_service_id = $request->category_id;
        $services->sub_service_id = $request->sub_category_id;
        $services->sub_sub_service_id = $request->sub_sub_category_id;
        $services->address_of_service = $request->address;
        $services->service_website = $request->website;
        $services->phone_of_service = $request->phone;
        $services->poster_name = 'end';
        $services->poster_email = 'end';
        $services->poster_phone = 'end';
        $services->save();

        $activeLanguage = \Session::get('language');

        if (@$request->description != null) {
            $spare_des = new ServiceDescription;
            $spare_des->language_id =  $activeLanguage['id'];
            $spare_des->service_id = $services->id;
            $spare_des->description = $request->description;
            $spare_des->save();
        }

        if (@$request->title != null) {
            $service_title = new ServiceTitle;

            $service_title->language_id = $activeLanguage['id'];
            $service_title->services_id = $services->id;
            $service_title->title = $request->title;
            $service_title->save();
        }

        // UPOLOAD MULTIPE IMAGES 
        if (sizeof($base) > 0) {
            foreach ($base as $index => $base64) {
                if (!empty($base64)) {
                    $image = $this->upload($base64, $services->id, 'uploads/ad_pictures/services/');
                    if ($image != '0') {
                        $adImage = new ServiceImage();
                        $adImage->service_id = $services->id;
                        $adImage->image_name = $image;
                        $adImage->save();
                    }
                } // endif 
            } // end for loop.

        } //Endif 

        $ServiceAds    = Services::where('customer_id', Auth::guard('customer')->user()->id)->whereIn('status', [0, 1, 3])->get()->count();
        $ids = Services::where('customer_id', Auth::guard('customer')->user()->id)->whereIn('status', [0, 1, 3])->pluck('id')->toArray();
        $account = CustomerAccount::where('customer_id', Auth::guard('customer')->user()->id)->where('type','service_ad')->where('status','!=',2)->whereIn('ad_id',$ids)->count();
        $difference = $ServiceAds - $account;

        $GeneralSetting  = GeneralSetting::select('b_service_limit')->first();
        $ad_limit           = $GeneralSetting->b_service_limit !== null ? $GeneralSetting->b_service_limit : 5;
        $customer_type = 'Business';


        if ($difference > $ad_limit) {
            return $this->payForServices($request,$customer_type,$services->id);
        } 
        else {
            $new_history             = new AdsStatusHistory;
            $new_history->user_id    = Auth::guard('customer')->user()->id;
            $new_history->usertype   = 'customer';
            $new_history->ad_id      = $services->id;
            $new_history->type       = 'offerservice';
            $new_history->status     = 'Created';
            $new_history->new_status = 'Pending';
            $new_history->save();
        }


        $data = [
            'poster_name' => $services->get_customer->customer_company,
            'title'       => @$service_title->title
        ];
        $templatee = EmailTemplate::where('type', 1)->first();
        $template = EmailTemplateDescription::where('email_template_id', $templatee->id)->where('language_id', @$services->get_customer->language_id)->first();
        Mail::to($services->get_customer->customer_email_address)->send(new CarAd($data, $template));

        if ($request->ajax()) {
            return response()->json(array(
                'success' => true,
                'message' => 'Record Successfull Added.'
            ), 200);
        }

        return redirect('user/my-services-ads?status=0')->with('offer_service', 'created');
    }
    private function payForServices($request,$customer_type,$service_id)
    {
        $activeLanguage = \Session::get('language');
        $credit             = 0;
        $paid_amount        = 0;
        $customer_id        = Auth::guard('customer')->user()->id;
        $sumCredit = CustomerAccount::where('customer_id', Auth::guard('customer')->user()->id)->where('status', 1)->sum('credit');
        $sumDebit  = CustomerAccount::where('customer_id', Auth::guard('customer')->user()->id)->sum('debit');
        $credit           = $sumCredit - $sumDebit;

        
        $paid_amount = AdsPricing::where('type','Offer Service Ad')->where('user_category','Business')->where('number_of_days',$request->number_of_days)->orderBy('id','DESC')->pluck('pricing')->first();
    

        $account = new CustomerAccount;
        $ad      = Services::find($service_id);

        if ($request->use_balance == 'on') {
            $start               = Carbon::now();
            $partial             = false;
            $result              = array('success' => true, 'payment_status' => 'full');
            $start->addDays($request->number_of_days);
            $featured_until = $start->endOfDay()->toDateTimeString();

            $account->customer_id = $customer_id;
            $account->ad_id       = $service_id;
            $account->debit       = $paid_amount;

            if ($paid_amount > $credit) {
                $remaining_balance        = $paid_amount - $credit;
                $account->debit           = $credit;
                $paid_amount              = $remaining_balance;
                $partial                  = true;
                $result['payment_status'] = 'partial';
            }
            $account->detail         = 'Post An Service';
            $account->number_of_days = $request->number_of_days;
            $account->paid_amount    = @$paid_amount;
            $account->status         = 1;
            $account->type           = 'offerservice_ad';
            $account->save();

            if ($partial == false) {
                $ad->status              = 0;
                $ad->save();

                $new_history             = new AdsStatusHistory;
                $new_history->user_id    = Auth::guard('customer')->user()->id;
                $new_history->usertype   = 'customer';
                $new_history->ad_id      = $service_id;
                $new_history->type       = 'offerservice';
                $new_history->status     = 'Created';
                $new_history->new_status = 'Pending';
                $new_history->save();
            }else{

                $ad->status              = 5;
                $ad->save();

                $new_history             = new AdsStatusHistory;
                $new_history->user_id    = Auth::guard('customer')->user()->id;
                $new_history->usertype   = 'customer';
                $new_history->ad_id      = $service_id;
                $new_history->type       = 'offerservice';
                $new_history->status     = 'Created';
                $new_history->new_status = 'UnPaid';
                $new_history->save();
            }

            $result['invoice_id']    = $account->id;

        } 
        else {
            $ad->status = 5;
            $ad->save();

            $new_request                  = $account;
            $new_request->ad_id           = $service_id;
            $new_request->customer_id     = Auth::guard('customer')->user()->id;
            $new_request->number_of_days  = $request->number_of_days;
            $new_request->paid_amount     = @$paid_amount;
            $new_request->status          = 0;
            $new_request->type            = 'offerservice_ad';
            $new_request->detail          = 'Post An Service';
            $new_request->save();

            $new_history             = new AdsStatusHistory;
            $new_history->user_id    = Auth::guard('customer')->user()->id;
            $new_history->usertype   = 'customer';
            $new_history->ad_id      = $service_id;
            $new_history->type       = 'offerservice';
            $new_history->status     = 'Created';
            $new_history->new_status = 'UnPaid';
            $new_history->save();

             $result['invoice_id']    = $new_request->id;

        }
        
        $service_title = ServiceTitle::where('services_id',$service_id)->where('language_id',$activeLanguage['id'])->pluck('title')->first();
         $data = [
                'poster_name' => $request->poster_name,
                'title'       => @$service_title
            ];
        $templatee = EmailTemplate::where('type', 1)->first();
        $template  = EmailTemplateDescription::where('email_template_id', $templatee->id)->where('language_id', $activeLanguage['id'])->first();
        Mail::to($request->poster_email)->send(new CarAd($data, $template));


        if ($account->credit != '' || $account->paid_amount) {
                $invoice_attachment = '<a href="' . route('pay-invoice-pdf', ['id' => @$account->id]) . '" target="_blank" style="text-decoration:none;">C' . @$account->id . '</a>';
            } 
            

            $pay_data = [
                'poster_name' => @$request->poster_name,
                'title'       => @$service_title,
                'invoice_pdf' =>  @$invoice_attachment
            ];

            //added by usman
            $pay_templatee = EmailTemplate::where('type', 14)->first(); // email for ad payment
            $pay_template  = EmailTemplateDescription::where('email_template_id', $pay_templatee->id)->where('language_id', $activeLanguage['id'])->first();
            Mail::to($request->poster_email)->send(new PayForAd($pay_data, $pay_template));

            return response()->json($result);
    }
    public function editServiceForm($id)
    {
        $activeLanguage = \Session::get('language');
        $sub_cats = [];
        if ($id != null) {
            $services = Services::where('id', $id)->first();
            $service_title = ServiceTitle::where('services_id', $id)->where('language_id', $activeLanguage['id'])->first();

            $service_description = ServiceDescription::where('service_id', $id)->where('language_id', $activeLanguage['id'])->first();

            $service_sub_categories = ServiceDetail::where('service_id', $id)->get();

            $service_categories = SubService::where('primary_service_id', $services->primary_service_id)->where('parent_id', 0)->where('status', 1)->get();
            if ($service_sub_categories->count() > 0) {
                foreach ($service_sub_categories as $sub) {

                    if (@$sub->get_category->is_make == 1) {
                        array_push($sub_cats, 'm_' . $sub->category_id . '_' . $sub->sub_category_id);
                    } else {
                        array_push($sub_cats, $sub->sub_category_id);
                    }
                }
                // dd($sub_cats);

            }
        } else {
            $services = null;
            $service_description = null;
        }
        // dd($sub_cats);
        $page_descriptionQuery = Page::query()->select("pd.title", "pd.description");
        $page_descriptionQuery->join('page_desciption AS pd', 'pages.id', '=', 'pd.page_id')->where('pd.language_id', $activeLanguage['id']);
        $page_description = $page_descriptionQuery->where('page_id', 5)->first();

        $categorise = SparePartCategory::where('parent_id', 0)->where('status', 1)->get();
        $customer = Customer::where('id', Auth::guard('customer')->user()->id)->first();
        $timings = CustomerTiming::where('customer_id', Auth::guard('customer')->user()->id)->get();
        $primaryServices = PrimaryService::where('status', 1)->get();

        //$adImages   = AdImage::where('ad_id', $services->id)->get();
        $servicesImages   = $services->services_images;

        $service_type = $services->category($services->primary_service_id, 2)->title . '/' . $services->sub_category($services->sub_service_id, 2)->title . '/' . $services->detials($services->sub_sub_service_id, 2)->title;

        $ads_pricing = AdsPricing::where('type','Offer Service Ad')->where('user_category','Business')->orderBy('number_of_days', 'ASC')->get();


        $customerDetail = Auth::guard('customer')->user();

        $sumCredit = CustomerAccount::where('customer_id', $customerDetail->id)->where('status', 1)->sum('credit');
        $sumDebit  = CustomerAccount::where('customer_id', $customerDetail->id)->sum('debit');
        $credit           = $sumCredit - $sumDebit; // credit


        return view('users.ads.editServiceForm', compact('service_title', 'servicesImages', 'customer', 'timings', 'primaryServices', 'services', 'service_description', 'id', 'sub_cats', 'service_categories', 'page_description', 'service_type','ads_pricing','credit'));
    }

    public function removedEditServiceForm($id)
    {
        $activeLanguage = \Session::get('language');
        $sub_cats = [];
        if ($id != null) {
            $services = Services::where('id', $id)->first();
            $service_title = ServiceTitle::where('services_id', $id)->where('language_id', $activeLanguage['id'])->first();

            $service_description = ServiceDescription::where('service_id', $id)->where('language_id', $activeLanguage['id'])->first();

            $service_sub_categories = ServiceDetail::where('service_id', $id)->get();

            $service_categories = SubService::where('primary_service_id', $services->primary_service_id)->where('parent_id', 0)->where('status', 1)->get();
            if ($service_sub_categories->count() > 0) {
                foreach ($service_sub_categories as $sub) {

                    if (@$sub->get_category->is_make == 1) {
                        array_push($sub_cats, 'm_' . $sub->category_id . '_' . $sub->sub_category_id);
                    } else {
                        array_push($sub_cats, $sub->sub_category_id);
                    }
                }
                // dd($sub_cats);

            }
        } else {
            $services = null;
            $service_description = null;
        }
        // dd($sub_cats);
        $page_descriptionQuery = Page::query()->select("pd.title", "pd.description");
        $page_descriptionQuery->join('page_desciption AS pd', 'pages.id', '=', 'pd.page_id')->where('pd.language_id', $activeLanguage['id']);
        $page_description = $page_descriptionQuery->where('page_id', 5)->first();

        $categorise = SparePartCategory::where('parent_id', 0)->where('status', 1)->get();
        $customer = Customer::where('id', Auth::guard('customer')->user()->id)->first();
        $timings = CustomerTiming::where('customer_id', Auth::guard('customer')->user()->id)->get();
        $primaryServices = PrimaryService::where('status', 1)->get();

        //$adImages   = AdImage::where('ad_id', $services->id)->get();
        $servicesImages   = $services->services_images;

        $service_type = $services->category($services->primary_service_id, 2)->title . '/' . $services->sub_category($services->sub_service_id, 2)->title . '/' . $services->detials($services->sub_sub_service_id, 2)->title;

        $ads_pricing = AdsPricing::where('type','Offer Service Ad')->where('user_category','Business')->orderBy('number_of_days', 'ASC')->get();


        $customerDetail = Auth::guard('customer')->user();

        $sumCredit = CustomerAccount::where('customer_id', $customerDetail->id)->where('status', 1)->sum('credit');
        $sumDebit  = CustomerAccount::where('customer_id', $customerDetail->id)->sum('debit');
        $credit           = $sumCredit - $sumDebit; // credit

        return view('users.ads.editRemovedService', compact('service_title', 'servicesImages', 'customer', 'timings', 'primaryServices', 'services', 'service_description', 'id', 'sub_cats', 'service_categories', 'page_description', 'service_type','ads_pricing','credit'));
    }
    public function updateService(Request $request)
    {

        $base = 0;
        $rules = array();
        if ($request->has('product_image') && ($request->get('product_image') != null || $request->get('product_image') == '')) {
            $base  = $request->get('product_image');
            $files = count($base) - 1;
            if ($files > 0) {
                foreach ($base as $index => $image_path) {
                    if (!empty($image_path)) {
                        $rules['product_image.' . $index] = 'base64max:99999048';
                    }
                }
            }
        }
        $validatedData       = $request->validate($rules);

        $updateAdsCheck = false;
        $column_names = '';
        $old_values = '';
        $new_values = '';
        $image_count = 0;

        $id = $request->service_id;
        $queryAds = Services::where('id', $id)->where('customer_id', '=', Auth::guard('customer')->user()->id);
        $getAds   = $queryAds->first();

        $old_status = $getAds->status;


        $id               = $getAds->id;
        $description      = $request->description;
        $title      = $request->title;
        $activeLanguage   = \Session::get('language');

        $inputs  = $request->except('_token', 'service_id', 'product_image');

        $descript = ServiceDescription::where('service_id', @$id)->where('language_id', $activeLanguage['id'])->first();

        if ($descript->description != $description && $description != '') {
            ServiceDescription::where('service_id', $id)->where('language_id', $activeLanguage['id'])->update(["description" => $description]);
            ServiceDescription::where('service_id', $id)->where('language_id', '!=', $activeLanguage['id'])->delete();
            $updateAdsCheck = true;
            $column_names .= 'Description,';
            $old_values .= $descript->description . ',';
            $new_values .=  ',' . $description . ',';
        }

        $service_title = ServiceTitle::where('services_id', $id)->where('language_id', $activeLanguage['id'])->first();

        if ($service_title->title != $title && $title != '') {
            ServiceTitle::where('services_id', $id)->where('language_id', $activeLanguage['id'])->update(["title" => $title]);
            ServiceTitle::where('services_id', $id)->where('language_id', '!=', $activeLanguage['id'])->delete();
            $updateAdsCheck = true;
            $column_names .= 'Title,';
            $old_values .= $service_title->title . ',';
            $new_values .=  ',' . $title . ',';
        }

        /*$sub_services = explode(',', $request->all_ids);
        $services->service_details()->delete();
        foreach ($sub_services as $service) {
            $service_detail = new ServiceDetail;
            $sub = SubService::where('id', $service)->first();
            if (!empty($service[0]) && $service[0] == 'm') {
                $service_detail->service_id = $id;
                $service_detail->primary_service_id = $request->category;
                $service_detail->category_id = $service[2];
                $service_detail->sub_category_id = $service[4];
                $service_detail->save();
            } else {
                $service_detail->service_id = $id;
                $service_detail->primary_service_id = $request->category;
                $service_detail->category_id = $sub->parent_id;
                $service_detail->sub_category_id = $service;
                $service_detail->save();
            }
        }*/

        /* DESCRIPTION */
        // UPOLOAD MULTIPE IMAGES
        $base = $request->get('product_image');
        if (sizeof(array_filter($base)) > 0) {
            $updateAdsCheck = true;
            $column_names .= 'Picture,';
            $old_values .= $getAds->services_images->count() . ',';
            $image_count = $getAds->services_images->count();
            foreach ($base as $index => $base64) {
                if (!empty($base64)) {
                    $image = $this->upload($base64, $id, 'uploads/ad_pictures/services/');
                    if ($image != '0') {
                        $adImage             = new ServiceImage();
                        $adImage->service_id = $id;
                        $adImage->image_name   = $image;
                        $adImage->save();
                        $image_count++;
                    }
                }
            } // end for loop.
            $new_values .= $image_count . ',';
        } //Endif 

        if ($updateAdsCheck == true) {
            $getAds->status = 0;
            $getAds->save();

            $data = [
                'poster_name' => $getAds->get_customer->customer_company,
                'title'       => @$getAds->get_service_ad_title($getAds->id, $activeLanguage['id'])->title
            ];

            $templatee = EmailTemplate::where('type', 1)->first();
            $template = EmailTemplateDescription::where('email_template_id', $templatee->id)->where('language_id', @$activeLanguage['id'])->first();
            //Mail::to($getAds->get_customer->customer_email_address)->send(new CarAd($data, $template));
        }
        if ($column_names != '' && $old_values != '' && $new_values != '') {
            $history = new PostsHistory;
            $history->user_id = Auth::guard('customer')->user()->id;
            $history->usertype = 'customer';
            $history->username = Auth::guard('customer')->user()->customer_company;
            $history->ad_id = $id;
            $history->column_name = $column_names;
            $history->status = $old_values;
            $history->new_status = $new_values;
            $history->type = 'offerservice';
            $history->save();
        }

        $final_ad = Services::find($id);
        $new_status = $final_ad->status;
        if ($old_status != $new_status) {

            $new_history = new AdsStatusHistory;
            $new_history->user_id = Auth::guard('customer')->user()->id;
            $new_history->usertype = 'customer';
            $new_history->ad_id = $id;
            $new_history->type = 'offerservice';
            $new_history->status = $new_history->ads_status($old_status);
            $new_history->new_status = $new_history->ads_status($new_status);
            $new_history->save();
        }

        return 1;
    }

    public function removedUpdateService(Request $request)
    {
        $base = 0;
        $rules = array();
        if ($request->has('product_image') && ($request->get('product_image') != null || $request->get('product_image') == '')) {
            $base  = $request->get('product_image');
            $files = count($base) - 1;
            if ($files > 0) {
                foreach ($base as $index => $image_path) {
                    if (!empty($image_path)) {
                        $rules['product_image.' . $index] = 'base64max:99999048';
                    }
                }
            }
        }
        $validatedData       = $request->validate($rules);

        $updateAdsCheck = false;
        $column_names = '';
        $old_values = '';
        $new_values = '';
        $image_count = 0;

        $id = $request->service_id;
        $queryAds = Services::where('id', $id)->where('customer_id', '=', Auth::guard('customer')->user()->id);
        $getAds   = $queryAds->first();

        $old_status = $getAds->status;


        $id               = $getAds->id;
        $description      = $request->description;
        $title            = $request->title;
        $activeLanguage   = \Session::get('language');

        $inputs  = $request->except('_token', 'service_id', 'product_image');

        $descript = ServiceDescription::where('service_id', @$id)->where('language_id', $activeLanguage['id'])->first();

        if ($descript->description != $description && $description != '') {
            ServiceDescription::where('service_id', $id)->where('language_id', $activeLanguage['id'])->update(["description" => $description]);
            ServiceDescription::where('service_id', $id)->where('language_id', '!=', $activeLanguage['id'])->delete();
            $updateAdsCheck = true;
            $column_names .= 'Description,';
            $old_values .= $descript->description . ',';
            $new_values .=  ',' . $description . ',';
        }

        $service_title = ServiceTitle::where('services_id', $id)->where('language_id', $activeLanguage['id'])->first();

        if ($service_title->title != $title && $title != '') {
            ServiceTitle::where('services_id', $id)->where('language_id', $activeLanguage['id'])->update(["title" => $title]);
            ServiceTitle::where('services_id', $id)->where('language_id', '!=', $activeLanguage['id'])->delete();
            $updateAdsCheck = true;
            $column_names .= 'Title,';
            $old_values .= $service_title->title . ',';
            $new_values .=  ',' . $title . ',';
        }

        /* DESCRIPTION */
        // UPOLOAD MULTIPE IMAGES
        $base = $request->get('product_image');
        if (sizeof(array_filter($base)) > 0) {
            $updateAdsCheck = true;
            $column_names .= 'Picture,';
            $old_values .= $getAds->services_images->count() . ',';
            $image_count = $getAds->services_images->count();
            foreach ($base as $index => $base64) {
                if (!empty($base64)) {
                    $image = $this->upload($base64, $id, 'uploads/ad_pictures/services/');
                    if ($image != '0') {
                        $adImage             = new ServiceImage();
                        $adImage->service_id = $id;
                        $adImage->image_name   = $image;
                        $adImage->save();
                        $image_count++;
                    }
                }
            } // end for loop.
            $new_values .= $image_count . ',';
        } //Endif 

        if(!is_null($request->number_of_days)){
            $updateAdsCheck = true;
        }

        if ($updateAdsCheck) {
            
            if ($getAds->status == 2) {
                $getAds->status = 5;
            } else {
                $getAds->status = 0;
            }

            $getAds->save();            
        }

        if ($column_names != '' && $old_values != '' && $new_values != '') {
            $history = new PostsHistory;
            $history->user_id = Auth::guard('customer')->user()->id;
            $history->usertype = 'customer';
            $history->username = Auth::guard('customer')->user()->customer_company;
            $history->ad_id = $id;
            $history->column_name = $column_names;
            $history->status = $old_values;
            $history->new_status = $new_values;
            $history->type = 'offerservice';
            $history->save();
        }

        $final_ad = Services::find($id);
        $new_status = $final_ad->status;

            if ($old_status != $new_status) {

            if (!empty($request->number_of_days)) {

                $ServiceAds   = Services::where('customer_id', Auth::guard('customer')->user()->id)->whereIn('status', [0, 1, 3])->get()->count();
                $ids = Services::where('customer_id', Auth::guard('customer')->user()->id)->whereIn('status', [0, 1, 3])->pluck('id')->toArray();
                $account = CustomerAccount::where('customer_id', Auth::guard('customer')->user()->id)->where('type','service_ad')->where('status','!=',2)->whereIn('ad_id',$ids)->count();

                $difference = $ServiceAds - $account;
                
                $GeneralSetting  = GeneralSetting::select('b_service_limit')->first();
                $ad_limit        = $GeneralSetting->b_service_limit !== null ? $GeneralSetting->b_service_limit : 5;
                $customer_type = 'Business';

                if ($difference >= $ad_limit) {   
                    $new_history = new AdsStatusHistory;
                    $new_history->user_id = Auth::guard('customer')->user()->id;
                    $new_history->usertype = 'customer';
                    $new_history->ad_id = $id;
                    $new_history->type = 'offerservice';
                    $new_history->status = $new_history->ads_status($old_status);
                    $new_history->new_status = 'Created';
                    $new_history->save();

                    return $this->payForServices($request,$customer_type,$id);
                } 
            

            
            }
            else{
            $new_status = 0;
            $new_history = new AdsStatusHistory;
            $new_history->user_id = Auth::guard('customer')->user()->id;
            $new_history->usertype = 'customer';
            $new_history->ad_id = $id;
            $new_history->type = 'offerservice';
            $new_history->status = $new_history->ads_status($old_status);
            $new_history->new_status = $new_history->ads_status($new_status);
            $new_history->save();
        }
        }
        if ($request->ajax()) {
                return response()->json(array(
                    'success' => true,
                    'message' => 'Record Successfull Added.'
                ), 200);
            }
        return redirect('user/my-services-ads?status=0')->with('msg', 'Updated Successfully!');
    }


    public function userAds()
    {
        $status = 1;/* 
        if (isset($_GET['status'])) {
            $status = request()->get('status');
        } */
        $ads         = Ad::where('customer_id', Auth::guard('customer')->user()->id)->where('status', $status)->orderBy('updated_at', 'DESC')->get();
        $pending_ads = Ad::where('customer_id', Auth::guard('customer')->user()->id)->whereIn('status', [0, 3, 5])->orderBy('updated_at', 'DESC')->get();
        $removed_ads = Ad::where('customer_id', Auth::guard('customer')->user()->id)->where('status', 2)->orderBy('updated_at', 'DESC')->get();

        if (Auth::guard('customer')->user()->customer_role == 'individual') {
            $ads_pricing = AdsPricing::where('type','Feature Car Ad')->where('user_category','Individual')->orderBy('number_of_days', 'ASC')->get();
        } else {
            $ads_pricing = AdsPricing::where('type','Feature Car Ad')->where('user_category','Business')->orderBy('number_of_days', 'ASC')->get();
        }
        return view('users.ads.userAds', compact('ads', 'pending_ads', 'removed_ads', 'ads_pricing'));
    }
    public function userSpearPartsAds()
    {
        $status = [1];
        $customer_id = Auth::guard('customer')->user()->id;

        if (isset($_GET['status'])) {
            if (request()->get('status') == '0') {
                $status = [0, 3, 5];
            } else {
                $status = [request()->get('status')];
            }
        }
        $PartsAdsCount = SparePartAd::where('customer_id', $customer_id)->whereIn('status', $status)->orderBy('updated_at', 'DESC')->get();
        $PartsAds      = SparePartAd::where('customer_id', $customer_id)->where('status', 1)->orderBy('updated_at', 'DESC')->get();
        $pending_ads   = SparePartAd::where('customer_id', $customer_id)->whereIn('status', [0, 3, 5])->orderBy('updated_at', 'DESC')->get();
        $removed_ads   = SparePartAd::where('customer_id', $customer_id)->where('status', 2)->orderBy('updated_at', 'DESC')->get();

        if (Auth::guard('customer')->user()->customer_role == 'individual') {
            $ads_pricing = AdsPricing::where('type','Feature SparePart Ad')->where('user_category','Individual')->orderBy('number_of_days', 'ASC')->get();
        } else {
            $ads_pricing = AdsPricing::where('type','Feature SparePart Ad')->where('user_category','Business')->orderBy('number_of_days', 'ASC')->get();
        }

        $unPaidAds   = SparePartAd::where('customer_id', $customer_id)->where('status', 5)->count();
        return view('users.ads.userSpearPartsAds', compact('PartsAds', 'pending_ads', 'removed_ads', 'PartsAdsCount', 'unPaidAds', 'ads_pricing'));
    }
    public function userServicesAds()
    {
        $status = [1];
        $customer_id = Auth::guard('customer')->user()->id;

        if (isset($_GET['status'])) {
            if (request()->get('status') == '0') {
                $status = [0, 3, 5];
            } else {
                $status = [request()->get('status')];
            }
        }

        $servicesAdsCount = Services::where('customer_id', $customer_id)->whereIn('status', $status)->orderBy('updated_at', 'DESC')->get();
        $services    = Services::where('customer_id', $customer_id)->where('status', $status)->orderBy('updated_at', 'DESC')->get();
        $pending_ads = Services::where('customer_id', $customer_id)->whereIn('status', [0,3,5])->orderBy('updated_at', 'DESC')->get();
        $removed_ads = Services::where('customer_id', $customer_id)->where('status', 2)->orderBy('updated_at', 'DESC')->get();
        
        $ads_pricing = AdsPricing::where('type','Feature Offer Service Ad')->where('user_category','Business')->orderBy('number_of_days', 'ASC')->get();

        return view('users.ads.userServicesAds', compact('services', 'pending_ads', 'removed_ads','servicesAdsCount','ads_pricing'));
    }

    public function removeAd(Request $request)
    {
        $ad         = Ad::where('id', $request->ad_id)->first();
        $old_status = $ad->status;
        $ad->status = 2;
        $ad->save();

        if(!is_null(@$ad->is_paid_ad->status) && @$ad->is_paid_ad->status != 2)
        {
            $invoice = CustomerAccount::where('ad_id', $ad->id)->orderBy('id','DESC')->first();
            $invoice->status = 2;
            $invoice->save();

        }

        $reason_id = Reason::where('slug', 'removed-by-customer')->pluck('id')->first();
        if (!is_null($reason_id)) {
            $reason_id = $reason_id;
        } else {
            $reason_id = null;
        }
        $ad_message = new AdMsg;
        $ad_message->user_id = Auth::guard('customer')->user()->id;
        $ad_message->ad_id = $ad->id;
        $ad_message->reason_id = $reason_id;
        $ad_message->save();

        $new_status  = $ad->status;
        $new_history = new AdsStatusHistory;
        $new_history->user_id = Auth::guard('customer')->user()->id;
        $new_history->usertype = 'customer';
        $new_history->ad_id = $ad->id;
        $new_history->type = 'car';
        $new_history->status = $new_history->ads_status($old_status);
        $new_history->new_status = $new_history->ads_status($new_status);
        $new_history->save();
        return response()->json(['error' => false]);
    }
    public function resubmitAd(Request $request)
    {
        $ad         = Ad::where('id', $request->ad_id)->first();
        $old_status = $ad->status;
        $ad->status = 0;
        $ad->save();
        $new_status  = $ad->status;
        $new_history = new AdsStatusHistory;
        $new_history->user_id = Auth::guard('customer')->user()->id;
        $new_history->usertype = 'customer';
        $new_history->ad_id = $ad->id;
        $new_history->type = 'car';
        $new_history->status = $new_history->ads_status($old_status);
        $new_history->new_status = $new_history->ads_status($new_status);
        $new_history->save();
        return response()->json(['error' => false]);
    }
    public function deleteAd(Request $request)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $ads_images = AdImage::where('ad_id', $request->ad_id)->get();
        if ($ads_images->isNotEmpty()) {
            $folder_path =  'public/uploads/ad_pictures/cars/' . @$request->ad_id;
            foreach ($ads_images as $ads_image) {
                $image_path =  'public/uploads/ad_pictures/cars/' . @$ads_image->ad_id . '/' . @$ads_image->img;
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
            File::deleteDirectory($folder_path);
        }
        AdImage::where('ad_id', $request->ad_id)->delete();
        AdTag::where('ad_id', $request->ad_id)->delete();
        AdDescription::where('ad_id', $request->ad_id)->delete();
        AdMsg::where('ad_id', $request->ad_id)->delete();
        CustomerAccount::where('ad_id', $request->ad_id)->delete();
        AdsStatusHistory::where('ad_id', $request->ad_id)->delete();
        DB::table('ad_features')->where('ad_id', $request->ad_id)->delete();
        DB::table('ad_suggesstion')->where('ad_id', $request->ad_id)->delete();
        Ad::where('id', $request->ad_id)->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        return response()->json(['error' => false]);
    }

    public function removeSparePart(Request $request)
    {
        $ad = SparePartAd::where('id', $request->ad_id)->first();
        $old_status = $ad->status;
        $ad->status = 2;
        $ad->save();
        $new_status  = $ad->status;


        if(!is_null(@$ad->is_paid_ad->status) && @$ad->is_paid_ad->status != 2)
        {
            $invoice = CustomerAccount::where('ad_id', $ad->id)->orderBy('id','DESC')->first();
            $invoice->status = 2;
            $invoice->save();

        }

        $reason_id = Reason::where('slug', 'removed-by-customer')->pluck('id')->first();
        if (!is_null($reason_id)) {
            $reason_id = $reason_id;
        } else {
            $reason_id = null;
        }
        $ad_message = new SparepartsAdsMessage;
        $ad_message->user_id = Auth::guard('customer')->user()->id;
        $ad_message->spare_parts_ads_id = $ad->id;
        $ad_message->reason_id = $reason_id;
        $ad_message->save();

        $new_history = new AdsStatusHistory;
        $new_history->user_id = Auth::guard('customer')->user()->id;
        $new_history->usertype = 'customer';
        $new_history->ad_id = $ad->id;
        $new_history->type = 'sparepart';
        $new_history->status = $new_history->ads_status($old_status);
        $new_history->new_status = $new_history->ads_status($new_status);
        $new_history->save();
        return response()->json(['error' => false]);
    }
    public function resubmitSparePart(Request $request)
    {
        $ad = SparePartAd::where('id', $request->ad_id)->first();
        $old_status = $ad->status;
        $ad->status = 0;
        $ad->save();
        $new_status  = $ad->status;
        $new_history = new AdsStatusHistory;
        $new_history->user_id = Auth::guard('customer')->user()->id;
        $new_history->usertype = 'customer';
        $new_history->ad_id = $ad->id;
        $new_history->type = 'sparepart';
        $new_history->status = $new_history->ads_status($old_status);
        $new_history->new_status = $new_history->ads_status($new_status);
        $new_history->save();

        $templatee = EmailTemplate::where('type', 1)->first();
        $template  = EmailTemplateDescription::where('email_template_id', $templatee->id)->where('language_id', @$ad->customer->language_id)->first();

        return response()->json(['error' => false]);
    }
    public function deleteSparePart(Request $request)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $ads_images = SparePartAdImage::where('spare_part_ad_id', $request->ad_id)->get();
        if ($ads_images->isNotEmpty()) {
            $folder_path =  'public/uploads/ad_pictures/spare-parts-ad/' . @$request->ad_id;
            foreach ($ads_images as $ads_image) {
                $image_path =  'public/uploads/ad_pictures/spare-parts-ad/' . @$ads_image->spare_part_ad_id . '/' . @$ads_image->img;
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
            File::deleteDirectory($folder_path);
        }
        SparePartAdImage::where('spare_part_ad_id', $request->ad_id)->delete();
        SpAdDescription::where('spare_part_ad_id', $request->ad_id)->delete();
        SparePartAdTitle::where('spare_part_ad_id', $request->ad_id)->delete();
        SparepartsAdsMessage::where('spare_parts_ads_id', $request->ad_id)->delete();
        CustomerAccount::where('ad_id', $request->ad_id)->delete();
        AdsStatusHistory::where('ad_id', $request->ad_id)->delete();
        SparePartAd::where('id', $request->ad_id)->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        return response()->json(['error' => false]);
    }

    public function removeService(Request $request)
    {
        $ad = Services::where('id', $request->ad_id)->first();
        $old_status = $ad->status;
        $ad->status  = 2;
        $new_status  = $ad->status;

        $reason_id = Reason::where('slug', 'removed-by-customer')->pluck('id')->first();
        if (!is_null($reason_id)) {
            $reason_id = $reason_id;
        } else {
            $reason_id = null;
        }
        $ad_message = new ServiceMessage;
        $ad_message->user_id = Auth::guard('customer')->user()->id;
        $ad_message->services_id = $ad->id;
        $ad_message->reason_id = $reason_id;
        $ad_message->save();

        $new_history = new AdsStatusHistory;
        $new_history->user_id = Auth::guard('customer')->user()->id;
        $new_history->usertype = 'customer';
        $new_history->ad_id = $ad->id;
        $new_history->type = 'offerservice';
        $new_history->status = $new_history->ads_status($old_status);
        $new_history->new_status = $new_history->ads_status($new_status);
        $new_history->save();
        $ad->save();
        return response()->json(['error' => false]);
    }
    public function resubmitService(Request $request)
    {
        dd('here');
        /*$ad = SparePartAd::where('id', $request->ad_id)->first();
        $old_status = $ad->status;
        $ad->status = 0;
        $ad->save();
        $new_status  = $ad->status;
        $new_history = new AdsStatusHistory;
        $new_history->user_id = Auth::guard('customer')->user()->id;
        $new_history->usertype = 'customer';
        $new_history->ad_id = $ad->id;
        $new_history->type = 'sparepart';
        $new_history->status = $new_history->ads_status($old_status);
        $new_history->new_status = $new_history->ads_status($new_status);
        $new_history->save();

        $templatee = EmailTemplate::where('type', 1)->first();
        $template  = EmailTemplateDescription::where('email_template_id', $templatee->id)->where('language_id', @$ad->customer->language_id)->first();

        return response()->json(['error' => false]);*/
    }
    public function deleteService(Request $request)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $ads_images = ServiceImage::where('service_id', $request->ad_id)->get();
        if ($ads_images->isNotEmpty()) {
            $folder_path =  'public/uploads/ad_pictures/services/' . @$request->ad_id;
            foreach ($ads_images as $ads_image) {
                $image_path =  'public/uploads/ad_pictures/services/' . @$ads_image->service_id . '/' . @$ads_image->image_name;
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
            File::deleteDirectory($folder_path);
        }
        ServiceImage::where('service_id', $request->ad_id)->delete();
        ServiceDescription::where('service_id', $request->ad_id)->delete();
        ServiceTitle::where('services_id', $request->ad_id)->delete();
        ServiceMessage::where('services_id', $request->ad_id)->delete();
        CustomerAccount::where('ad_id', $request->ad_id)->delete();
        AdsStatusHistory::where('ad_id', $request->ad_id)->delete();
        Services::where('id', $request->ad_id)->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        return response()->json(['error' => false]);
    }


    public function removeSaveAd($id)
    {
        // dd($id);
        $saveAds = UserSavedAds::where('id', $id)->first();
        $saveAds->delete();

        return response()->json(['success' => true]);
    }
    public function removeSavePartAd($id)
    {
        //dd($id);
        $savePartAds = UserSavedSpareParts::where('id', $id)->first();
        $savePartAds->delete();

        return response()->json(['success' => true]);
    }

    public function removeSparePartImage(Request $request)
    {
        // dd($request->all());
        $image = SparePartAdImage::where('id', @$request->id)->first();
        if (@$image != null) {
            $image_path = 'public/uploads/ad_pictures/spare-parts-ad/' . @$image->spare_part_ad_id . '/' . @$image->img;
            if (file_exists($image_path)) {
                File::delete($image_path);
            }
        }
        $image->delete();

        return response()->json(['success' => true]);
    }

    public function filterAds(Request $request)
    {
        $activeLanguage = \Session::get('language');

        if ($request->ads_status == 0) {
            $ads = Ad::where('customer_id', Auth::guard('customer')->user()->id)->whereIn('status', [0, 3, 5])->orderBy('updated_at', 'DESC')->get();
        } else {
            $ads = Ad::where('customer_id', Auth::guard('customer')->user()->id)->where('status', $request->ads_status)->orderBy('updated_at', 'DESC')->get();
        }
        $html_string = '';
        $count = 0;
        if ($ads->count() > 0) {
            foreach ($ads as $ad) {
                $count = $count + 1;
                $feature_status = CustomerAccount::select('status')->where('ad_id', @$ad->id)->where('type', 'car')->where('status', 0)->get();
                $html_string .= '
                  <div class="row p-3 mx-0">
                    <figure class="col-lg-3 col-sm-4 col-4 pl-0 mb-0 ads-listing-img">';
                if (@$ad->ads_images[0]->img != null && file_exists(public_path() . '/uploads/ad_pictures/cars/' . $ad->id . '/' . @$ad->ads_images[0]->img)) {
                    $html_string .= '<img src="' . url('public/uploads/ad_pictures/cars/' . $ad->id . '/' . @$ad->ads_images[0]->img) . '" alt="image" class="img-fluid" style="max-height: 140px;">';
                } else {
                    $html_string .= '<img src="' . url('public/assets/img/caravatar.jpg') . '" alt="Car Image" class="img-fluid" style="max-height: 140px;">';
                }

                $html_string .= '</figure>
                  <div class="col-lg-9 col-sm-8 col-8 pl-md-0 pl-sm-3 pl-0 pr-0 ads-listing-text">
                      <h4><a href="' . url('car-details/' . $ad->id) . '" target="_blank">' . @$ad->maker->title . ' ' . @$ad->model->name . ' ' . @$ad->versions->name . ' ' . @$ad->year . '</a></h4>
                      <p class="ads-views mb-0"><em class="fa fa-eye"></em> ' . @$ad->views . ' ' . __('dashboardMyAds.viewCount') . '</p>';
    
                if ($ad->status == 0) {
                    $html_string .= '<p class="ads-views mb-0" style="color:red;"><strong>' . __('dashboardMyAds.reason') . '</strong> ' . __('dashboardMyAds.waitingForAdminApproval') . '</p>';
                }
                
                if ($ad->status == 2) {
                    $html_string .= '<p class="ads-views mb-0" style="color:red;"><strong>' . __('dashboardMyAds.reason') . '</strong> ' . @$ad->get_lang_wise_removed_reasons($ad->id) . '</p>';
                }
                if ($ad->status == 3) {
                    $html_string .= '<p class="ads-views mb-0" style="color:red;"><strong>' . __('dashboardMyAds.reason') . '</strong> ' . __('dashboardMyAds.notApprovedByAdmin') . '<br>' . $ad->get_reasons($ad->id) . '</p>';
                }
                if ($ad->status == 5) {
                    $html_string .= '<p class="ads-views mb-0" style="color:red;"><strong>' . __('dashboardMyAds.reason') . '</strong> ' . __('dashboardMyAds.waitingForPayment') . '</p>';
                }
                if ($ad->status == 1) {
                    $html_string .= '<p class="ads-views mb-0" style="color:#005e9b;"><strong>' . __('dashboardMyAds.statusActiveActiveUntil') . '</strong> ' . ($ad->active_until != null ? $ad->active_until : 'N.A') . '</p>';
                }
                $html_string .= '</div>
                    <div class="col-12 px-0 mt-3">
                      <div class="row align-items-sm-center">
                    <div class="col-lg-7 col-md-8 col-sm-8 mb-0 editProfile actionbtn ">
                      <ul class="list-unstyled mb-0">';
                if ($ad->status == 1 || $ad->status == 3) {
                    $html_string .= '<li class="list-inline-item"><a href="' . route('post.edit', ['id' => $ad->id]) . '" class="border d-inline-block px-sm-3 px-2 py-1 rounded">' . __('dashboardMyAds.statusActiveEdit') . ' <em class=" ml-1 fa fa-pencil"></em></a></li>';
                }
                if ($request->ads_status != 2) {
                    $html_string .= '<li class="list-inline-item"><a href="" class="border d-inline-block px-sm-3 px-2 py-1 rounded remove-ad" data-id="' . $ad->id . '">' . __('dashboardMyAds.statusRemoved') . ' <em class="ml-1 fa fa-trash"></em></a></li>';
                }
                if ($ad->status == 2 ) {
                    $html_string .= '<li class="list-inline-item"><a href="' . route('post.removedAdedit', ['id' => $ad->id]) . '" class="border d-inline-block px-sm-3 px-2 py-1 rounded">' . __('dashboardMyAds.statusRemovedRelist') . ' <em class=" ml-1 fa fa-pencil"></em></a></li>';
               
                    $html_string .= '<li class="list-inline-item"><a href="javascript:void(0)" class="border px-sm-3 px-2 py-1 rounded delete-ad"  data-id="' . $ad->id . '">' . __('dashboardMyAds.statusActiveRemove') . ' <em class="ml-1 fa fa-refresh"></em></a></li>';
                }
                $html_string .= '</ul>
                    </div>';
                if ($request->ads_status == 1) {
                    $html_string .= '<div class="col-lg-5 col-md-4 col-sm-4 pt-3 pt-sm-0 featuredAd text-sm-right">';
                    if (@$ad->is_featured == 'false' && @$feature_status->count() == 0) {
                        $html_string .= '<a href="javascript:void(0)" data-id="' . @$ad->id . '" class="make_it_featured" data-toggle="modal" data-target="#featureModal"><em class="fa fa-star"></em>
                        ' . __('dashboardMyAds.statusActiveFeatreAd') . '
                        </a>';
                    } elseif (@$ad->is_featured == 'true') {
                        $html_string .= '<a href="javascript:void(0)" style="color: #0072BB;"><em class="fa fa-star"></em>
                      <span> ' . __('dashboardMyAds.statusActiveFeatred') . (@$ad->feature_expiry_date !== null ? Carbon::parse(@$ad->feature_expiry_date)->format('d/m/Y H:i:s') : '--') . '</span></a>';
                    } elseif (@$feature_status[0]->status == 0) {
                        $html_string .= '<a href="javascript:void(0)" style="color: #0072BB;"><em class="fa fa-star"></em>
                      <span>' . __('dashboardMyAds.waitingForPayment') . '</span></a>';
                    }

                    $html_string .= '</div>';
                }
                $html_string .= '
                  </div>
                    </div>
                  </div>';
            }
        } else {
            $html_string = '<h2 class="p-4">' . __('dashboardMyAds.noAdFound') . '</h2>';
        }

        return response()->json(['html' => $html_string]);
    }
    public function filterSpareParts(Request $request)
    {
        $activeLanguage = \Session::get('language');
        $customer_id    = Auth::guard('customer')->user()->id;
        if ($request->ads_status == 0) {
            $ads = SparePartAd::where('customer_id', $customer_id)->whereIn('status', [0, 3, 5])->orderBy('updated_at', 'DESC')->get();
        } else {
            $ads = SparePartAd::where('customer_id', $customer_id)->where('status', $request->ads_status)->orderBy('updated_at', 'DESC')->get();
        }
        $html_string = '';
        if ($ads->count() > 0) {

            foreach ($ads as $ad) {
                $feature_status = CustomerAccount::select('status')->where('ad_id', @$ad->id)->where('type', 'sparepart')->where('status', 0)->where('detail', 'feature sparepart')->get();
                $html_string .= '
                  <div class="row p-3 mx-0">
                    <figure class="col-lg-3 col-sm-4 col-4 pl-0 mb-0 ads-listing-img">';
                if (@$ad->get_one_image->img != null && file_exists(public_path() . '/uploads/ad_pictures/spare-parts-ad/' . $ad->id . '/' . @$ad->get_one_image->img)) {
                    $html_string .= ' <img src="' . url('public/uploads/ad_pictures/spare-parts-ad/' . $ad->id . '/' . @$ad->get_one_image->img) . '" alt="image" class="img-fluid ads_image">';
                } else {
                    $html_string .= ' <img src="' . url('public/assets/img/sparepartavatar.jpg') . '" alt="Car Image" class="img-fluid ads_image">';
                }
                $html_string .= '</figure>
                  <div class="col-lg-9 col-sm-8 col-8 pl-md-0 pl-sm-3 pl-0 pr-0 ads-listing-text">
                      <h4><a href="' . url('spare-parts-details/' . $ad->id) . '" target="_blank">' . $ad->get_sp_ad_title($ad->id, $activeLanguage['id']) . ' </a></h4>
                      <p class="ads-views mb-0"><em class="fa fa-eye"></em> ' . @$ad->views . ' ' . __('dashboardMyAds.viewCount') . '</p>';
                if ($ad->status == 0) {
                    $html_string .= '<p class="ads-views mb-0" style="color:red;"><strong>' . __('dashboardMyAds.reason') . '</strong> ' . __('dashboardMyAds.waitingForAdminApproval') . '</p>';
                }
                if ($ad->status == 3) {
                    $html_string .= '<p class="ads-views mb-0" style="color:red;"><strong>' . __('dashboardMyAds.reason') . '</strong> ' . __('dashboardMyAds.notApprovedByAdmin') . '<br>' . $ad->get_reasons($ad->id) . '</p>';
                }
                if ($ad->status == 5) {
                    $html_string .= '<p class="ads-views mb-0" style="color:red;"><strong>' . __('dashboardMyAds.reason') . '</strong> ' . __('dashboardMyAds.waitingForPayment') . '</p>';
                }
                if ($ad->status == 2) {
                    $html_string .= '<p class="ads-views mb-0" style="color:red;"><strong>' . __('dashboardMyAds.reason') . '</strong> ' . $ad->get_lang_wise_removed_reasons($ad->id) . '</p>';
                }
                if ($ad->status == 1) {
                    $html_string .= '<p class="ads-views mb-0" style="color:#005e9b;"><strong>' . __('dashboardMyAds.statusActiveActiveUntil') . '</strong> ' . ($ad->active_until != null ? $ad->active_until : 'N.A') . '</p>';
                }
                $html_string .= '</div>
                    <div class="col-12 px-0 mt-3">
                      <div class="row align-items-sm-center">
                    <div class="col-lg-7 col-md-8 col-sm-8 mb-0 editProfile actionbtn ">
                      <ul class="list-unstyled mb-0">';
                if ($ad->status == 1 || $ad->status == 3) {
                    $html_string .= '<li class="list-inline-item"><a href="' . url('user/spare-part-ad/' . @$ad->id) . '" class="border d-inline-block px-sm-3 px-2 py-1 rounded">' . __('dashboardMyAds.statusActiveEdit') . ' <em class=" ml-1 fa fa-pencil"></em></a></li>';
                }
                if ($ad->status != 2) {
                    $html_string .= '<li class="list-inline-item"><a href="" class="border d-inline-block px-sm-3 px-2 py-1 rounded remove-ad" data-id="' . $ad->id . '">' . __('dashboardMyAds.statusRemoved') . ' <em class="ml-1 fa fa-trash"></em></a></li>';
                }
                if ($ad->status == 2) {
                    $html_string .= '<li class="list-inline-item"><a href="' . url('user/removed-edit-spare-part-ad/' . @$ad->id) . '" class="border d-inline-block px-sm-3 px-2 py-1 rounded">' . __('dashboardMyAds.statusRemovedRelist') . ' <em class=" ml-1 fa fa-pencil"></em></a></li>';

                    $html_string .= '<li class="list-inline-item"><a href="javascript:void(0)" class="border px-sm-3 px-2 py-1 rounded delete-ad"  data-id="' . $ad->id . '">' . __('dashboardMyAds.statusActiveRemove') . ' <em class="ml-1 fa fa-refresh"></em></a></li>';
                }
                $html_string .= '</ul>
                    </div>';
                if ($request->ads_status == 1) {
                    $html_string .= '<div class="col-lg-5 col-md-4 col-sm-4 pt-3 pt-sm-0 featuredAd text-sm-right">';
                    if (@$ad->is_featured == 'false' && @$feature_status->count() == 0) {
                        $html_string .= '<a href="javascript:void(0)" data-id="' . @$ad->id . '" class="make_it_featured" data-toggle="modal" data-target="#featureModal"><em class="fa fa-star"></em>
                        ' . __('dashboardMyAds.statusActiveFeatreAd') . '
                        </a>';
                    } elseif (@$ad->is_featured == 'true') {
                        $html_string .= '<a href="javascript:void(0)" style="color: #0072BB;"><em class="fa fa-star"></em>
                      <span>' . __('dashboardMyAds.statusActiveFeatred') . ' ' . (@$ad->feature_expiry_date !== null ? Carbon::parse(@$ad->feature_expiry_date)->format('d/m/Y H:i:s') : '--') . '</span></a>';
                    } elseif (@$feature_status[0]->status == 0 && @$feature_status[0]->detail == 'filter-spare-parts') {
                        $html_string .= '<a href="javascript:void(0)" style="color: #0072BB;"><em class="fa fa-star"></em>
                      <span>' . __('dashboardMyAds.waitingForPayment') . '</span></a>';
                    }
                    // <a href="javascript:void(0)" data-id="'.@$ad->id.'" class="make_it_featured" data-toggle="modal" data-target="#featureModal"><em class="fa fa-star"></em> Feature this ad</a>
                    $html_string .= '</div>';
                }
                $html_string .= '</div>
                    </div>
                  </div>';
            }
        } else {
            $html_string = '<h2 class="p-4">' . __('dashboardMyAds.noAdFound') . '</h2>';
        }

        return response()->json(['html' => $html_string]);
    }
    public function filterOfferServices(Request $request)
    {
        $activeLanguage = \Session::get('language');
        if ($request->ads_status == 0) {
            $ads = Services::where('customer_id', Auth::guard('customer')->user()->id)->whereIn('status', [0, 3, 5])->orderBy('updated_at', 'DESC')->get();
        } else {
            $ads = Services::where('customer_id', Auth::guard('customer')->user()->id)->where('status', $request->ads_status)->orderBy('updated_at', 'DESC')->get();
        }
        $html_string = '';
        if ($ads->count() > 0) {
            foreach ($ads as $ad) {
                $feature_status = CustomerAccount::select('status')->where('ad_id', @$ad->id)->where('type', 'offerservice')->where('status', 0)->get();
                $view = $ad->views;
                if ($view == null) {
                    $view = 0;
                }
                $html_string .= '
                  <div class="row p-3 mx-0">
                    <figure class="col-lg-3 col-sm-4 col-4 pl-0 mb-0 ads-listing-img">';
                if (@$ad->services_images[0]->image_name != null && file_exists(public_path() . '/uploads/ad_pictures/services/' . $ad->id . '/' . @$ad->services_images[0]->image_name)) {
                    $html_string .= '<img src="' . url('public/uploads/ad_pictures/services/' . @$ad->id . '/' . @$ad->services_images[0]->image_name) . '" alt="image" class="img-fluid ads_image">';
                } else {

                    $html_string .= '<img src="' . url('public/assets/img/serviceavatar.jpg') . '" alt="Car Image" class="img-fluid ads_image">';
                }
                $html_string .= '
                    </figure>
                  <div class="col-lg-9 col-sm-8 col-8 pl-md-0 pl-sm-3 pl-0 pr-0 ads-listing-text">
                      <h4>';

                $html_string .= '<a href="' . url('service-details/' . @$ad->id) . '" target="_blank">' . @$ad->get_service_ad_title($ad->id, $activeLanguage['id'])->title . '</a>';

                $html_string .= '</h4>
                      <p class="ads-views mb-0"><em class="fa fa-eye"></em> ' . @$ad->views . ' ' . __('dashboardMyAds.viewCount') . '</p>';

                if ($ad->status == 0) {
                    $html_string .= '<p class="ads-views mb-0" style="color:red;"><strong>' . __('dashboardMyAds.reason') . '</strong> ' . __('dashboardMyAds.waitingForAdminApproval') . '</p>';
                }
                if ($ad->status == 3) {
                    $html_string .= '<p class="ads-views mb-0" style="color:red;"><strong>' . __('dashboardMyAds.reason') . '</strong> ' . __('dashboardMyAds.notApprovedByAdmin') . '<br>' . $ad->get_reasons($ad->id) . '</p>';
                }
                if ($ad->status == 5) {
                    $html_string .= '<p class="ads-views mb-0" style="color:red;"><strong>' . __('dashboardMyAds.reason') . '</strong> ' . __('dashboardMyAds.waitingForPayment') . '</p>';
                }
                if ($ad->status == 2) {
                    $html_string .= '<p class="ads-views mb-0" style="color:red;"><strong>' . __('dashboardMyAds.reason') . '</strong> ' . $ad->get_lang_wise_removed_reasons($ad->id) . '</p>';
                }
                if ($ad->status == 3) {
                    $html_string .= '<p class="ads-views mb-0" style="color:red;"><strong>' . __('dashboardMyAds.reason') . '</strong> ' . __('dashboardMyAds.notApprovedByAdmin') . '</p>';
                }
                if ($ad->status == 1) {
                    $html_string .= '<p class="ads-views mb-0" style="color:#005e9b;"><strong>' . __('dashboardMyAds.statusActiveActiveUntil') . '</strong> ' . ($ad->active_until != null ? $ad->active_until : 'N.A') . '</p>';
                }
                $html_string .= '</div>
                    <div class="col-12 px-0 mt-3">
                      <div class="row align-items-sm-center">
                    <div class="col-lg-7 col-md-8 col-sm-8 mb-0 editProfile actionbtn ">
                      <ul class="list-unstyled mb-0">';

                if ($ad->status == 1 || $ad->status == 3) {
                    $html_string .= '<li class="list-inline-item"><a href="' . url('user/edit-service-form/' . @$ad->id) . '" class="border d-inline-block px-sm-3 px-2 py-1 rounded">Edit <em class=" ml-1 fa fa-pencil"></em></a></li>';
                }
                if ($request->ads_status != 2) {
                    $html_string .= '<li class="list-inline-item"><a href="" class="border d-inline-block px-sm-3 px-2 py-1 rounded remove-ad" data-id="' . $ad->id . '">Remove <em class="ml-1 fa fa-trash"></em></a></li>';
                }
                
                if ($request->ads_status == 2) {
                    $html_string .= '<li class="list-inline-item"><a href="' . url('user/removed-edit-service-form/' . @$ad->id) . '" class="border d-inline-block px-sm-3 px-2 py-1 rounded">' . __('dashboardMyAds.statusRemovedRelist') . ' <em class=" ml-1 fa fa-pencil"></em></a></li>';

                    $html_string .= '<li class="list-inline-item"><a href="javascript:void(0)" class="border px-sm-3 px-2 py-1 rounded delete-ad"  data-id="' . $ad->id . '">' . __('dashboardMyAds.statusActiveRemove') . ' <em class="ml-1 fa fa-refresh"></em></a></li>';
                }


                $html_string .= '</ul>
                    </div>';
                if (@$ad->status == 1) {
                    $html_string .= '
                    <div class="col-lg-5 col-md-4 col-sm-4 pt-3 pt-sm-0 featuredAd text-sm-right">';
                    if (@$ad->is_featured == 'false' && @$feature_status->count() == 0) {
                        $html_string .= '<a href="javascript:void(0)" data-id="' . @$ad->id . '" class="make_it_featured" data-toggle="modal" data-target="#featureModal"><em class="fa fa-star"></em> Feature this ad</a>';
                    } else if (@$ad->is_featured == 'true') {
                        $html_string .= '<a href="javascript:void(0)" style="color: #0072BB;"><em class="fa fa-star"></em>
                      <span>Featured Until ' . (@$ad->feature_expiry_date !== null ? Carbon::parse(@$ad->feature_expiry_date)->format('d/m/Y H:i:s') : '--') . '</span></a>';
                    } else if (@$feature_status[0]->status == 0) {
                        $html_string .= '<a href="javascript:void(0)" style="color: #0072BB;"><em class="fa fa-star"></em>
                      <span>' . __('dashboardMyAds.waitingForPayment') . '</span></a>';
                    }

                    // <a href="javascript:void(0)" data-id="'.@$ad->id.'" class="make_it_featured" data-toggle="modal" data-target="#featureModal"><em class="fa fa-star"></em> Feature this ad</a>
                    $html_string .= '</div>';
                }
                $html_string .= '
                  </div>
                    </div>
                  </div>';
            }
        } else {
            $html_string = '<h2 class="p-4">' . __('dashboardMyAds.noAdFound') . '</h2>';
        }

        return response()->json(['html' => $html_string]);
    }
    public function userSavedAds()
    {
        $saveAds   = UserSavedAds::where('customer_id', Auth::guard('customer')->user()->id)->get();
        $saveParts = UserSavedSpareParts::where('customer_id', Auth::guard('customer')->user()->id)->get();

        return view('users.ads.userSavedAds', compact('saveAds', 'saveParts'));
    }
    public function userAlerts()
    {
        $ads = Ad::where('customer_id', Auth::guard('customer')->user()->id)->get();
        $PartsAds = SparePartAd::where('customer_id', Auth::guard('customer')->user()->id)->get();
        $saveAds = UserSavedAds::where('customer_id', Auth::guard('customer')->user()->id)->get();
        $alerts = MyAlert::where('customer_id', Auth::guard('customer')->user()->id)->get();
        // dd($alerts);
        return view('users.ads.userAlerts', compact('ads', 'saveAds', 'PartsAds', 'alerts'));
    }
    public function deleteCarAlert(Request $request)
    {
        // dd($request->all());
        $deleteProduct = MyAlert::where('id', $request->id)->delete();
        return response()->json(['success' => true]);
    }
    public function makeCarAlert(Request $request)
    {
        $alert = new MyAlert;
        $alert->car_make = 'Any';
        $alert->customer_id = @Auth::guard('customer')->user()->id;
        $alert->car_model = @$request->model;
        $alert->city = 'Any';
        $alert->price_from = 'Any';
        $alert->price_to = 'Any';
        $alert->year_from = 'Any';
        $alert->year_to = 'Any';
        $alert->mileage_from = 'Any';
        $alert->mileage_to = 'Any';
        $alert->transmission = 'Any';
        $alert->frequenct = @$request->selectType;
        $alert->save();
        return response()->json(['success' => true]);
    }
    public function messageFilter()
    {
        if (request()->ajax()) {
            $activeLanguage = \Session::get('language');
            $userId         = Auth::guard('customer')->user()->id;

            $term            = request()->get('term');
            DB::enableQueryLog();
            $ads_results     = Chat::query()->groupBy('chats.id');
            $select_array    = array(
                'a.maker_id', 'mo.id as model_id', 'm.title AS make_name', 'mo.name as model_name', "chats.id AS chat_id"
            );
            $ads_results->join('ads AS a', 'a.id', '=', 'chats.ad_id');
            $ads_results->join('makes AS m', 'm.id', '=', 'a.maker_id');
            $ads_results->join('models AS mo', 'mo.id', '=', 'a.model_id');
            $ads_results->whereRaw(DB::raw('(chats.to_id=' . $userId . ' OR chats.from_id=' . $userId . ') AND (m.title LIKE "%' . $term . '%" OR mo.name LIKE "%' . $term . '%")'));
            $ads_results->select($select_array);
            $adsResults = $ads_results->get();
            $result = array();
            if (!$adsResults->isEmpty()) {
                foreach ($adsResults as $businessUser) {
                    $result[$businessUser->chat_id] = ['id' => $businessUser->chat_id, 'value' => $businessUser->make_name . ' ' . $businessUser->model_name];
                }
            }
            $quries     = DB::getQueryLog();
            $spareParts = Chat::query()->distinct('chats.id')->groupBy('chats.id')->select("s.title", "chats.id AS chat_id");
            $spareParts->join('spare_part_ads AS s', 's.id', '=', 'chats.ad_id');
            $spareParts->whereRaw(DB::raw('(chats.to_id=' . $userId . ' OR chats.from_id=' . $userId . ') AND (s.title LIKE "%' . $term . '%")'));
            $spareResults = $spareParts->get();

            if (!$spareResults->isEmpty()) {
                foreach ($spareResults as $businessUser) {
                    $result[$businessUser->chat_id] = ['id' => $businessUser->chat_id, 'value' => $businessUser->title];
                }
            }

            $selectArray    = array(
                "cm.from_id", "cm.chat_id", "cm.to_id", "c.ad_id", "c.type", "cm.message", "cm.read_status", "cm.created_at",
                "customer_firstname", "customer_lastname", "customer_company"
            );
            $msgQuery     = Customer::query()->select($selectArray);
            $msgQuery->join('customer_messages AS cm', 'customers.id', '=', 'cm.from_id');
            $msgQuery->join('chats AS c', 'c.id', '=', 'cm.chat_id');
            $msgQuery->whereRaw(DB::raw('(cm.to_id!=' . $userId . ' OR cm.from_id!=' . $userId . ') AND (customer_firstname LIKE "%' . $term . '%" OR customer_lastname LIKE "%' . $term . '%" OR customer_company LIKE "%' . $term . '%")'));
            $msgResults = $msgQuery->get();
            if (!$msgResults->isEmpty()) {
                foreach ($msgResults as $businessUser) {
                    $result[$businessUser->id] = ['id' => $businessUser->chat_id, 'value' => $businessUser->customer_firstname . ' ' . $businessUser->customer_lastname . ' ' . $businessUser->customer_company];
                }
            }
        } else {
            return response('Forbidden.', 403);
        }
        return response()->json($result);
    }

    public function SearchMessages(Request $request)
    {
        $left_chat_menu = null;
        $term           = $request->title;
        $activeLanguage = \Session::get('language');
        $userId        = Auth::guard('customer')->user()->id;
        DB::enableQueryLog();
        $selectArray    = array(
            "cm.from_id", "cm.chat_id", "cm.to_id", "c.ad_id", "c.type", "cm.message", "cm.read_status", "cm.created_at",
            "customer_firstname", "customer_lastname", "customer_company"
        );
        $msgQuery     = Customer::query()->select($selectArray);
        $msgQuery->join('customer_messages AS cm', 'customers.id', '=', 'cm.from_id');
        $msgQuery->join('chats AS c', 'c.id', '=', 'cm.chat_id');
        $msgQuery->whereRaw(DB::raw('(cm.to_id=' . $userId . ' OR cm.from_id=' . $userId . ') AND (customer_firstname LIKE "%' . $term . '%" OR customer_lastname LIKE "%' . $term . '%" OR customer_company LIKE "%' . $term . '%" OR cm.message LIKE "%' . $term . '%")'));
        $msgResults = $msgQuery->get();
        $quries     = DB::getQueryLog();
        if ($msgQuery->count() > 0) {
            foreach ($msgResults as $msgValues) {
                $ad_title = '';
                if ($msgValues->type == 'car') {
                    $ads = Ad::where('id', $msgValues->ad_id)->where('status', 1)->first();
                    if ($ads != null)
                        $ad_title = $ads->maker->title . ' ' . $ads->model->name . ' ' . $ads->year;
                } elseif ($msgValues->type == 'sparepart') {
                    $ads =  SparePartAdTitle::where('spare_part_ad_id', $msgValues->ad_id)->where('language_id', $activeLanguage['id'])->first();
                    if ($ads == null) {
                        $ads =  SparePartAdTitle::where('spare_part_ad_id', $msgValues->ad_id)->first();
                    }
                    $ad_title = $ads->title;
                } elseif ($msgValues->type == 'offerservice') {
                    $ads = Services::where('id', $msgValues->ad_id)->where('status', 1)->first();
                    if ($ads != null)
                        $ad_title = $ads;
                }

                $left_chat_menu[$msgValues->chat_id] = array(
                    'name'           => @$msgValues->customer_firstname . ' ' . @$msgValues->customer_lastname . ' ' . @$msgValues->customer_company,
                    'user_id'        => @$msgValues->to_id,
                    'latest_message' => @$msgValues->message,
                    'created_at'     => @$msgValues->created_at,
                    'chat_id'        => @$msgValues->chat_id,
                    'read_status'    => @$msgValues->read_status,
                    'sent_by'        => @$msgValues->from_id,
                    'ad_title'      => $ad_title,

                );
            }
        }

        return view('users.ads.searchMessages', compact('left_chat_menu', 'term'));
    }
    public function userMessages()
    {
        $activeLanguage = \Session::get('language');
        $chatQuery = Chat::query()->select(
            'chats.ad_id',
            'chats.to_id AS chats_to_id',
            'chats.from_id AS chats_from_id',
            'cm.to_id AS cm_to_id',
            'cm.from_id AS cm_from_id',
            'chats.type',
            'cm.message',
            'cm.created_at',
            'cm.chat_id',
            'cm.read_status'
        );
        $chatQuery->join('customer_messages AS cm', 'chats.id', '=', 'cm.chat_id');
        $chatQuery->where(function ($query) {
            $query->where('chats.from_id', Auth::guard('customer')->user()->id);
        })->orWhere(function ($query) {
            $query->where('chats.to_id', Auth::guard('customer')->user()->id);
        });
        $chatQuery->orderBy('read_status', 'ASC')->orderBy('cm.created_at', 'DESC');
        $chats          = $chatQuery->get();
        $left_chat_menu = array();
        $chat_detail    = array();

        if ($chats->count() > 0) {
            foreach ($chats as $chat) {
                $ad_title = '';
                if ($chat->type == 'car') {
                    $ads = Ad::where('id', $chat->ad_id)->first();
                    if ($ads != null)
                        $ad_title = $ads->maker->title . ' ' . $ads->model->name . ' ' . $ads->year;
                } elseif ($chat->type == 'sparepart') {
                    $ads =  SparePartAdTitle::where('spare_part_ad_id', $chat->ad_id)->where('language_id', $activeLanguage['id'])->first();
                    if ($ads == null) {
                        $ads =  SparePartAdTitle::where('spare_part_ad_id', $chat->ad_id)->first();
                    }
                    $ad_title = $ads->title;
                } elseif ($chat->type == 'offerservice') {
                    $ads = Services::where('id', $chat->ad_id)->first();
                    if ($ads != null)
                        $ad_title = $ads;
                }
                if ($ads != null) {
                    if ($chat->chats_from_id == Auth::guard('customer')->user()->id) {
                        $from_id = $chat->chats_to_id;
                        $to_id   = $chat->chats_from_id;
                    } else {
                        $from_id = $chat->chats_from_id;
                        $to_id = $chat->chats_to_id;
                    }
                    $user   = Customer::where('id', $from_id)->first();
                    $j      = 0;
                    $isbold = 0;

                    if (empty($left_chat_menu[$chat->chat_id])) {
                        if ($chat->cm_to_id == Auth::guard('customer')->user()->id && $chat->read_status == 0) {
                            $isbold = 1;
                        }
                        $left_chat_menu[$chat->chat_id] = array(
                            'name'           => @$user->customer_company,
                            'user_id'        => @$user->id,
                            'latest_message' => @$chat->message,
                            'created_at'     => @date('Y-m-d h:i:s A', strtotime($chat->created_at)),
                            'chat_id'        => @$chat->chat_id,
                            'ad_title'       => @$ad_title,
                            'isbold'         => @$isbold
                        );
                    }
                }
            }
        }
        return view('users.ads.userMessages', compact('left_chat_menu'));
    }

    public function userMessage()
    {
        $activeLanguage = \Session::get('language');
        $chats          = Chat::where(function ($query) {
            $query->where('from_id', Auth::guard('customer')->user()->id);
        })->orWhere(function ($query) {
            $query->where('to_id', Auth::guard('customer')->user()->id);
        })->orderBy('created_at', 'DESC')->get();

        $i              = 0;
        $left_chat_menu = array();
        $chat_detail    = array();
        if ($chats->count() > 0) {
            foreach ($chats as $chat) {
                $ad_title = '';
                if ($chat->type == 'car') {
                    $ads = Ad::where('id', $chat->ad_id)->first();
                    if ($ads != null)
                        $ad_title = $ads->maker->title . ' ' . $ads->model->name . ' ' . $ads->year;
                } elseif ($chat->type == 'sparepart') {
                    $ads =  SparePartAdTitle::where('spare_part_ad_id', $chat->ad_id)->where('language_id', $activeLanguage['id'])->first();
                    if ($ads == null) {
                        $ads =  SparePartAdTitle::where('spare_part_ad_id', $chat->ad_id)->first();
                    }
                    $ad_title = $ads->title;
                } elseif ($chat->type == 'offerservice') {
                    $ads = Services::where('id', $chat->ad_id)->first();
                    if ($ads != null)
                        $ad_title = $ads;
                }
                if ($ads != null) {
                    if ($chat->from_id == Auth::guard('customer')->user()->id) {
                        $from_id = $chat->to_id;
                        $to_id = $chat->from_id;
                    } else {
                        $from_id = $chat->from_id;
                        $to_id = $chat->to_id;
                    }
                    $user          = Customer::where('id', $from_id)->first();
                    $user_messages = CustomerMessages::where('chat_id', $chat->id)->orderBy('id', 'DESC')->get();

                    $j      = 0;
                    $isbold = 0;
                    foreach ($user_messages as $user_message) {
                        if ($user_message->to_id == Auth::guard('customer')->user()->id && $user_message->read_status == 0) {
                            $isbold = 1;
                        }
                        $chat_detail[$j] = array(
                            'from_id'    => $user_message->from_id,
                            'to_id'      => $user_message->to_id,
                            'message'    => $user_message->message,
                            'created_at' => date('Y-m-d h:i:s A', strtotime($user_message->created_at))
                        );
                        $j++;
                    }

                    if ($user_messages->count() > 0) {
                        $left_chat_menu[$i] = array(
                            'name'           => @$user->customer_company,
                            'user_id'        => @$user->id,
                            'latest_message' => @$user_messages[0]->message,
                            'created_at'     => @date('Y-m-d h:i:s A', strtotime($user_messages[0]->created_at)),
                            'chat_id'        => @$chat->id,
                            'sent_by'        => @$chat->sent_by,
                            'chat_detail'    => @$chat_detail,
                            'ad_title'       => @$ad_title,
                            'isbold'         => @$isbold
                        );
                    }
                    $i++;
                }
            }
        }
        return view('users.ads.userMessages', compact('left_chat_menu', 'chat_detail'));
        //$ads = Ad::where('customer_id',Auth::guard('customer')->user()->id)->get();
        //$PartsAds = SparePartAd::where('customer_id',Auth::guard('customer')->user()->id)->get();
        //$saveAds = UserSavedAds::where('customer_id',Auth::guard('customer')->user()->id)->get();
        //return view('users.ads.userMessagesDetail',compact('ads','saveAds','PartsAds','left_chat_menu' , 'chat_detail'));
    }

    public function userMessagesDetail($id)
    {
        $activeLanguage = \Session::get('language');
        /*$chats=Chat::where(function($query){

                $query->where('from_id',Auth::guard('customer')->user()->id);
            })->orWhere(function($query){
                $query->where('to_id',Auth::guard('customer')->user()->id);
            })->orderBy('updated_at','DESC')->get();*/
        $chats = Chat::where('id', $id)->orderBy('updated_at', 'DESC')->get();
        //dd($chats);
        $i = 0;
        if ($chats->count() > 0) {

            foreach ($chats as $chat) {

                if ($chat->from_id == Auth::guard('customer')->user()->id) {
                    $from_id = $chat->to_id;
                    $to_id = $chat->from_id;
                } else {
                    $from_id = $chat->from_id;
                    $to_id = $chat->to_id;
                }
                $user = Customer::where('id', $from_id)->first();
                $user_messages = CustomerMessages::where('chat_id', $chat->id)->orderBy('id', 'asc')->get();
                $j = 0;
                foreach ($user_messages as $user_message) {
                    $from_user = Customer::where('id', $user_message->from_id)->first();

                    $chat_detail[$j] = array(
                        'from_id' => $user_message->from_id,
                        'to_id' => $user_message->to_id,
                        'from_message' => $from_user->customer_company,
                        'message' => $user_message->message,
                        'created_at' => date('Y-m-d h:i:s A', strtotime($user_message->created_at))

                    );

                    $j++;
                }
                if ($user_messages->count() > 0) {
                    if ($chat->type == 'car') {
                        $ads = Ad::where('id', $chat->ad_id)->first();
                        $ad_title = $ads->maker->title . ' ' . $ads->model->name . ' ' . $ads->year;
                        $ad_url = 'car-details/' . $chat->ad_id;
                        $ads_status = $ads->status;
                    } else if ($chat->type == 'sparepart') {
                        $ad_title = SparePartAdTitle::where('spare_part_ad_id', $chat->ad_id)->where('language_id', $activeLanguage['id'])->pluck('title')->first();
                        $ad_url   = 'spare-parts-details/' . $chat->ad_id;
                        $PartsAds = SparePartAd::select("status")->where('id', $chat->ad_id)->first();
                        $ads_status = $PartsAds->status;
                    } else if ($chat->type == 'offerservice') {
                        $ads        = Services::where('id', $chat->ad_id)->first();
                        $ads_status = $ads->service_status;
                        if ($ads_status == 'Active') {
                            $ads_status = '1';
                        } else {
                            $ads_status = 0;
                        }
                    } else {
                        $ads_status = 0;
                    }
                    $left_chat_menu[$i] = array(
                        'name' => $user->customer_company,
                        'user_id' => $user->id,
                        'latest_message' => $user_messages[0]->message,
                        'created_at' => $user_messages[0]->created_at,
                        'chat_id' => $chat->id,
                        'read_status' => $chat->read_status,
                        'sent_by' => $chat->sent_by,
                        'chat_detail' => $chat_detail,
                        'ad_title' => $ad_title,
                        'ad_url' => $ad_url
                    );
                }
                $i++;
            }
        } else {

            $left_chat_menu = null;
        }
        return view('users.ads.userMessagesDetail', compact('left_chat_menu', 'chat_detail', 'ads_status'));
    }


    public function makeMsgsUnread(Request $request)
    {
        $msg_unread = CustomerMessages::where('chat_id', $request->chat_id)->where('to_id', Auth::guard('customer')->user()->id)->update(['read_status' => 1]);
        return response()->json(['success' => true]);
    }

    public function sendMessageToCustomerFromChatBox(Request $request)
    {

        $existing_chat = Chat::where('id', $request['chat_id'])->first();
        if ($existing_chat) {
            $user_message              = new CustomerMessages;
            $start                     = Carbon::now();
            $current_timestamp         = $start->toDateTimeString();
            $time_zone                 = $request['timezone'];
            $user_message->created_at  = Carbon::parse($current_timestamp)->timezone($time_zone);
            $user_message->updated_at  = Carbon::parse($current_timestamp)->timezone($time_zone);

            $user_message->chat_id     = $existing_chat->id;
            $user_message->from_id     = Auth::guard('customer')->user()->id;
            $user_message->to_id       = $request['user_id'];
            $user_message->message     = $request['messageArea'];
            $user_message->read_status = 0;

            $user_message->save();
            $existing_chat->read_status = 0;
            $existing_chat->save();
        } else {
            $chat                      = new Chat;
            $chat->from_id             = Auth::guard('customer')->user()->id;
            $chat->to_id               = $request['user_id'];
            $chat->read_status         = 0;
            $chat->save();

            $user_message              = new CustomerMessages;
            $user_message->chat_id     = $chat->id;
            $user_message->from_id     = Auth::guard('customer')->user()->id;
            $user_message->to_id       = $request['user_id'];
            $user_message->message     = $request['messageArea'];
            $user_message->read_status = 0;
            $user_message->save();
        }


        return response()->json(['success' => true]);
    }

    public function ChangePassword()
    {
        $ads = Ad::where('customer_id', Auth::guard('customer')->user()->id)->get();
        $PartsAds = SparePartAd::where('customer_id', Auth::guard('customer')->user()->id)->get();
        $saveAds = UserSavedAds::where('customer_id', Auth::guard('customer')->user()->id)->get();
        return view('users.ads.changePassword', compact('ads', 'saveAds', 'PartsAds'));
    }
    public function checkOldPassword(Request $request)
    {
        $hashedPassword = Auth::guard('customer')->user()->customer_password;
        // dd(Hash::check($hashedPassword));
        $old_password =  $request->old_password;
        if (Hash::check($old_password, $hashedPassword)) {
            $error = false;
        } else {
            $error = true;
        }

        return response()->json([
            "error" => $error
        ]);
    }
    public function changePasswordProcess(Request $request)
    {
        $validator = $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_new_password'  => 'required',

        ]);
        $user = Customer::where('id', Auth::guard('customer')->user()->id)->first();
        if ($user) {

            $hashedPassword = Auth::guard('customer')->user()->customer_password;
            $old_password =  $request['old_password'];
            if (Hash::check($old_password, $hashedPassword)) {
                if ($request['new_password'] == $request['confirm_new_password']) {
                    $user->customer_password = bcrypt($request['new_password']);
                }
            }
            $user->save();
        }

        return response()->json(['success' => true]);
    }
    public function myPayment()
    {
        $ads             = Ad::where('customer_id', Auth::guard('customer')->user()->id)->get();
        $PartsAds        = SparePartAd::where('customer_id', Auth::guard('customer')->user()->id)->get();
        $saveAds         = UserSavedAds::where('customer_id', Auth::guard('customer')->user()->id)->get();
        $accounts        = CustomerAccount::where('customer_id', Auth::guard('customer')->user()->id)->get();
        $invoice_setting = InvoiceSetting::where('customer_id', Auth::guard('customer')->user()->id)->first();
        // dd($accounts);
        return view('users.ads.myPayment', compact('ads', 'saveAds', 'PartsAds', 'accounts', 'invoice_setting'));
    }
    public function addUserBalance(Request $request)
    {
        $account = new CustomerAccount;
        $account->customer_id = Auth::guard('customer')->user()->id;
        $account->credit = $request->amount;
        $account->detail = 'Balance Added';
        $account->type = 'balance_added';
        $account->status = 0;
        $account->save();

        return response()->json(['success' => true]);
    }

    public function exportSamplePDF(Request $request)
    {
        // dd($request->all());
        $user = Customer::where('id', Auth::guard('customer')->user()->id)->first();
        $invoice_setting = InvoiceSetting::where('customer_id', Auth::guard('customer')->user()->id)->first();
        // dd($account);
        $pdf = PDF::loadView('users.invoice-sample', compact('user', 'invoice_setting'));

        // making pdf name starts
        $makePdfName = 'invoice';
        return $pdf->stream($makePdfName . '.pdf');
    }
    public function changeProfile()
    {
        $customer_id = Auth::guard('customer')->user()->id;
        $customer = Customer::where('id', $customer_id)->first();
        $countries = Country::where('status', 1)->get();
        $cities = City::where('status', 1)->get();
        return view('users.ads.change-profile', compact('customer', 'countries', 'cities'));
    }
    public function changeBusinessProfile()
    {
        $customer_id = Auth::guard('customer')->user()->id;
        $customer = Customer::where('id', $customer_id)->first();
        $timings = CustomerTiming::where('customer_id', Auth::guard('customer')->user()->id)->get();
        $cities = City::where('status', 1)->get();

        return view('users.ads.change-business-profile', compact('customer', 'timings', 'cities'));
    }
    public function publishAd($id)
    {
        if (Ad::where('customer_id', Auth::user()->id)->where('status', 2)->get()->count() <= 3) {
            $ad = Ad::find($id);
            $ad->status = 2;
            $ad->save();
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }
    public function unPublishAd($id)
    {

        $ad = Ad::find($id);
        $ad->status = 1;
        $ad->save();
        return redirect()->back();
    }
    public function addToSavedAds($id)
    {
        $ad = Ad::find($id);
        if ($ad->status != 1) {
            return response()->json(['notActive' => true]);
        }
        $find = UserSavedAds::where('ad_id', $id)->where('customer_id', Auth::user()->id)->first();
        if ($find != null) {
            $saveAds = UserSavedAds::where('id', $find->id)->first();
            $saveAds->delete();

            return response()->json(['success' => false]);
        } else {
            $saveAd = new UserSavedAds();
            $saveAd->customer_id = Auth::user()->id;
            $saveAd->ad_id = $id;
            $saveAd->save();
            return response()->json(['success' => true]);
        }
    }
    public function addToSavedSpareParts($id)
    {

        $find = UserSavedSpareParts::where('spare_part_ad_id', $id)->where('customer_id', Auth::user()->id)->first();
        if ($find != null) {
            $saveAds = UserSavedSpareParts::where('id', $find->id)->first();
            $saveAds->delete();

            return response()->json(['success' => false]);
        } else {
            $savePart = new UserSavedSpareParts();
            $savePart->customer_id = Auth::user()->id;
            $savePart->spare_part_ad_id = $id;
            $savePart->save();
            return response()->json(['success' => true]);
        }
    }
    public function createSparePartAd()
    {

        $cities                = City::where('status', 1)->get();
        $activeLanguage        = \Session::get('language');
        $categoriesQuery       = SparePartCategory::query()->select("spare_part_categories.id", "cd.title")->where('status', 1)->where('parent_id', 0);
        $categoriesQuery->join('spare_part_categories_description AS cd', 'spare_part_categories.id', '=', 'cd.spare_part_category_id')->where('language_id', $activeLanguage['id']);
        
        
        $categorise            = $categoriesQuery->orderBy('cd.title')->get();
        $policy                = PageDescription::where('title', 'Carish Ad Publishing Policy')->first();
        $page_descriptionQuery = Page::query()->select("pd.title", "pd.description");
        $page_descriptionQuery->join('page_desciption AS pd', 'pages.id', '=', 'pd.page_id')->where('pd.language_id', $activeLanguage['id']);
        $page_description      = $page_descriptionQuery->where('page_id', 4)->first();
        $customer              = Customer::where('id', Auth::guard('customer')->user()->id)->first();

        $sumCredit = CustomerAccount::where('customer_id', Auth::guard('customer')->user()->id)->where('status', 1)->sum('credit');
        $sumDebit  = CustomerAccount::where('customer_id', Auth::guard('customer')->user()->id)->sum('debit');
        $credit           = $sumCredit - $sumDebit;

        $settings              = GeneralSetting::first();
        
        if (Auth::guard('customer')->user()->customer_role == 'individual') {
            $ads_pricing = AdsPricing::where('type','SparePart Ad')->where('user_category','Individual')->orderBy('number_of_days', 'ASC')->get();
        } else {
            $ads_pricing = AdsPricing::where('type','SparePart Ad')->where('user_category','Business')->orderBy('number_of_days', 'ASC')->get();
        }

        $spare_part_limit      = 2;
        $limit                 = $settings->spare_parts_limit;
        $is_pay                   = false;
        if ($limit !== null) {
            $spare_part_limit = $limit;
        }
        if ($customer->customer_role == 'individual') {
            $PartsAds = SparePartAd::where('customer_id', Auth::guard('customer')->user()->id)->whereIn('status', [0, 1, 3])->count();
            if ($PartsAds >= $spare_part_limit) {
                $is_pay = true;
            }
        }

        $makes  =  make::where('status', 1)->orderBy('title', 'ASC')->get();

        $tyre_manufacturers  =  TyreManufacturer::orderBy('title', 'ASC')->get();

        $wheel_manufacturers  =  WheelManufacturer::orderBy('title', 'ASC')->get();

        $brands  =  Brand::orderBy('title', 'ASC')->get();




        return view('users.ads.postsparepartsForm', compact('is_pay', 'cities', 'categorise', 'customer', 'page_description', 'credit', 'ads_pricing','makes','tyre_manufacturers','wheel_manufacturers','brands'));
    }

    public function editSparePartAd($id)
    {
        $cities         = City::where('status', 1)->get();
        $activeLanguage = \Session::get('language');
        $categorise     = SparePartCategory::where('parent_id', 0)->where('status', 1)->orderBy('title')->get();
        $customer       = Customer::where('id', Auth::guard('customer')->user()->id)->first();
        $sparePart      = SparePartAd::where('id', $id)->first();

        $page_descriptionQuery = Page::query()->select("pd.title", "pd.description");
        $page_descriptionQuery->join('page_desciption AS pd', 'pages.id', '=', 'pd.page_id')->where('pd.language_id', $activeLanguage['id']);
        $page_description = $page_descriptionQuery->where('page_id', 4)->first();

        $sparepartImages = SparePartAdImage::where('spare_part_ad_id', $id)->get();
        $images_count    = @$sparepartImages->count();
        $customer        = Customer::where('id', Auth::guard('customer')->user()->id)->first();
        $adImages        = AdImage::where('ad_id', $id)->get();

        $makes  =  make::where('status', 1)->orderBy('title', 'ASC')->get();

        $tyre_manufacturers  =  TyreManufacturer::orderBy('title', 'ASC')->get();

        $wheel_manufacturers  =  WheelManufacturer::orderBy('title', 'ASC')->get();

        $brands  =  Brand::orderBy('title', 'ASC')->get();
        $f3_types =[];
        if($sparePart->f3_type !='')
        {
            $f3_types = explode(',',$sparePart->f3_type);

        }

        return view('users.ads.editsparepartsForm', compact('sparePart', 'cities', 'categorise', 'customer', 'sparepartImages', 'id', 'images_count', 'page_description', 'customer','makes','tyre_manufacturers','wheel_manufacturers','brands','f3_types'));
    }
    public function removedEditSparePartAd($id)
    {
        $cities         = City::where('status', 1)->get();
        $activeLanguage = \Session::get('language');
        $categorise     = SparePartCategory::where('parent_id', 0)->where('status', 1)->orderBy('title')->get();
        $customer       = Customer::where('id', Auth::guard('customer')->user()->id)->first();
        $sparePart      = SparePartAd::where('id', $id)->first();

        $customerDetail = Auth::guard('customer')->user();

        $sumCredit = CustomerAccount::where('customer_id', $customerDetail->id)->where('status', 1)->sum('credit');
        $sumDebit  = CustomerAccount::where('customer_id', $customerDetail->id)->sum('debit');
        $credit           = $sumCredit - $sumDebit; // credit

        $page_descriptionQuery = Page::query()->select("pd.title", "pd.description");
        $page_descriptionQuery->join('page_desciption AS pd', 'pages.id', '=', 'pd.page_id')->where('pd.language_id', $activeLanguage['id']);
        $page_description = $page_descriptionQuery->where('page_id', 4)->first();

        $sparepartImages = SparePartAdImage::where('spare_part_ad_id', $id)->get();
        $images_count    = @$sparepartImages->count();
        $customer        = Customer::where('id', Auth::guard('customer')->user()->id)->first();
        $adImages        = AdImage::where('ad_id', $id)->get();
        
        if (Auth::guard('customer')->user()->customer_role == 'individual') {
            $ads_pricing = AdsPricing::where('type','SparePart Ad')->where('user_category','Individual')->orderBy('number_of_days', 'ASC')->get();
        } else {
            $ads_pricing = AdsPricing::where('type','SparePart Ad')->where('user_category','Business')->orderBy('number_of_days', 'ASC')->get();
        }

        return view('users.ads.postRemovedSpAdsEdit', compact('sparePart', 'cities', 'categorise', 'customer', 'sparepartImages', 'id', 'images_count', 'page_description', 'customer','customerDetail','ads_pricing','credit'));
    }
    public function payForExtraSparePart(Request $request)
    {
        $credit             = 0;
        $request_amount     = 0;
        $sumCredit = CustomerAccount::where('customer_id', Auth::guard('customer')->user()->id)->where('status', 1)->sum('credit');
        $sumDebit  = CustomerAccount::where('customer_id', Auth::guard('customer')->user()->id)->sum('debit');
        $credit           = $sumCredit - $sumDebit;

        $request_amount = AdsPricing::where('type','SparePart Ad')->where('number_of_days',$request->number_of_days)->orderBy('id','DESC')->pluck('pricing')->first();

        if ($request->use_balance == 'on') {
            $start                = Carbon::now();
            $result               = array('success' => true, 'payment_status' => 'full');
            $start->addDays($request->featured_days);
            $featured_until       = $start->endOfDay()->toDateTimeString();
            $account              = new CustomerAccount;
            $account->customer_id = Auth::guard('customer')->user()->id;
            $account->debit          = $request_amount;

            if ($request_amount > $credit) {
                $remaining_balance        = $request_amount - $credit;
                //$account->credit        = $remaining_balance;
                $account->debit           = $credit;
                $request_amount           = $remaining_balance;
                $is_featured              = false;
                $result['payment_status'] = 'partial';
            }
            $account->detail         = 'Post An Accessory';
            $account->number_of_days = $request->featured_days;
            $account->paid_amount    = @$request_amount;
            $account->status         = 0;
            $account->type           = 'sparepart_ad';
            $account->save();
            $new_history             = new AdsStatusHistory;
            $new_history->user_id    = Auth::guard('customer')->user()->id;
            $new_history->usertype   = 'customer';
            $new_history->type       = 'sparepart';
            $new_history->status     = 'Unpaid';
            $new_history->new_status = 'Pending';
            $new_history->save();
            $result['invoice_id']    = $account->id;
            return response()->json($result);
        } else {

            $new_request                  = new CustomerAccount;
            $new_request->customer_id     = Auth::guard('customer')->user()->id;
            $new_request->number_of_days  = $request->featured_days;
            $new_request->paid_amount     = @$request_amount;
            $new_request->status              = 0;
            $new_request->type            = 'sparepart_ad';
            $new_request->detail          = 'Post An Accessory';
            $new_request->save();
            return response()->json(['request' => true, 'invoice_id2' => $new_request->id]);
        }
    }
    public function saveSparePartAd(Request $request)  // spare part add code inspection
    {
        $rules = array();
        if ($request->has('product_image') && ($request->get('product_image') != null || $request->get('product_image') == '')) {
            $base  = $request->get('product_image');
            $files = count($base) - 1;
            if ($files > 0) {
                foreach ($base as $index => $image_path) {
                    if (!empty($image_path)) {
                        $rules['product_image.' . $index] = 'base64max:99999048';
                    }
                }
            }
        }
        $validatedData = $request->validate($rules);

        $ad               = new SparePartAd();
        $ad->customer_id  = Auth::guard('customer')->user()->id;
        $ad->title        = $request->title;
        $ad->product_code = $request->product_code !== null ? $request->product_code : '';
        $ad->city_id      = 1;
        $ad->parent_id    = $request->category;

        $ad->category_id = $request->sub_category;
        $ad->condition   = $request->condition;
        $ad->price       = $request->price;
        $ad->vat         = isset($request->vat) ? 1 : 0;
        $ad->neg         = isset($request->neg) ? 1 : 0;

        $ad->make_id =   $request->make_id;
        $ad->model_id  =  $request->model_id;    
        
        $ad->f2_liter =  $request->f2_liter;    
        $ad->f2_kw =  $request->f2_kw;    

        $ad->brand  =  $request->brand; 
        $ad->num_of_channel  = $request->num_of_channel; 
        $ad->size  =     $request->size; 
        $ad->screen_size =    $request->screen_size; 
        $ad->size_inch =     $request->size_inch; 
        
        $ad->f3_tyre_manufacturer =      $request->f3_tyre_manufacturer; 
        $ad->f3_size =   $request->f3_size; 

        $tyre_types = '';

        $f3_types  = $request->get('f3_type');
        if($f3_types){

            foreach($f3_types as $type)
            {
                $tyre_types .= $type.','; 
            }

            $ad->f3_type = rtrim($tyre_types, ',');
        }
        
        $ad->f3_quantity =   $request->f3_quantity; 
        
        $ad->f4_wheel_manufacturer =      $request->f4_wheel_manufacturer; 
        $ad->f4_size_inch =$request->f4_size_inch; 
        $ad->f4_offset_mm =$request->f4_offset_mm; 
        $ad->f4_style =$request->f4_style; 
        $ad->f4_num_of_holes =$request->f4_num_of_holes; 
        $ad->f4_distance_between_holes =$request->f4_distance_between_holes; 
        $ad->f4_quantity =$request->f4_quantity; 

        $ad->poster_name  = Auth::guard('customer')->user()->customer_company;
        $ad->poster_email = $request->poster_email;
        $ad->poster_phone = $request->poster_phone;
        if (@$request->poster_city != null) {
            $ad->poster_city = $request->poster_city;
        } else {
            $ad->poster_city = '1';
        }
        $ad->save();
        $ad->description = $request->description;
        if (@$request->description != null) {
            $spare_des      = new SparepartsAdsDescription;
            $activeLanguage = \Session::get('language');
            $spare_des->language_id = $activeLanguage['id'];
            $spare_des->spare_part_ad_id = $ad->id;
            $spare_des->description = $request->description;
            $spare_des->save();
        }
        if (@$request->title != null) {
            $spare_title = new SparePartAdTitle;
            $activeLanguage = \Session::get('language');
            $spare_title->language_id = $activeLanguage['id'];
            $spare_title->spare_part_ad_id = $ad->id;
            $spare_title->title = $request->title;
            $spare_title->save();
        }
        // UPOLOAD MULTIPE IMAGES
        if (sizeof($base) > 0) {
            foreach ($base as $index => $base64) {
                if (!empty($base64)) {
                    $image = $this->upload($base64, $ad->id);
                    if ($image != '0') {
                        $adImage                   = new SparePartAdImage();
                        $adImage->spare_part_ad_id = $ad->id;
                        $adImage->img              = $image;
                        $adImage->save();
                    }
                } // endif
                else {
                    // return json_encode(['success' => true]);
                }
            } // end for loop.

        } //Endif 

        $SpAds    = SparePartAd::where('customer_id', Auth::guard('customer')->user()->id)->whereIn('status', [0, 1, 3])->get()->count();
        $ids = SparePartAd::where('customer_id', Auth::guard('customer')->user()->id)->whereIn('status', [0, 1, 3])->pluck('id')->toArray();
        $account = CustomerAccount::where('customer_id', Auth::guard('customer')->user()->id)->where('type','sparepart_ad')->where('status','!=',2)->whereIn('ad_id',$ids)->count();
        $difference = $SpAds - $account;

        if (Auth::guard('customer')->user()->customer_role == 'individual' && !empty($request->number_of_days)) {
            $GeneralSetting  = GeneralSetting::select('spare_parts_limit')->first();
            $ad_limit        = $GeneralSetting->spare_parts_limit !== null ? $GeneralSetting->spare_parts_limit : 5;
            $customer_type   = 'Individual';
            }
        else{
            $GeneralSetting  = GeneralSetting::select('b_spare_parts_limit')->first();
            $ad_limit           = $GeneralSetting->b_spare_parts_limit !== null ? $GeneralSetting->b_spare_parts_limit : 5;
            $customer_type = 'Business';
        }

        if ($difference > $ad_limit) {
            return $this->payForSparePart($request,$customer_type,$ad->id);
        } 
        else {
            $new_history             = new AdsStatusHistory;
            $new_history->user_id    = Auth::guard('customer')->user()->id;
            $new_history->usertype   = 'customer';
            $new_history->ad_id      = $ad->id;
            $new_history->type       = 'sparepart';
            $new_history->status     = 'Created';
            $new_history->new_status = 'Pending';
            $new_history->save();
        }

        $data = [
                'poster_name' => $ad->get_customer->customer_company,
                'title'       => @$spare_title->title
            ];
        $templatee = EmailTemplate::where('type', 1)->first();
        $template  = EmailTemplateDescription::where('email_template_id', $templatee->id)->where('language_id', @$ad->customer->language_id)->first();
        Mail::to($request->poster_email)->send(new CarAd($data, $template));
        if ($request->ajax()) {
            return response()->json(array(
                'success' => true,
                'message' => 'Record Successfull Added.'
            ), 200);
        }
    }

    private function payForSparePart($request,$customer_type,$sp_id)
    {
        $activeLanguage = \Session::get('language');
        $credit             = 0;
        $paid_amount        = 0;
        $customer_id        = Auth::guard('customer')->user()->id;
        $sumCredit = CustomerAccount::where('customer_id', Auth::guard('customer')->user()->id)->where('status', 1)->sum('credit');
        $sumDebit  = CustomerAccount::where('customer_id', Auth::guard('customer')->user()->id)->sum('debit');
        $credit           = $sumCredit - $sumDebit;

        if ($customer_type == 'Individual') {
            $paid_amount = AdsPricing::where('type','SparePart Ad')->where('user_category','Individual')->where('number_of_days',$request->number_of_days)->orderBy('id','DESC')->pluck('pricing')->first();
        } else if($customer_type == 'Business') {
            $paid_amount = AdsPricing::where('type','SparePart Ad')->where('user_category','Business')->where('number_of_days',$request->number_of_days)->orderBy('id','DESC')->pluck('pricing')->first();
        }

        $account = new CustomerAccount;
        $ad      = SparePartAd::find($sp_id);

        if ($request->use_balance == 'on') {
            $start               = Carbon::now();
            $partial             = false;
            $result              = array('success' => true, 'payment_status' => 'full');
            $start->addDays($request->number_of_days);
            $featured_until = $start->endOfDay()->toDateTimeString();

            $account->customer_id = $customer_id;
            $account->ad_id       = $sp_id;
            $account->debit       = $paid_amount;

            if ($paid_amount > $credit) {
                $remaining_balance        = $paid_amount - $credit;
                $account->debit           = $credit;
                $paid_amount              = $remaining_balance;
                $partial                  = true;
                $result['payment_status'] = 'partial';
            }
            $account->detail         = 'Post An Accessory';
            $account->number_of_days = $request->number_of_days;
            $account->paid_amount    = @$paid_amount;
            $account->status         = 1;
            $account->type           = 'sparepart_ad';
            $account->save();

            if ($partial == false) {
                $ad->status              = 0;
                $ad->save();

                $new_history             = new AdsStatusHistory;
                $new_history->user_id    = Auth::guard('customer')->user()->id;
                $new_history->usertype   = 'customer';
                $new_history->ad_id      = $sp_id;
                $new_history->type       = 'sparepart';
                $new_history->status     = 'Created';
                $new_history->new_status = 'Pending';
                $new_history->save();
            }else{

                $ad->status              = 5;
                $ad->save();

                $new_history             = new AdsStatusHistory;
                $new_history->user_id    = Auth::guard('customer')->user()->id;
                $new_history->usertype   = 'customer';
                $new_history->ad_id      = $sp_id;
                $new_history->type       = 'sparepart';
                $new_history->status     = 'Created';
                $new_history->new_status = 'UnPaid';
                $new_history->save();
            }

            $result['invoice_id']    = $account->id;

        } 
        else {
            $ad->status = 5;
            $ad->save();

            $new_request                  = $account;
            $new_request->ad_id           = $sp_id;
            $new_request->customer_id     = Auth::guard('customer')->user()->id;
            $new_request->number_of_days  = $request->number_of_days;
            $new_request->paid_amount     = @$paid_amount;
            $new_request->status          = 0;
            $new_request->type            = 'sparepart_ad';
            $new_request->detail          = 'Post An Accessory';
            $new_request->save();

            $new_history             = new AdsStatusHistory;
            $new_history->user_id    = Auth::guard('customer')->user()->id;
            $new_history->usertype   = 'customer';
            $new_history->ad_id      = $sp_id;
            $new_history->type       = 'sparepart';
            $new_history->status     = 'Created';
            $new_history->new_status = 'UnPaid';
            $new_history->save();

             $result['invoice_id']    = $new_request->id;

        }
        
        $spare_title = SparePartAdTitle::where('spare_part_ad_id',$sp_id)->where('language_id',$activeLanguage['id'])->pluck('title')->first();
         $data = [
                'poster_name' => $request->poster_name,
                'title'       => @$spare_title
            ];
        $templatee = EmailTemplate::where('type', 1)->first();
        $template  = EmailTemplateDescription::where('email_template_id', $templatee->id)->where('language_id', $activeLanguage['id'])->first();
        Mail::to($request->poster_email)->send(new CarAd($data, $template));


        if ($account->credit != '' || $account->paid_amount) {
                $invoice_attachment = '<a href="' . route('pay-invoice-pdf', ['id' => @$account->id]) . '" target="_blank" style="text-decoration:none;">C' . @$account->id . '</a>';
            } 
            

            $pay_data = [
                'poster_name' => @$request->poster_name,
                'title'       => @$spare_title,
                'invoice_pdf' =>  @$invoice_attachment
            ];

            //added by usman
            $pay_templatee = EmailTemplate::where('type', 14)->first(); // email for ad payment
            $pay_template  = EmailTemplateDescription::where('email_template_id', $pay_templatee->id)->where('language_id', $activeLanguage['id'])->first();
            Mail::to($request->poster_email)->send(new PayForAd($pay_data, $pay_template));

            return response()->json($result);
    }
    public function postExtraSparePart(Request $request)
    {
        $credit             = 0;
        $request_amount     = 0;
        $sumCredit = CustomerAccount::where('customer_id', Auth::guard('customer')->user()->id)->where('status', 1)->sum('credit');
        $sumDebit  = CustomerAccount::where('customer_id', Auth::guard('customer')->user()->id)->sum('debit');
        $credit           = $sumCredit - $sumDebit;

        $request_amount = AdsPricing::where('type','SparePart Ad')->where('number_of_days',$request->featured_days)->orderBy('id','DESC')->pluck('pricing')->first();

        if ($request->use_balance == 'on') {
            $ad    = SparePartAd::find(@$request->ad_id);
            $start = Carbon::now();

            $result              = array('success' => true, 'payment_status' => 'full');
            $start->addDays($request->featured_days);
            $featured_until = $start->endOfDay()->toDateTimeString();

            $account              = new CustomerAccount;
            $account->customer_id = Auth::guard('customer')->user()->id;
            $account->ad_id       = @$request->ad_id;

            $account->debit          = $request_amount;

            if ($request_amount > $credit) {
                $remaining_balance        = $request_amount - $credit;
                $account->debit           = $credit;
                $request_amount           = $remaining_balance;
                $is_featured              = false;
                $result['payment_status'] = 'partial';
            }
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
            $new_history->usertype   = 'customer';
            $new_history->ad_id      = $ad->id;
            $new_history->type       = 'sparepart';
            $new_history->status     = 'Unpaid';
            $new_history->new_status = 'Pending';
            $new_history->save();
            $result['invoice_id']    = $account->id;
            return response()->json($result);
        } else {
            $ad                          = SparePartAd::find(@$request->ad_id);

            $new_request                  = new CustomerAccount;

            $new_request->ad_id          = @$request->ad_id;
            $new_request->customer_id     = Auth::guard('customer')->user()->id;
            $new_request->number_of_days  = $request->featured_days;
            $new_request->paid_amount = @$request_amount;
            $new_request->status              = 0;
            $new_request->type            = 'sparepart_ad';
            $new_request->detail          = 'Post An Accessory';
            $new_request->save();
            return response()->json(['request' => true, 'invoice_id2' => $new_request->id]);
        }
    }
    private function upload($base64_string, $prodId, $path = null)
    {
        $data          = explode(';', $base64_string);
        $dataa         = explode(',', $base64_string);
        $part          = explode("/", $data[0]);
        if (empty($path) || $path == null) {
            $path = 'uploads/ad_pictures/spare-parts-ad/';
        }
        $directory     = public_path($path . $prodId . '/');

        if (empty($part) or @$part[1] == null or empty(@$part[1])) {
            return false;
        } else {
            $file = md5(uniqid(rand(), true)) . ".{$part[1]}";
            if (!is_dir($directory)) {
                mkdir($directory, 0777, true);
            }

            $data = getimagesizefromstring(base64_decode($dataa[1]));
            $width = $data[0];
            $height = $data[1];
            
            if($width > $height)
            {
                $new_width  = 1000;
                $new_height = ($height/$width*$new_width);
            }
            else if($width < $height)
            {
                $new_height = 750;
                $new_width  = ($width/$height*$new_height);
            }
            else if($width == $height){
                $new_width  = 750;
                $new_height = 750;
            }
            else{
                $new_width  = 750;
                $new_height = 750;
            }
   

            $pathToImage = $directory.$file;
            $img = Image::make(base64_decode($dataa[1]));
            $img->resize($new_width, $new_height);
            $img->save($pathToImage);

            //$ifp = fopen($directory . "/{$file}", 'wb');
            //fwrite($ifp, base64_decode($dataa[1]));
            //fclose($ifp);
            
            /*$pathToOutput = $directory.'new.jpg';
            $optimizerChain = OptimizerChainFactory::create();
            $optimizerChain->optimize($pathToImage);
            $optimizerChain->optimize($pathToImage, $pathToOutput);*/

            return $file;
        }
    }
    public function editSparePartAd1($id)
    {
        $cities         = City::where('status', 1)->get();
        $activeLanguage = \Session::get('language');
        $categorise     = SparePartCategory::where('parent_id', 0)->where('status', 1)->orderBy('title')->get();
        $customer       = Customer::where('id', Auth::guard('customer')->user()->id)->first();
        $sparePart      = SparePartAd::where('id', $id)->first();

        $page_descriptionQuery = Page::query()->select("pd.title", "pd.description");
        $page_descriptionQuery->join('page_desciption AS pd', 'pages.id', '=', 'pd.page_id')->where('pd.language_id', $activeLanguage['id']);
        $page_description = $page_descriptionQuery->where('page_id', 4)->first();

        $sparepartImages = SparePartAdImage::where('spare_part_ad_id', $id)->get();
        $images_count    = @$sparepartImages->count();
        $customer        = Customer::where('id', Auth::guard('customer')->user()->id)->first();
        $adImages        = AdImage::where('ad_id', $id)->get();
        
        return view('users.ads.editsparepartsForm', compact('sparePart', 'cities', 'categorise', 'customer', 'sparepartImages', 'id', 'images_count', 'page_description', 'customer'));
    }

    public function updateSparePartAd($id, Request $request)
    {
        $rules = [];
        if ($request->has('product_image') && ($request->get('product_image') != null || $request->get('product_image') == '')) {
            $base  = $request->get('product_image');
            $files = count($base) - 1;
            if ($files > 0) {
                foreach ($base as $index => $image_path) {
                    if (!empty($image_path)) {
                        $rules['product_image.' . $index] = 'base64max:99999048';
                    }
                }
            }
        }
        $validatedData = $request->validate($rules);

        $updateAdsCheck = false;
        $column_names = '';
        $old_values = '';
        $new_values = '';
        $image_count = 0;

        $id = $request->sparepart_id;

        $queryAds = SparePartAd::where('id', $id)->where('customer_id', '=', Auth::guard('customer')->user()->id);
        $getAds   = $queryAds->first();
        $getAds->product_code = $request->product_code;
        $getAds->condition = $request->condition;
        $getAds->price = $request->price;
        $getAds->vat = isset($request->vat) ? 1 : 0;
        $getAds->neg = isset($request->neg) ? 1 : 0;
        
        $getAds->make_id =   $request->make_id;
        $getAds->model_id  =  $request->model_id;    
         
        $getAds->f2_liter =  $request->f2_liter;    
        $getAds->f2_kw =  $request->f2_kw;    

        $getAds->brand  =  $request->brand; 
        $getAds->num_of_channel  = $request->num_of_channel; 
        $getAds->size  =     $request->size; 
        $getAds->screen_size =    $request->screen_size; 
        $getAds->size_inch =     $request->size_inch; 
        
        $getAds->f3_tyre_manufacturer =      $request->f3_tyre_manufacturer; 
        $getAds->f3_size =   $request->f3_size; 


        $tyre_types = '';
        $f3_types  = $request->get('f3_type');
        if($f3_types){

            foreach($f3_types as $type)
            {
                $tyre_types .= $type.','; 
            }

            $getAds->f3_type = rtrim($tyre_types, ',');
        }else{
            $getAds->f3_type = '';
        }

        $getAds->f3_quantity =   $request->f3_quantity; 
        
        $getAds->f4_wheel_manufacturer =      $request->f4_wheel_manufacturer; 
        $getAds->f4_size_inch =$request->f4_size_inch; 
        $getAds->f4_offset_mm =$request->f4_offset_mm; 
        $getAds->f4_style =$request->f4_style; 
        $getAds->f4_num_of_holes =$request->f4_num_of_holes; 
        $getAds->f4_distance_between_holes =$request->f4_distance_between_holes; 
        $getAds->f4_quantity =$request->f4_quantity; 

        $getAds->save();

        $old_status = $getAds->status;

        $id               = $getAds->id;
        $description      = $request->description;
        $title            = $request->title;
        $activeLanguage   = \Session::get('language');

        $inputs  = $request->except('_token', 'sparepart_id', 'product_image');

        $descript = SpAdDescription::where('spare_part_ad_id', @$id)->where('language_id', $activeLanguage['id'])->first();

        if ($descript->description != $description && $description != '') {
            SpAdDescription::where('spare_part_ad_id', $id)->where('language_id', $activeLanguage['id'])->update(["description" => $description]);
            SpAdDescription::where('spare_part_ad_id', $id)->where('language_id', '!=', $activeLanguage['id'])->delete();
            $updateAdsCheck = true;
            $column_names .= 'Description,';
            $old_values .= $descript->description . ',';
            $new_values .=  ',' . $description . ',';
        }

        $sp_title = SparePartAdTitle::where('spare_part_ad_id', $id)->where('language_id', $activeLanguage['id'])->first();

        if ($sp_title->title != $title && $title != '') {
            SparePartAdTitle::where('spare_part_ad_id', $id)->where('language_id', $activeLanguage['id'])->update(["title" => $title]);
            SparePartAdTitle::where('spare_part_ad_id', $id)->where('language_id', '!=', $activeLanguage['id'])->delete();
            $updateAdsCheck = true;
            $column_names .= 'Title,';
            $old_values .= $sp_title->title . ',';
            $new_values .=  ',' . $title . ',';
        }

        $base = $request->get('product_image');
        if (sizeof(array_filter($base)) > 0) {
            $updateAdsCheck = true;
            $column_names .= 'Picture,';
            $old_values .= $getAds->spare_parts_images->count() . ',';
            $image_count = $getAds->spare_parts_images->count();
            foreach ($base as $index => $base64) {
                if (!empty($base64)) {
                    $image = $this->upload($base64, $id, 'uploads/ad_pictures/spare-parts-ad/');
                    if ($image != '0') {
                        $adImage             = new SparePartAdImage();
                        $adImage->spare_part_ad_id = $id;
                        $adImage->img   = $image;
                        $adImage->save();
                        $image_count++;
                    }
                }
            } // end for loop.
            $new_values .= $image_count . ',';
        } //Endif

        if ($updateAdsCheck == true || !is_null($request->freeAd)) {
            $getAds->status = 0;
            $getAds->save();

            $data = [
                'poster_name' => $getAds->get_customer->customer_company,
                'title'       => @$getAds->get_sp_ad_title($getAds->id, $activeLanguage['id'])
            ];

            $templatee = EmailTemplate::where('type', 1)->first();
            $template = EmailTemplateDescription::where('email_template_id', $templatee->id)->where('language_id', @$activeLanguage['id'])->first();
            Mail::to($getAds->get_customer->customer_email_address)->send(new CarAd($data, $template));
        }

        if ($column_names != '' && $old_values != '' && $new_values != '') {
            $history = new PostsHistory;
            $history->user_id = Auth::guard('customer')->user()->id;
            $history->usertype = 'customer';
            $history->username = Auth::guard('customer')->user()->customer_company;
            $history->ad_id = $id;
            $history->column_name = $column_names;
            $history->status = $old_values;
            $history->new_status = $new_values;
            $history->type = 'sparepart';
            $history->save();
        }

        $final_ad = SparePartAd::find($id);
        $new_status = $final_ad->status;
        if ($old_status != $new_status) {

            $new_history = new AdsStatusHistory;
            $new_history->user_id = Auth::guard('customer')->user()->id;
            $new_history->usertype = 'customer';
            $new_history->ad_id = $id;
            $new_history->type = 'sparepart';
            $new_history->status = $new_history->ads_status($old_status);
            $new_history->new_status = $new_history->ads_status($new_status);
            $new_history->save();
        }
        // return 1;
        if ($request->ajax()) {
            return response()->json(array(
                'success' => true,
                'message' => 'Record Successfull Added.'
            ), 200);
        }
        return redirect('user/my-spear-parts-ads')->with('msg', 'Updated Successfully!');
    }

    
    public function removedUpdateSparePartAd(Request $request)
    {
        // dd($request->all());
        $rules = [];
        if ($request->has('product_image') && ($request->get('product_image') != null || $request->get('product_image') == '')) {
            $base  = $request->get('product_image');
            $files = count($base) - 1;
            if ($files > 0) {
                foreach ($base as $index => $image_path) {
                    if (!empty($image_path)) {
                        $rules['product_image.' . $index] = 'base64max:99999048';
                    }
                }
            }
        }
        $validatedData = $request->validate($rules);

        $updateAdsCheck = false;
        $column_names = '';
        $old_values = '';
        $new_values = '';
        $image_count = 0;

        $id = $request->sparepart_id;

        $queryAds = SparePartAd::where('id', $request->sparepart_id)->where('customer_id', '=', Auth::guard('customer')->user()->id);
        $getAds   = $queryAds->first();
        $getAds->product_code = $request->product_code;
        $getAds->condition = $request->condition;
        $getAds->price = $request->price;
        $getAds->vat = isset($request->vat) ? 1 : 0;
        $getAds->neg = isset($request->neg) ? 1 : 0;
        $getAds->save();

        $old_status = $getAds->status;

        if (@$getAds->status == 3) {
            @$getAds->status = 0;
            @$getAds->save();
        }

        $id               = $getAds->id;
        $description      = $request->description;
        $title            = $request->title;
        $activeLanguage   = \Session::get('language');

        $inputs  = $request->except('_token', 'sparepart_id', 'category', 'category_title','sub_category', 'product_image','freeAd','number_of_days','use_balance');

        $descript = SpAdDescription::where('spare_part_ad_id', @$id)->where('language_id', $activeLanguage['id'])->first();

        if ($descript->description != $description && $description != '') {
            SpAdDescription::where('spare_part_ad_id', $id)->where('language_id', $activeLanguage['id'])->update(["description" => $description]);
            SpAdDescription::where('spare_part_ad_id', $id)->where('language_id', '!=', $activeLanguage['id'])->delete();
            $updateAdsCheck = true;
            $column_names .= 'Description,';
            $old_values .= $descript->description . ',';
            $new_values .=  ',' . $description . ',';
        }

        $sp_title = SparePartAdTitle::where('spare_part_ad_id', $id)->where('language_id', $activeLanguage['id'])->first();

        if ($sp_title->title != $title && $title != '') {
            SparePartAdTitle::where('spare_part_ad_id', $id)->where('language_id', $activeLanguage['id'])->update(["title" => $title]);
            SparePartAdTitle::where('spare_part_ad_id', $id)->where('language_id', '!=', $activeLanguage['id'])->delete();
            $updateAdsCheck = true;
            $column_names .= 'Title,';
            $old_values .= $sp_title->title . ',';
            $new_values .=  ',' . $title . ',';
        }

        $base = $request->get('product_image');
        if (sizeof(array_filter($base)) > 0) {
            $updateAdsCheck = true;
            $column_names .= 'Picture,';
            $old_values .= $getAds->spare_parts_images->count() . ',';
            $image_count = $getAds->spare_parts_images->count();
            foreach ($base as $index => $base64) {
                if (!empty($base64)) {
                    $image = $this->upload($base64, $id, 'uploads/ad_pictures/spare-parts-ad/');
                    if ($image != '0') {
                        $adImage             = new SparePartAdImage();
                        $adImage->spare_part_ad_id = $id;
                        $adImage->img   = $image;
                        $adImage->save();
                        $image_count++;
                    }
                }
            } // end for loop.
            $new_values .= $image_count . ',';
        } //Endif

        if(!is_null($request->number_of_days)){
            $updateAdsCheck = true;
        }
        if ($updateAdsCheck) {
            if ($getAds->status == 2) {
                $inputs['status'] = 5;
            } else {
                $inputs['status'] = 0;
            }
        }
        unset($inputs['base']);
        $updateAds = $queryAds->update($inputs);

        if ($column_names != '' && $old_values != '' && $new_values != '') {
            $history = new PostsHistory;
            $history->user_id = Auth::guard('customer')->user()->id;
            $history->usertype = 'customer';
            $history->username = Auth::guard('customer')->user()->customer_company;
            $history->ad_id = $id;
            $history->column_name = $column_names;
            $history->status = $old_values;
            $history->new_status = $new_values;
            $history->type = 'sparepart';
            $history->save();
        }

        $final_ad = SparePartAd::find($id);
        $new_status = $final_ad->status;
        if ($old_status != $new_status) {

            if (!empty($request->number_of_days)) {

                $SpAds   = SparePartAd::where('customer_id', Auth::guard('customer')->user()->id)->whereIn('status', [0, 1, 3])->get()->count();
                $ids = SparePartAd::where('customer_id', Auth::guard('customer')->user()->id)->whereIn('status', [0, 1, 3])->pluck('id')->toArray();
                $account = CustomerAccount::where('customer_id', Auth::guard('customer')->user()->id)->where('type','sparepart_ad')->where('status','!=',2)->whereIn('ad_id',$ids)->count();

                $difference = $SpAds - $account;


                if (Auth::guard('customer')->user()->customer_role == 'individual' && !empty($request->number_of_days)) {
                    $GeneralSetting  = GeneralSetting::select('spare_parts_limit')->first();
                    $ad_limit           = $GeneralSetting->spare_parts_limit !== null ? $GeneralSetting->spare_parts_limit : 5;
                    $customer_type = 'Individual';
                }else{
                    $GeneralSetting  = GeneralSetting::select('b_spare_parts_limit')->first();
                    $ad_limit           = $GeneralSetting->b_spare_parts_limit !== null ? $GeneralSetting->b_spare_parts_limit : 5;
                    $customer_type = 'Business';
                }

                if ($difference >= $ad_limit) {                   

                    $new_history = new AdsStatusHistory;
                    $new_history->user_id = Auth::guard('customer')->user()->id;
                    $new_history->usertype = 'customer';
                    $new_history->ad_id = $id;
                    $new_history->type = 'sparepart';
                    $new_history->status = $new_history->ads_status($old_status);
                    $new_history->new_status = 'Created';
                    $new_history->save();

                    return $this->payForSparePart($request,$customer_type,$id);
                } 
            

            
            }
            else{
            $new_status = 0;
            $new_history = new AdsStatusHistory;
            $new_history->user_id = Auth::guard('customer')->user()->id;
            $new_history->usertype = 'customer';
            $new_history->ad_id = $id;
            $new_history->type = 'sparepart';
            $new_history->status = $new_history->ads_status($old_status);
            $new_history->new_status = $new_history->ads_status($new_status);
            $new_history->save();
        }

            //return redirect('user/my-spear-parts-ads')->with('msg', 'Updated Successfully!');
        }
        if ($request->ajax()) {
                return response()->json(array(
                    'success' => true,
                    'message' => 'Record Successfull Added.'
                ), 200);
            }
        return redirect('user/my-spear-parts-ads?status=0')->with('msg', 'Updated Successfully!');
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
        $sumCredit = CustomerAccount::where('customer_id', Auth::guard('customer')->user()->id)->where('status', 1)->sum('credit');
        $sumDebit  = CustomerAccount::where('customer_id', Auth::guard('customer')->user()->id)->sum('debit');
        $credit           = $sumCredit - $sumDebit;


        $request_amount = AdsPricing::where('type','Feature Car Ad')->where('number_of_days',$request->featured_days)->orderBy('id','DESC')->pluck('pricing')->first();

        if ($request->use_balance == 'on') {
            $ad = Ad::find(@$request->ad_id);

            $result              = array('success' => true, 'payment_status' => 'full');
            if ($ad->is_featured == 'false') {
                $start = Carbon::now();
                $start->addDays($request->featured_days);
                $featured_until = $start->endOfDay()->toDateTimeString();

                $account                 = new CustomerAccount;
                $account->customer_id    = Auth::guard('customer')->user()->id;
                $account->ad_id          = @$request->ad_id;
                $account->debit          = $request_amount;
                $account->status         = 1;
                $ad->is_featured         = 'true';
                $ad->feature_expiry_date = @$featured_until;
                if ($request_amount > $credit) {
                    $remaining_balance        = $request_amount - $credit;
                    //$account->credit        = $remaining_balance;
                    $account->debit           = $credit;
                    $request_amount           = $remaining_balance;
                    $is_featured              = false;
                    $result['payment_status'] = 'partial';
                    $account->status          = 0;
                    $ad->is_featured          = 'false';
                    $ad->feature_expiry_date  = null;
                }
                $account->detail         = 'feature ad';
                $account->number_of_days = $request->featured_days;
                $account->paid_amount    = @$request_amount;
                $account->type           = 'car';
                $account->save();
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
                $new_request->paid_amount = @$request_amount;
                $new_request->type   = 'car';
                $new_request->status = 0;
                $new_request->detail = 'feature ad';
                $new_request->save();
                // $ad->status = 5;
                //$ad->save();
                return response()->json(['request' => true, 'invoice_id2' => $new_request->id]);
            } else {
                return response()->json(['already_featured' => true,]);
            }
        }
    }

    public function featuredSparePart(Request $request)
    {
        $credit              = 0;
        $request_amount      = 0;
        $sumCredit = CustomerAccount::where('customer_id', Auth::guard('customer')->user()->id)->where('status', 1)->sum('credit');
        $sumDebit  = CustomerAccount::where('customer_id', Auth::guard('customer')->user()->id)->sum('debit');
        $credit           = $sumCredit - $sumDebit;

        $request_amount = AdsPricing::where('type','Feature SparePart Ad')->where('number_of_days',$request->featured_days)->orderBy('id','DESC')->pluck('pricing')->first();

        if ($request->use_balance == 'on') {
            $ad                  = SparePartAd::find(@$request->ad_id);
            $result              = array('success' => true, 'payment_status' => 'full');
            if ($ad->is_featured == 'false') {
                $start                = Carbon::now();
                $start->addDays($request->featured_days);
                $featured_until       = $start->endOfDay()->toDateTimeString();
                $account              = new CustomerAccount;
                $account->customer_id = Auth::guard('customer')->user()->id;
                $account->ad_id       = @$request->ad_id;

                $account->debit          = $request_amount;
                $account->status         = 1;
                $ad->is_featured         = 'true';
                $ad->feature_expiry_date = @$featured_until;
                if ($request_amount > $credit) {
                    $remaining_balance        = $request_amount - $credit;
                    //$account->credit        = $remaining_balance;
                    $account->debit           = $credit;
                    $request_amount           = $remaining_balance;
                    $is_featured              = false;
                    $result['payment_status'] = 'partial';
                    $account->status         = 0;
                    $ad->is_featured         = 'false';
                    $ad->feature_expiry_date = null;
                }
                $account->detail         = 'feature sparepart';
                $account->number_of_days = $request->featured_days;
                $account->paid_amount    = @$request_amount;
                $account->type           = 'sparepart';
                $account->save();
                $ad->save();
                $result['invoice_id']    = $account->id;
                return response()->json($result);
            } else {
                return response()->json(['already_featured' => true,]);
            }
        } else {
            $ad      = SparePartAd::find(@$request->ad_id);
            $pending = CustomerAccount::select('id')->where('ad_id', @$request->ad_id)->where('type', 'sparepart')->count();
            if (@$ad->is_featured == 'true') {
                return response()->json(['already_in_request' => true]);
            } else if ($ad->is_featured == 'false') {
                $new_request              = new CustomerAccount;
                $new_request->ad_id       = @$request->ad_id;
                $new_request->customer_id = Auth::guard('customer')->user()->id;
                $new_request->number_of_days = $request->featured_days;
                $new_request->paid_amount = @$request_amount;
                $new_request->type   = 'sparepart';
                $new_request->status = 0;
                $new_request->detail = 'feature sparepart';
                $new_request->save();
                //$ad->status              = 5;
                //$ad->save();

                return response()->json(['request' => true, 'invoice_id2' => $new_request->id]);
            } else {
                return response()->json(['already_featured' => true,]);
            }
        }
    }






    public function featuredOfferService(Request $request)
    {
        $credit             = 0;
        $request_amount     = 0;
        $sumCredit = CustomerAccount::where('customer_id', Auth::guard('customer')->user()->id)->where('status', 1)->sum('credit');
        $sumDebit  = CustomerAccount::where('customer_id', Auth::guard('customer')->user()->id)->sum('debit');
        $credit           = $sumCredit - $sumDebit;

        $request_amount = AdsPricing::where('type','Feature Offer Service Ad')->where('number_of_days',$request->featured_days)->orderBy('id','DESC')->pluck('pricing')->first();

        if ($request->use_balance == 'on') {
            $ad                       = Services::find(@$request->ad_id);

            $result              = array('success' => true, 'payment_status' => 'full');
            if ($ad->is_featured == 'false') {
                $start                = Carbon::now();
                $start->addDays($request->featured_days);
                $featured_until       = $start->endOfDay()->toDateTimeString();
                $account              = new CustomerAccount;
                $account->customer_id = Auth::guard('customer')->user()->id;
                $account->ad_id       = @$request->ad_id;
                $account->debit       = $request_amount;

                $account->status         = 1;
                $ad->is_featured         = 'true';
                $ad->feature_expiry_date = @$featured_until;
                if ($request_amount > $credit) {
                    $remaining_balance        = $request_amount - $credit;
                    //$account->credit        = $remaining_balance;
                    $account->debit           = $credit;
                    $request_amount           = $remaining_balance;
                    $is_featured              = false;
                    $result['payment_status'] = 'partial';

                    $account->status         = 0;
                    $ad->is_featured         = 'false';
                    $ad->feature_expiry_date = null;
                }
                $account->detail         = 'feature offerservice';
                $account->number_of_days = $request->featured_days;
                $account->paid_amount    = @$request_amount;
                $account->type           = 'offerservice';
                $account->save();
                $ad->save();
                $result['invoice_id']    = $account->id;

                return response()->json($result);
            } else {
                return response()->json(['already_featured' => true,]);
            }
        } else {
            $ad = Services::find(@$request->ad_id);
            $pending = CustomerAccount::select('id')->where('ad_id', @$request->ad_id)->where('type', 'offerservice')->count();
            if (@$ad->is_featured == 'true') {
                return response()->json(['already_in_request' => true]);
            } else if ($ad->is_featured == 'false') {
                $new_request = new CustomerAccount;
                $new_request->ad_id = @$request->ad_id;
                $new_request->customer_id = Auth::guard('customer')->user()->id;
                $new_request->number_of_days = $request->featured_days;
                $new_request->paid_amount = @$request_amount;
                $new_request->type   = 'offerservice';
                $new_request->status = 0;
                $new_request->detail = 'feature offerservice';
                $new_request->save();
                return response()->json(['request' => true, 'invoice_id2' => $new_request->id]);
            } else {
                return response()->json(['already_featured' => true,]);
            }
        }
    }

    public function exportPDF(Request $request)
    {
        $user = Customer::where('id', Auth::guard('customer')->user()->id)->first();
        if (@$request->invoice_number != null) {
            $account = CustomerAccount::find(@$request->invoice_number);
        } else {
            $account = CustomerAccount::orderBy('id', 'desc')->first();
        }
        $pdf = PDF::loadView('users.invoice', compact('account', 'user'));

        // making pdf name starts
        $makePdfName = 'invoice';
        return $pdf->stream($makePdfName . '.pdf');
        // return $pdf->download($makePdfName . '.pdf');
    }

    public function PayInvoicePdf($id)
    {
        $user = Customer::where('id', Auth::guard('customer')->user()->id)->first();
        if (@$id != null) {
            $account = CustomerAccount::find(@$id);
        } else {
            $account = CustomerAccount::orderBy('id', 'desc')->first();
        }
        $pdf = PDF::loadView('users.invoice', compact('account', 'user'));

        // making pdf name starts
        $makePdfName = 'invoice';
        return $pdf->stream($makePdfName . '.pdf');
        // return $pdf->download($makePdfName . '.pdf');
    }

    public function downloadPDF(Request $request)
    {
        $user = Customer::where('id', Auth::guard('customer')->user()->id)->first();

        if (@$request->invoice_number != null) {
            $account = CustomerAccount::find(@$request->invoice_number);
        } else {
            if (!empty($request->get('ad_id'))) {
                $type  = 'sparepart_ad';
                if (!empty($request->get('type'))) {
                    $type  = $request->get('type');
                }
                $ad_id = $request->get('ad_id');
                $account = CustomerAccount::orderBy('id', 'desc')->where('ad_id', $ad_id)->where('customer_id', $user->id)->where('type', $type)->first();
            } else {
                $account = CustomerAccount::orderBy('id', 'desc')->where('customer_id', $user->id)->first();
            }
        }
        $pdf = PDF::loadView('users.invoice', compact('account', 'user'));

        // making pdf name starts
        $makePdfName = 'invoice';
        //return $pdf->download($makePdfName . '.pdf');
        return $pdf->stream($makePdfName . '.pdf');
    }

    public function addInvoiceSetting(Request $request)
    {
        // dd($request->all());
        $invoice_setting = InvoiceSetting::where('customer_id', Auth::guard('customer')->user()->id)->first();

        if ($invoice_setting !== null) {
            $invoice_setting->customer_id = Auth::guard('customer')->user()->id;
            $invoice_setting->invoice_name = @$request->invoice_name;
            $invoice_setting->address = @$request->address;
            $invoice_setting->contact_person = @$request->contact_person;
            $invoice_setting->save();
            return response()->json(['update' => true]);
        } else {
            $new_setting = new InvoiceSetting;

            $new_setting->customer_id = Auth::guard('customer')->user()->id;
            $new_setting->invoice_name = @$request->invoice_name;
            $new_setting->address = @$request->address;
            $new_setting->contact_person = @$request->contact_person;
            $new_setting->status = 1;
            $new_setting->save();

            return response()->json(['success' => true]);
        }
    }

    public function getAdToFeature(Request $request)
    {

        $activeLanguage  = \Session::get('language');
        $ads_results     = Ad::query();
        $select_array    = array(
            'ads.id', 'is_featured', 'price', 'neg', 'year', 'millage',
            'v.engine_capacity', 'v.engine_power', 'v.label',  'poster_phone', 'customer_id', 'etd.title AS engine_title', 'gbd.title AS transmission_title',
            'mk.title', 'mo.name'
        );

        $ads_results->join('makes AS mk', 'mk.id', '=', 'ads.maker_id');
        $ads_results->join('models AS mo', 'mo.id', '=', 'ads.model_id');
        $ads_results->join('versions AS v', 'v.id', '=', 'ads.version_id');

        $ads_results->leftJoin('engine_types_description AS etd', function ($join) use ($activeLanguage) {
            $join->on('etd.engine_type_id', '=', 'ads.fuel_type');
            $join->where('etd.language_id', '=', $activeLanguage['id']);
        });
        $ads_results->leftJoin('transmission_description AS gbd', function ($join) use ($activeLanguage) {
            $join->on('gbd.transmission_id', '=', 'ads.transmission_type');
            $join->where('gbd.language_id', '=', $activeLanguage['id']);
        });
        $ads_results->select($select_array);
        $ads_results->where('ads.id', $request->id);
        $ad = $ads_results->first();
        $html_string = '<div class="col-12 pt-3 pb-3 mt-3 listingCol bg-white car-listing border">
              <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-4 pr-0 pl-md-3 listingCar">
                  <figure class="mb-0 position-relative">
                    <a href="#">';

        if (@$ad->ads_images[0]->img != null && file_exists(public_path() . '/uploads/ad_pictures/cars/' . $ad->id . '/' . @$ad->ads_images[0]->img)) {
            $html_string .= '<img src="' . url('public/uploads/ad_pictures/cars/' . $ad->id . '/' . @$ad->ads_images[0]->img) . '" class="img-fluid ads_image" alt="Image">';
        } else {
            $html_string .= '<img src="' . url('public/assets/img/caravatar.jpg') . '" alt="Car Image" class="img-fluid ads_image">';
        }

        $html_string .= '</a>
                    <figcaption class="position-absolute bottom left right top d-flex align-items-start flex-column justify-content-between">';
        if ($ad->is_featured == 'true') {
            $html_string .= '<span class="featuredlabel bgcolor2 font-weight-semibold pb-1 pl-2 pr-2 pt-1 text-uppercase text-white d-inline-block mt-2">' . __('featureAdPopup.pageTitle') . '
                    </span>';
        }
        $html_string .= '<span class="d-inline-block pb-1 pl-2 pr-2 pt-1 viewgallery"><em class="fa fa-camera"></em> ';
        if ($ad->ads_images !== null) {
            $html_string .= $ad->ads_images->count();
        } else {
            $html_string .= 0;
        }
        $html_string .= '</span>
                    </figcaption></a>
                  </figure>
                  
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-8 listingCar-descCar">
                  <div class="align-items-center d-flex justify-content-between listingCar-title mb-1">
                    <h5 class="font-weight-semibold mb-0"><a href="' . url('car-details/' . $ad->id) . '">' . @$ad->title . ' ' . @$ad->name . ' ' . @$ad->year . ' ' . $ad->label . '</a></h5>
                    <span class="lcPrice d-inline-block ml-3 font-weight-semibold">€' . $ad->price . '</span>
                  </div>
                  <div class="align-items-center d-flex justify-content-between listingCar-place mb-3"> 
                    <p class="themecolor2 font-weight-semibold mb-0 negotiable">';
        if ($ad->neg) {
            $html_string .= __('featureAdPopup.negotiable');
        }
        $html_string .= '</p></div>
                  <div class="align-items-center d-flex justify-content-between aboutcarlist mb-3">
                    <ul class="list-unstyled mb-0">
                      <li class="list-inline-item">' . $ad->year . '</li><span>&#124;</span>
                      <li class="list-inline-item">' . $ad->millage . 'KM</li><span>&#124;</span>
                      <li class="list-inline-item">' . $ad->engine_capacity . 'CC</li><span>&#124;</span>
                      <li class="list-inline-item">' . $ad->engine_title . '</li><span>&#124;</span>
                      <li class="list-inline-item">' . $ad->transmission_title . '</li>
                    </ul><span></span></div>
                  <div class="align-items-center d-none justify-content-between gridListprice mb-3">
                    <span class="lcPrice d-inline-block mr-3 font-weight-semibold"> €' . $ad->price . '</span>';
        if ($ad->neg) {
            $html_string .= '<p class="themecolor2 font-weight-semibold mb-0 negotiable">
                    ' . __('featureAdPopup.negotiable') . '</p>';
        }
        $html_string .= '</div><div class="align-items-center row contactRow"><div class="align-items-center col-12 col-lg-12 col-md-12 col-sm-12 d-flex justify-content-end lc-contact text-right pl-md-3 pl-0">';

        $html_string .= '<a href="javascript:void(0)" title="' . $ad->poster_phone . '" class="btn contactbtn themebtn3" style="font-size: 12px;font-weight: 200;padding: 5px 5px;"><em class="fa fa-phone"></em> ' . __('featureAdPopup.showPhone') . '</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>';

        $sumCredit = CustomerAccount::where('customer_id', $ad->customer_id)->where('status', 1)->sum('credit');
        $sumDebit  = CustomerAccount::where('customer_id', $ad->customer_id)->sum('debit');
        $credit           = $sumCredit - $sumDebit;

        if ($credit > 0) {
            $html_string .= '<div style="display:block;padding-left: 20px;margin-top: 20px"><input type="checkbox" name="use_balance" class="use_balance"><span class="ml-2">' . Lang::get("featureAdPopup.useAccountBalance") . '</span>';
        }
        return response()->json(['html' => $html_string]);
    }


    public function getSparePartToFeature(Request $request)
    {
        $ad = SparePartAd::find($request->id);
        $html_string = '
    <div class="row p-3 mx-0">
                    <figure class="col-lg-3 col-sm-4 col-4 pl-0 mb-0 ads-listing-img">';
        if (@$ad->get_one_image->img != null && file_exists(public_path() . '/uploads/ad_pictures/spare-parts-ad/' . $ad->id . '/' . @$ad->get_one_image->img)) {

            $html_string .= '<img src="' . url('public/uploads/ad_pictures/spare-parts-ad/' . @$ad->id . '/' . @$ad->get_one_image->img) . '" alt="image" class="img-fluid ads_image">';
        } else {
            $html_string .= '<img src="' . url('public/assets/img/sparepartavatar.jpg') . '" alt="Car Image" class="img-fluid ads_image">';
        }

        $html_string .= '</figure> 
                    <div class="col-lg-9 col-sm-8 col-8 pl-md-0 pl-sm-3 pl-0 pr-0 ads-listing-text">
                      <h4><a href="' . url('spare-parts-details/' . $ad->id) . '">' . $ad->title . '</a></h4>
                    </div>
                    <div class="col-12 px-0 mt-3">
                      <div class="row align-items-sm-center">
                    <div class="col-lg-7 col-md-8 col-sm-8 mb-0 editProfile actionbtn ">
                      
                    </div>
                
                  </div>
                    </div>
                  </div>';
        /* $creditCollection = CustomerAccount::where('customer_id', $ad->customer_id)->where('status', 1)->selectRaw('SUM(credit) -  SUM(debit) AS total_balance')->first();
        $credit           = $creditCollection->total_balance; */
        $sumCredit = CustomerAccount::where('customer_id', $ad->customer_id)->where('status', 1)->sum('credit');
        $sumDebit  = CustomerAccount::where('customer_id', $ad->customer_id)->sum('debit');
        $credit           = $sumCredit - $sumDebit;
        if ($credit > 0) {
            $html_string .= '<div style="display:block;padding-left: 20px;margin-top: 20px"><input type="checkbox" name="use_balance" class="use_balance"><span class="ml-2">' . Lang::get("featureAdPopup.useAccountBalance") . '</span>';
        }
        return response()->json(['html' => $html_string]);
    }



    public function getServiceToFeature(Request $request)
    {
        $ad = Services::find($request->id);
        $activeLanguage  = \Session::get('language');
        $html_string = '<div class="row p-3 mx-0"><figure class="col-lg-3 col-sm-4 col-4 pl-0 mb-0 ads-listing-img">';
        if (@$ad->services_images[0]->image_name != null && file_exists(public_path() . '/uploads/ad_pictures/services/' . $ad->id . '/' . @$ad->services_images[0]->image_name)) {
            $html_string .= ' <img src="' . url('public/uploads/ad_pictures/services/' . $ad->id . '/' . @$ad->services_images[0]->image_name) . '" alt="image" class="img-fluid ads_image">';
        } else {
            $html_string .= ' <img src="' . url('public/assets/img/serviceavatar.jpg') . '" alt="Car Image" class="img-fluid ads_image">';
        }
        $html_string .= '</figure> 
                    <div class="col-lg-9 col-sm-8 col-8 pl-md-0 pl-sm-3 pl-0 pr-0 ads-listing-text">
                      <h4><a href="' . url('company_profile/' . @$ad->get_customer->id) . '">' . @$ad->get_service_ad_title($ad->id, $activeLanguage['id'])->title . '</a></h4>
                      <p class="ads-views mb-0"><em class="fa fa-eye"></em> ' . @$ad->views . ' Views</p>
                    </div>
                    <div class="col-12 px-0 mt-3">
                      <div class="row align-items-sm-center">
                    <div class="col-lg-7 col-md-8 col-sm-8 mb-0 editProfile actionbtn ">             
                    </div>
                  </div>
                    </div>
                  </div>';
        $sumCredit = CustomerAccount::where('customer_id', $ad->customer_id)->where('status', 1)->sum('credit');
        $sumDebit  = CustomerAccount::where('customer_id', $ad->customer_id)->sum('debit');
        $credit           = $sumCredit - $sumDebit;
        if ($credit > 0) {
            $html_string .= '<div style="display:block;padding-left: 20px;margin-top: 20px"><input type="checkbox" name="use_balance" class="use_balance"><span class="ml-2">' . Lang::get("featureAdPopup.useAccountBalance") . '</span>';
        }
        return response()->json(['html' => $html_string]);
    }

    public function checkSparePartsAdsNumbers()
    {
        if (request()->ajax()) {
            $role             = Auth::user()->customer_role;
            $settings         = GeneralSetting::first();

            $PartsAds           = SparePartAd::where('customer_id', Auth::guard('customer')->user()->id)->whereIn('status', [0, 1, 3])->count();
            $ids = SparePartAd::where('customer_id', Auth::guard('customer')->user()->id)->whereIn('status', [0, 1, 3])->pluck('id')->toArray();
            $account = CustomerAccount::where('customer_id', Auth::guard('customer')->user()->id)->where('type','sparepart_ad')->where('status','!=',2)->whereIn('ad_id',$ids)->count();
            $difference = $PartsAds - $account;

            if ($role == 'individual') {
                $ad_limit = $settings->spare_parts_limit;             
            }else{
                $ad_limit = $settings->b_spare_parts_limit;
            }
            
            if ($difference >= $ad_limit) {
                return response()->json(['pay' => true]);
            } else {
                return response()->json(['pay' => false]);
            }
            
        } else {
            return response('Forbidden', 403);
        }
    }

    public function checkServiceAdsNumbers()
    {
        if (request()->ajax()) {
            $role             = Auth::user()->customer_role;
            $settings         = GeneralSetting::first();

            $ServiceAds           = Services::where('customer_id', Auth::guard('customer')->user()->id)->whereIn('status', [0, 1, 3])->count();
            $ids = Services::where('customer_id', Auth::guard('customer')->user()->id)->whereIn('status', [0, 1, 3])->pluck('id')->toArray();
            $account = CustomerAccount::where('customer_id', Auth::guard('customer')->user()->id)->where('type','offerservice_ad')->where('status','!=',2)->whereIn('ad_id',$ids)->count();
            $difference = $ServiceAds - $account;

            $ad_limit = $settings->b_service_limit;
            
            if ($difference >= $ad_limit) {
                return response()->json(['pay' => true]);
            } else {
                return response()->json(['pay' => false]);
            }
            
        } else {
            return response('Forbidden', 403);
        }
    }

    public function checkAdsNumbers()
    {
        if (request()->ajax()) {
            $role              = Auth::user()->customer_role;
            $settings           = GeneralSetting::first();

            $CarAds = Ad::where('customer_id', Auth::guard('customer')->user()->id)->whereIn('status', [0, 1, 3])->count();
            $ids = Ad::where('customer_id', Auth::guard('customer')->user()->id)->whereIn('status', [0, 1, 3])->pluck('id')->toArray();
            $account = CustomerAccount::where('customer_id', Auth::guard('customer')->user()->id)->where('type','car_ad')->where('status','!=',2)->whereIn('ad_id',$ids)->count();
            $difference = $CarAds - $account;
            
            if ($role == 'individual') {
                $ad_limit = $settings->ads_limit;             
            }else{
                $ad_limit = $settings->b_ads_limit;
            }

            if ($difference >= $ad_limit) {
            return response()->json(['pay' => true]);
            } else {
            return response()->json(['pay' => false]);
            } 
        } else {
            return response('Forbidden', 403);
        }
    }

    public function getMyPayments(Request $request)
    {
        //$activeLanguage  = \Session::get('language');
        //$activeLanguage['id']
        $accounts = CustomerAccount::where('customer_id', Auth::guard('customer')->user()->id);

        //dd($accounts->get());


        if ($request->from_date !== null) {
            $accounts = $accounts->where('created_at', '>=', $request->from_date . ' 00:00:00');
        }

        if ($request->to_date !== null) {
            $accounts = $accounts->where('created_at', '<=', $request->to_date . ' 23:59:59');
        }

        $accounts = $accounts->orderBy('id', 'DESC');
        //dd($accounts->get());
        return Datatables::of($accounts)

            ->addColumn('invoice_no', function ($item) {
                if ($item->credit != '' || $item->paid_amount)
                    if ($item->status == 2)
                        $html_string = 'C' . @$item->id;
                    else
                        $html_string = '<a href="javascript:void(0)" class="themecolor download_invoice" data-id="' . @$item->id . '">C' . @$item->id . '</a>';
                else
                    $html_string = '';

                return @$html_string;
            })

            ->addColumn('date', function ($item) {

                return @$item->created_at->format('d-M-Y');
            })

            ->addColumn('amount', function ($item) {
                if ($item->credit != null && $item->credit != 0.00) {
                    $html_string = '<span class="themecolor3">' . $item->credit . '</span>';
                } elseif ($item->debit != null  && $item->debit != 0.00) {
                    $html_string = '<span class="themecolor2">' . $item->debit . '</span>';
                } else {
                    $html_string = '<span class="themecolor2">' . $item->paid_amount . '</span>';
                }
                return @$html_string;
            })

            ->addColumn('details', function ($item) {
                $html_string = @$item->get_front_detail($item->id);
                return $html_string;
            })

            ->addColumn('type', function ($item) {
                $html_string = $item->get_front_type($item->type);
                return $html_string;
            })

            ->addColumn('status', function ($item) {
                if ($item->status == 0)
                    $html_string = Lang::get('dashboardMyAds.statusPending');
                else if ($item->status == 1)
                    $html_string = Lang::get('dashboardMyAds.paid');
                else if ($item->status == 2)
                    $html_string = Lang::get('dashboardMyAds.notPaid');
                return $html_string;
            })

            ->rawColumns(['invoice_no', 'date', 'amount', 'details', 'type', 'status'])
            ->make(true);
    }

    public function postExtraAd(Request $request)
    {
        $credit = 0;
        $request_amount = 0;
        foreach (Auth::guard('customer')->user()->customer_account as $account) {
            if ($account->status == 1) {
                $credit = $credit + $account->credit - @$account->debit;
            }
        }

        $request_amount = AdsPricing::where('type','Car Ad')->where('number_of_days',$request->featured_days)->orderBy('id','DESC')->pluck('pricing')->first();

        if (($request_amount < $credit) && ($request->use_balance == 'on')) {
            $ad = Ad::find(@$request->ad_id);

            $start = Carbon::now();
            $start->addDays($request->featured_days);
            $featured_until = $start->endOfDay()->toDateTimeString();

            $account = new CustomerAccount;
            $account->customer_id = Auth::guard('customer')->user()->id;
            $account->ad_id = @$request->ad_id;
            $account->debit = $request_amount;
            $account->detail = 'Post An Ad';
            $account->number_of_days = $request->featured_days;
            $account->paid_amount = @$request_amount;
            $account->status = 1;
            $account->type = 'car_ad';
            $account->save();
            $ad->status = 0;
            $ad->save();

            return response()->json(['success' => true, 'invoice_id' => $account->id]);
        } else {
            $ad = Ad::find(@$request->ad_id);
            $new_request = new CustomerAccount;
            $new_request->ad_id = @$request->ad_id;
            $new_request->customer_id = Auth::guard('customer')->user()->id;
            $new_request->number_of_days = $request->featured_days;
            $new_request->paid_amount = @$request_amount;
            $new_request->credit = @$request_amount;
            $new_request->type = 'car_ad';
            $new_request->detail = 'Post An Ad';
            $new_request->save();

            return response()->json(['request' => true, 'invoice_id2' => $new_request->id]);
        }
    }

    public function discardAd(Request $request)
    {
        // dd($request->id);

        $ad = Ad::find($request->id);

        @$ad->ads_images()->delete();
        @$ad->ad_tags()->delete();
        @$ad->delete();
        return response()->json([
            "success" => true,  'url' => url('user/my-ads')
        ]);
    }
}