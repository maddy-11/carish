<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Models\Cars\Carmodel;
use App\Models\Cars\Features;
use App\Models\Cars\BodyTypes;
use App\Models\Cars\Make;
use App\Models\Cars\Version;
use App\Ad;
use App\Car;
use App\Color;
use App\Suggesstion;
use App\SuggestionDescriptions;
use App\Models\Language;
use Illuminate\Support\Facades\Auth;
use App\SparePartAd;
use App\EmailTemplate;
use App\Models\AdDescription;
use App\Models\SpAdDescription;
use App\Models\Services;
use App\ServiceDetail;
use App\Models\Customers\PrimaryService;
use App\Models\Customers\SubService;
use App\Mail\PublishOfferServiceAd;
use App\Models\ServiceDescription;
use App\Models\Customers\Customer;
use App\Page;
use App\EmailType;
use App\SparePartCategory;
use App\VehicleType;
use App\Chat;
use App\CustomerMessages;
use App\Models\Customers\CustomerAccount;
use App\Tag;
use App\Models\EngineType;
use App\Models\Transmission;
use App\Models\Country;
use App\Reason;
use App\Models\GoogleAd;
use App\Models\AdsPage;
use App\Models\Cars\Makemodelversion;
use App\Models\Role;
use App\Models\RoleMenu;
use App\GeneralSetting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(
            \App\Repositories\Customer\CustomerRepositoryContract::class,
            \App\Repositories\Customer\CustomerRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        config(['app.locale' => 'et']);
        Schema::defaultStringLength(191);
        if (function_exists('header_remove')) {
           // header('X-Powered-By: Our company\'s development team');
            header_remove('X-Powered-By'); 
        } else {
            @ini_set('expose_php', 'off');
        }
        $GeneralSetting = session('GeneralSetting');
        if(empty($GeneralSetting)){
            $GeneralSetting = GeneralSetting::first();
            session(['GeneralSetting' =>  $GeneralSetting]);
        }
        view()->composer('*', function ($view) {
            if(Auth::user())
            {
                $userType = Auth::user();
                $makers_count = make::where('status',1)->count();
                $model_count = carmodel::where('status',1)->count();
                $color_count = Color::all()->count();
                $features_count = Features::where('status',1)->count();
                $body_types_count = Bodytypes::where('status',1)->count();
                $suggestions_count = Suggesstion::where('status',1)->count();
                $vehicles_type_count = VehicleType::where('status',1)->count();
                $tags_count = Tag::where('status',1)->count();
                $reasons_count = Reason::where('status',1)->count();
                $engine_type_count = EngineType::where('status',1)->count();
                $transmission_count = Transmission::where('status',1)->count();
                $countries_count = Country::where('status',1)->count();

                $pending_adds_count = Ad::where('status',0)->count();
                $not_approve_adds_count = Ad::where('status',3)->count();
                $active_adds_count = Ad::where('status',1)->count();
                $removed_adds_count = Ad::where('status',2)->count();
                $unpaid_ads = Ad::where('status',5)->has('is_paid_ad')->count();
                $m_d_v_count = Makemodelversion::all()->count();

                
                $pending_spareparts_count = SparePartAd::where('status',0)->count();
                $not_approve_spareparts_count = SparePartAd::where('status',3)->count();
                $active_spareparts_count = SparePartAd::where('status',1)->count();
                $remove_spareparts_count = SparePartAd::where('status',2)->count();
                $unpaid_spareparts = SparePartAd::where('status',5)->has('is_paid_ad')->count();
                $categories_count = SparePartCategory::where('parent_id',0)->where('status',1)->count();

                $pending_services_count = Services::where('status',0)->count();
                $not_approve_services_count = Services::where('status',3)->count();
                $active_services_count = Services::where('status',1)->count();
                $removed_services_count = Services::where('status',2)->count();
                $unpaid_services = Services::where('status',5)->has('is_paid_ad')->count();
                
                $primary_services_count = PrimaryService::where('status',1)->count();
                $sub_services_count = SubService::where('parent_id',0)->where('status',1)->count();
                $active_users_count = Customer::where('customer_status','Active')->where('is_adminverify',1)->count();
                $pending_admin_count = Customer::where('is_adminverify',0)->where('customer_role','business')->count();
                $inactive_users_count = Customer::where('customer_status','Inactive')->count();
                $pages_count = Page::all()->count();
                $email_templates_count = EmailTemplate::where('status',1)->count();
                $email_types_count = EmailType::where('status',1)->count();
                $google_ad_count = GoogleAd::where('status',1)->count();
                $google_ad_pages_count = AdsPage::where('status',1)->count();
                $pending_invoices_count = CustomerAccount::select('id')->where('status',0)->count();
                $approved_invoices_count = CustomerAccount::select('id')->where('status',1)->count();
                $unpaid_invoices_count = CustomerAccount::select('id')->where('status',2)->count();
                
                $user_role_menus=RoleMenu::where('role_id',Auth::user()->role_id)->pluck('menu_title')->toArray();
                       
                $view->with(compact('userType','makers_count','model_count','color_count','features_count','body_types_count','suggestions_count','pending_adds_count','active_adds_count','removed_adds_count','pending_spareparts_count','active_spareparts_count','pending_services_count','active_services_count','primary_services_count','sub_services_count','active_users_count','pending_admin_count','inactive_users_count','pages_count','email_templates_count','not_approve_adds_count','not_approve_spareparts_count','not_approve_services_count','categories_count','vehicles_type_count','remove_spareparts_count','removed_services_count','pending_invoices_count','approved_invoices_count','unpaid_invoices_count','email_types_count','tags_count','engine_type_count','transmission_count','reasons_count','countries_count','google_ad_count','google_ad_pages_count','m_d_v_count','unpaid_ads','unpaid_spareparts','user_role_menus'));
            }

            if(Auth::guard('customer')->user())
            {
                $unread_msgs = CustomerMessages::where('to_id' , Auth::guard('customer')->user()->id)->where('read_status' , 0)->count();
                // dd($unread_msgs);
                $view->with(compact('unread_msgs'));

            }
        });
    }
}
