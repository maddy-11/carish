<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function __construct()
   {
       $this->middleware('auth:customer');
   }

    public function index(){

    	 return view('home');
    }


    public function saveSparePartAd(Request $request)
    {
        $GeneralSetting   = GeneralSetting::select('spare_parts_limit')->first();
        $count            = $GeneralSetting->spare_parts_limit !== null ? $GeneralSetting->spare_parts_limit : 5;
        $cust_ad_count    = SparePartAd::where('customer_id', Auth::guard('customer')->user()->id)->get()->count();
        $role             = Auth::guard('customer')->user()->customer_role;

        $ad               = new SparePartAd();
        $ad->customer_id  = Auth::guard('customer')->user()->id;
        $ad->title        = $request->title;
        $ad->product_code = $request->product_code;
        $ad->city_id      = 1;
        $ad->parent_id    = $request->category;

        $ad->category_id = $request->sub_category;
        $ad->condition   = $request->condition;
        $ad->price       = $request->price;
        $ad->vat         = isset($request->vat) ? 1 : 0;
        $ad->neg         = isset($request->neg) ? 1 : 0;

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
        $base = $request->get('product_image');
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
        $data = [
            'poster_name' => $ad->get_customer->customer_company,
            'title'       => @$spare_title->title
        ];

        $templatee = EmailTemplate::where('type', 1)->first();
        $template  = EmailTemplateDescription::where('email_template_id', $templatee->id)->where('language_id', @$ad->customer->language_id)->first();
        Mail::to($request->poster_email)->send(new CarAd($data, $template));
        $payment = 0;

        if ($role == 'individual' && !empty($request->number_of_days)) {
            if ($cust_ad_count >= $count) {
                $request->ad_id         = $ad->id;
                $ad->status             = 5;
                $ad->save();
                return $this->payForSparePart($request);
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
                return redirect('user/my-spear-parts-ads')->with('spare_part', $payment);
            }
        } else {
            $new_history             = new AdsStatusHistory;
            $new_history->user_id    = Auth::guard('customer')->user()->id;
            $new_history->usertype   = 'customer';
            $new_history->ad_id      = $ad->id;
            $new_history->type       = 'sparepart';
            $new_history->status     = 'Created';
            $new_history->new_status = 'Pending';
            $new_history->save();
            return redirect('user/my-spear-parts-ads')->with('spare_part', $payment);
        }
    }


    private function payForAds($request)
    {
        $credit             = 0;
        $request_amount     = 0;
        $customer_id        = Auth::guard('customer')->user()->id;
        $sumCredit          = CustomerAccount::where('customer_id', $customer_id)->where('status', 1)->sum('credit');
        $sumDebit           = CustomerAccount::where('customer_id', $customer_id)->sum('debit');
        $credit             = $sumCredit-$sumDebit;

        if (@$request->number_of_days == 3) {
            $request_amount = 10;
        } else if (@$request->number_of_days == 7) {
            $request_amount = 20;
        } else if (@$request->number_of_days == 15) {
            $request_amount = 35;
        }

        $account                 = new CustomerAccount;
        if ($request->use_balance == 'on') {
            $ad                   = Ad::find($request->ad_id);
            $start                = Carbon::now();
            $partial              = false;
            $result               = array('success' => true, 'payment_status' => 'full');
            $start->addDays($request->number_of_days);
            $active_until         = $start->endOfDay()->toDateTimeString();
            $account->customer_id = $customer_id;
            $account->ad_id       = $request->ad_id;
            $account->debit       = $request_amount;

            if ($request_amount > $credit) {
                $remaining_balance        = $request_amount - $credit;
                $account->debit           = $credit;
                $request_amount           = $remaining_balance;
                $partial                  = true;
                $result['payment_status'] = 'partial';
            }
            $account->detail         = 'Post An Ad';
            $account->number_of_days = $request->number_of_days;
            $account->paid_amount    = @$request_amount;
            $account->status         = 1;
            $account->type           = 'car';
            $account->save();
            if ($partial == false) {
                $ad->status              = 0;
                $ad->save();
            }

            $new_history             = new AdsStatusHistory;
            $new_history->user_id    = $customer_id;
            $new_history->ad_id      = $request->ad_id;
            $new_history->type       = 'car';
            $new_history->status     = 'Paid';
            $new_history->new_status = 'Pending';
            $new_history->save();
            $result['invoice_id']    = $account->id;
            return response()->json($result);
        } else {
            $new_request                  = $account;
            $new_request->ad_id           = @$request->ad_id;
            $new_request->customer_id     = $customer_id;
            $new_request->number_of_days  = $request->number_of_days;
            if (@$request->number_of_days == 3) {
                $new_request->paid_amount = '10';
            } else if (@$request->number_of_days == 7) {
                $new_request->paid_amount = '20';
            } else {
                $new_request->paid_amount = '35';
            }

            $new_request->status     = 0;
            $new_request->type       = 'car';
            $new_request->detail     = 'Post An Ad';
            $new_request->save();
            $new_history             = new AdsStatusHistory;
            $new_history->user_id    = $customer_id;
            $new_history->ad_id      = $request->ad_id;
            $new_history->type       = 'car';
            $new_history->status     = 'Unpaid';
            $new_history->new_status = 'Pending';
            $new_history->save();
            $result['invoice_id']    = $account->id;
            return response()->json(['request' => true, 'invoice_id' => $new_request->id, 'payment_status' => 'unpaid']);
        }
    }
}
