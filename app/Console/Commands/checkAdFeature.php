<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Ad;
use App\SparePartAd;
use App\Models\Services;
use App\ServiceMessage;
use Carbon\Carbon;
use App\Reason;
use App\AdMsg;
use App\SparepartsAdsMessage;
use App\Models\AdsStatusHistory;
use Mail;
use App\Mail\CronJobTest;

class checkAdFeature extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'checkAdFeature:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will check on daily basis when will feature property end of an Ad';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $message = '';
        $date = Carbon::now();

        $ads = Ad::where('is_featured','true')->get();
        foreach ($ads as $ad) {
            $message .= '<hr><p>Car Ads Featured Expire:</p>';
            $ad_feature_date = Carbon::parse($ad->feature_expiry_date)->format('Y-m-d H:i:s');

            if($date > $ad_feature_date)
            {
                $message .= '<p>AD ID:'.$ad->id.'</p>
                <p>AD Featured Date:'.$ad_feature_date.'</p>';

                $ad->feature_expiry_date = null;
                $ad->is_featured = 'false';
                $ad->save();
            }
        }

        $ads_active = Ad::whereNotNull('active_until')->get();
        foreach ($ads_active as $ad) {
            $active_date = Carbon::parse($ad->active_until)->format('Y-m-d H:i:s');

            if($date > $active_date)
            {
                $old_status = $ad->status;
                $ad->status = 2;
                $ad->active_until = null;
                $ad->save();

                $new_status  = $ad->status;

                $reason_id = Reason::where('slug','removed-by-system')->pluck('id')->first();
                if(!is_null($reason_id)){
                $reason_id = $reason_id;
                }
                else{
                $reason_id = null;
                }
                $ad_message = new AdMsg;
                $ad_message->user_id = $ad->customer_id;
                $ad_message->ad_id = $ad->id;
                $ad_message->reason_id = $reason_id;
                $ad_message->save();

                $new_history = new AdsStatusHistory;
                $new_history->user_id = 1;
                $new_history->usertype = 'staff';
                $new_history->ad_id = $ad->id;
                $new_history->type = 'car';
                $new_history->status = $new_history->ads_status($old_status);
                $new_history->new_status = $new_history->ads_status($new_status);
                $new_history->save();
            }
        }

        $sp_ads = SparePartAd::where('is_featured','true')->get();
        foreach ($sp_ads as $ad) {
            $ad_feature_date = Carbon::parse($ad->feature_expiry_date)->format('Y-m-d H:i:s');

            if($date > $ad_feature_date)
            {
                $ad->feature_expiry_date = null;
                $ad->is_featured = 'false';
                $ad->save();
            }
        }

        $ads_sp_active = SparePartAd::whereNotNull('active_until')->get();
        foreach ($ads_sp_active as $sp_ad) {
            $ad_sp_date = Carbon::parse($sp_ad->active_until)->format('Y-m-d H:i:s');
            $message .= '<hr><p>SpareParts Ads Expire:</p>';

            if($date > $ad_sp_date)
            {   
                $message .= '<p>AD ID:'.$sp_ad->id.'</p>
                <p>AD Active Until Date:'.$sp_ad->active_until.'</p>';

                $old_status = $sp_ad->status;
                $sp_ad->status = 2;
                $sp_ad->active_until = null;
                $sp_ad->save();
                $new_status  = $sp_ad->status;

                $reason_id = Reason::where('slug','removed-by-system')->pluck('id')->first();
                if(!is_null($reason_id)){
                $reason_id = $reason_id;
                }
                else{
                $reason_id = null;
                }
                $ad_message = new SparepartsAdsMessage;
                $ad_message->user_id = $sp_ad->customer_id;
                $ad_message->spare_parts_ads_id = $sp_ad->id;
                $ad_message->reason_id = $reason_id;
                $ad_message->save();

                $new_history = new AdsStatusHistory;
                $new_history->user_id = 1;
                $new_history->usertype = 'staff';
                $new_history->ad_id = $sp_ad->id;
                $new_history->type = 'sparepart';
                $new_history->status = $new_history->ads_status($old_status);
                $new_history->new_status = $new_history->ads_status($new_status);
                $new_history->save();


            }
        }

        $service_ads = Services::where('is_featured','true')->get();
        foreach ($service_ads as $ad) {
            $ad_feature_date = Carbon::parse($ad->feature_expiry_date)->format('Y-m-d H:i:s');

            if($date > $ad_feature_date)
            {
                $ad->feature_expiry_date = null;
                $ad->is_featured = 'false';
                $ad->save();
            }
        }

        $ads_service_active = Services::whereNotNull('active_until')->get();
        foreach ($ads_service_active as $service_ad) {
            $ad_service_date = Carbon::parse($service_ad->active_until)->format('Y-m-d H:i:s');
            $message .= '<hr><p>Services Ads Expire:</p>';

            if($date > $ad_service_date)
            {   
                $message .= '<p>AD ID:'.$service_ad->id.'</p>
                <p>AD Active Until Date:'.$service_ad->active_until.'</p>';

                $old_status = $service_ad->status;
                $service_ad->status = 2;
                $service_ad->active_until = null;
                $service_ad->save();
                $new_status  = $service_ad->status;

                $reason_id = Reason::where('slug','removed-by-system')->pluck('id')->first();
                if(!is_null($reason_id)){
                $reason_id = $reason_id;
                }
                else{
                $reason_id = null;
                }
                $ad_message = new ServiceMessage;
                $ad_message->user_id = $service_ad->customer_id;
                $ad_message->services_id = $service_ad->id;
                $ad_message->reason_id = $reason_id;
                $ad_message->save();

                $new_history = new AdsStatusHistory;
                $new_history->user_id = 1;
                $new_history->usertype = 'staff';
                $new_history->ad_id = $service_ad->id;
                $new_history->type = 'offerservice';
                $new_history->status = $new_history->ads_status($old_status);
                $new_history->new_status = $new_history->ads_status($new_status);
                $new_history->save();


            }
        }

        $data = ['poster_name' => 'Ahsan Elahi','now_date' => $date,'message' => $message];
        Mail::to('mr.elahi.ehsan@gmail.com')->send(new CronJobTest($data));

        return Command::SUCCESS;
     }
}