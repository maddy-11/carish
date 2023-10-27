<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Customers\CustomerAccount;
use App\GeneralSetting;

use App\Models\Services;
use App\SparePartAd;
use App\Ad;
use App\Reason;
use App\AdMsg;
use App\SparepartsAdsMessage;
use App\Models\AdsStatusHistory;
use Illuminate\Support\Facades\Auth;
use Mail;
use App\Mail\CronJobTest;

class DeleteInvoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:invoices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is used to delete the expired invoices.A cron job is running for this purposes, all the invoices will be completly deleted from the system';

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
        $message = '<hr><p>Delete Invocies:</p>';
        $date = Carbon::now();

        $invoiceExpiryDays = GeneralSetting::select("invoice_expiry_days")->findOrFail(1);
        if (!empty($invoiceExpiryDays)) {
            $days               = $invoiceExpiryDays->invoice_expiry_days;
            //
            $getExpiredInvoices = CustomerAccount::select('id', 'ad_id', 'type', 'detail')->whereRaw("DATE_ADD(updated_at, INTERVAL " . $days . " DAY)<NOW()")->where('status', '0')->get();
            if ($getExpiredInvoices->isNotEmpty()) {
                $ads                  = array();
                $spareParts           = array();
                $services             = array();
                $featureAds           = array();
                $featureOfferServices = array();
                $featureSpareParts    = array();
                $accountInvoices      = array();
                foreach ($getExpiredInvoices as $account) {
                    $accountInvoices[] = $account->id;

                    if ($account->type == 'car_ad') {
                        $ads[] = $account->ad_id;
                    }
                    if ($account->type == 'car') {
                        $featureAds[] = $account->ad_id;
                    }
                    if ($account->type == 'sparepart_ad') {
                        $spareParts[] = $account->ad_id;
                    }
                    if ($account->type == 'sparepart') {
                        $featureSpareParts[] = $account->ad_id;
                    }
                    if ($account->type == 'offerservice') {
                        $featureOfferServices[] = $account->ad_id;
                    }
                }
                if (!empty($ads)) {
                    foreach($ads as $id)
                    {
                        $ad = Ad::where('id', $id)->first();
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
                    // Ad::whereIn('id', $ads)->update(['active_until' => null]);
                }
                if (!empty($featureAds)) {
                    Ad::whereIn('id', $featureAds)->update(['feature_expiry_date' => null]);
                }
                if (!empty($spareParts)) {
                    foreach($spareParts as $id)
                    {
                        $sp_ad = SparePartAd::where('id', $id)->first();
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
                    // SparePartAd::whereIn('id', $spareParts)->update(['active_until' => null]);
                }
                if (!empty($featureSpareParts)) {
                    SparePartAd::whereIn('id', $featureSpareParts)->update(['feature_expiry_date' => null]);
                }
                if (!empty($featureOfferServices)) {
                    Services::whereIn('id', $featureOfferServices)->update(['feature_expiry_date' => null]);
                }
                CustomerAccount::whereIn('id', $accountInvoices)->update(['status' => '2']);

            }
        }

        $data = ['poster_name' => 'Ahsan Elahi','now_date' => $date,'message' => $message];
        Mail::to('mr.elahi.ehsan@gmail.com')->send(new CronJobTest($data));
        
        return Command::SUCCESS;
    }
}