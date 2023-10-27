<?php
namespace App\Http\Controllers\Admin;
use App\Ad;
use App\Http\Controllers\Controller;
use App\SparePartAd;
use Illuminate\Http\Request;
use App\Models\Customers\Customer;
use App\EmailTemplate;
use App\EmailTemplateDescription;
use App\AdMsg;
use App\SparepartsAdsMessage;
use Mail;
use App\Mail\SparePartAdPayRecieved;
use App\Mail\PublishSparePartAd;
use App\Mail\AdMessage;
use App\Mail\SpAdMsgMail;
use App\Models\Language;
use App\Models\AdDescription;
use App\Mail\CarAd;
use App\Mail\SpartPartAd;
use App\Models\SpAdDescription;
use App\SparePartAdTitle;
use App\Models\Customers\CustomerAccount;
use PDF;
use App\Models\Services;
use Illuminate\Support\Facades\Auth;
use App\Models\Customers\FeaturedRequest;
use Carbon\Carbon;
use App\AdTag;
use App\Models\TagDescription;
use App\Reason;
use App\ReasonsDescription;
use App\EmailType;
use App\Models\Cars\Makemodelversion;
use Illuminate\Support\Facades\Redirect;
use App\Models\AdsStatusHistory;
use App\PostsHistory;
use GoogleTranslate;
use App\Models\BoughtFrom;

class AdsManagementController extends Controller
{


    public function show($id)
    {
        $ads            = Ad::find($id); 
        $languages      = Language::all();
        $ads_images     = $ads->ads_images;
        $ads_colors     = $ads->color;
        $ads_city       = $ads->city;
        $ads_model      = $ads->model;
        $ads_maker      = $ads->maker;
        $ads_version    = $ads->versions;
        $ads_bodyType   = $ads->body_type;
        $features       = explode(',', $ads->features);
        $reasons        = Reason::where('status', 1)->get();
        $tags           = AdTag::where('ad_id', $ads->id)->pluck('tag_id')->toArray();
        $ad_tags        = TagDescription::whereIn('tag_id', $tags)->where('language_id', 2)->get();
        $all_tags       = TagDescription::whereNotIn('tag_id', $tags)->where('language_id', 2)->get();
        $status_history = AdsStatusHistory::with('get_user')->where('ad_id', $id)->where('type', 'car')->get();
        $ad_history     = PostsHistory::where('ad_id', $id)->where('type', 'car')->get();
        return view('admin.ads.ad_details', compact('ads', 'ads_images', 'ads_colors', 'ads_city', 'ads_model', 'ads_maker', 'ads_version', 'ads_bodyType', 'features', 'languages', 'reasons', 'ad_tags', 'all_tags', 'status_history', 'ad_history'));
    }

    //
    public function index()
    {
        $ads = Ad::all();
        return view('admin.ads.index', compact('ads'));
    }

    public function approveAd(Request $request)
    {

        $ad = Ad::find($request->id);
        $old_status = $ad->status;
        $customer_account = CustomerAccount::where('ad_id', $ad->id)->where('type', 'car_ad')->where('status', 1)->orderBy('id', 'desc')->first();
        $check_des = $ad->ads_description()->count();
        if ($check_des < 3) {
            return response()->json(['des' => false]);
        }
        // dd($ad);
        //
        $ad->status = 1;
        if ($customer_account !== null) {
            $start = Carbon::now();
            $start->addDays($customer_account->number_of_days);
            $active_until = $start->endOfDay()->toDateTimeString();

            $ad->active_until = $active_until;
        }else{
            $start = Carbon::now();
            $start->addDays(30);
            $active_until = $start->endOfDay()->toDateTimeString();

            $ad->active_until = $active_until; 
        }

        $ad->save();
        $new_status = $ad->status;

        if ($old_status != $new_status) {
            $new_history = new AdsStatusHistory;
            $new_history->user_id = Auth::user()->id;
            $new_history->usertype = 'staff';
            $new_history->ad_id = $ad->id;
            $new_history->type = 'car';
            $new_history->status = $new_history->ads_status($old_status);
            $new_history->new_status = $new_history->ads_status($new_status);
            $new_history->save();
        }
        $data = [
            'poster_name' => $ad->customer->customer_company,
            'title'       => @$ad->maker->title . ' ' . @$ad->model->name . ' ' . @$ad->year,
            'id'      => $ad->id
        ];

        $emailType = EmailType::where('slug', 'ad_approved')->first();
        $templatee = EmailTemplate::where('type', $emailType->id)->first();
        // dd($templatee);  
        $template = EmailTemplateDescription::where('email_template_id', $templatee->id)->where('language_id', @$ad->customer->language_id)->first();
        // dd($template);
        Mail::to($ad->customer->customer_email_address)->send(new CarAd($data, $template));

        return response()->json([
            "success" => true,  'url' => url('admin/ad-details/' . $ad->id)
        ]);
    }

    public function adminDeleteTag(Request $request)
    {
        $tag     = TagDescription::where('tag_id', $request->tag_id)->where('language_id', 2)->first();
        $ad_tags = AdTag::where('ad_id', $request->ad_id)->where('tag_id', $request->tag_id)->delete();
        $history = new PostsHistory;
        $history->user_id = Auth::user()->id;
        $history->username = Auth::user()->name;
        $history->ad_id = $request->ad_id;
        $history->column_name = 'Tag';
        $history->status = $tag->name;
        $history->new_status = 'DELETED';
        $history->type = 'car';
        $history->save();
        return response()->json(['success' => true]);
    }

    public function adminAddTags(Request $request)
    {
        if ($request->all_tags_id != '') {
            foreach ($request->all_tags_id as $key => $value) {
                # code...
                $ad_tags = new AdTag;
                $ad_tags->ad_id = $request->ad_id;
                $ad_tags->tag_id = $value;
                $ad_tags->save();
            }
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function addToPending(Request $request)
    {
        // dd($request->id);

        $ad = Ad::find($request->id);
        $old_status = $ad->status;
        $ad->status = 0;
        $ad->save();
        $new_status = $ad->status;

        if ($old_status != $new_status) {
            $new_history = new AdsStatusHistory;

            $new_history->user_id = Auth::user()->id;
            $new_history->usertype = 'staff';
            $new_history->ad_id = $ad->id;
            $new_history->type = 'car';
            $new_history->status = $new_history->ads_status($old_status);
            $new_history->new_status = $new_history->ads_status($new_status);
            $new_history->save();
        }
        return response()->json([
            "success" => true,  'url' => url('admin/unpaid-ads')
        ]);
    }

    public function addToPendingSparePart(Request $request)
    {
        $ad = SparePartAd::find($request->id);
        $old_status = $ad->status;
        $ad->status = 0;
        $ad->save();

        $new_history = new AdsStatusHistory;
        $new_history->user_id = Auth::guard('customer')->user()->id;
        $new_history->ad_id = $ad->id;
        $new_history->type = 'sparepart';
        $new_history->status = $new_history->ads_status($old_status);
        $new_history->new_status = $new_history->ads_status($ad->status);;
        $new_history->save();
        return response()->json([
            "success" => true,  'url' => url('admin/unpaid-spareparts')
        ]);
    }

    public function notApproveAd(Request $request)
    {
        AdMsg::where('ad_id', $request->msg_ad_id)->delete(); // delete

        $reasons = $request->reason;
        foreach ($reasons as $res) {
            $ad_message = new AdMsg;
            $ad_message->user_id = Auth::user()->id;
            $ad_message->ad_id = $request->msg_ad_id;
            $ad_message->reason_id = $res;
            $ad_message->save();
        }


        $data = array();
        $ad = Ad::find($request->msg_ad_id);
        $old_status = $ad->status;
        $ad->status = 3;
        $ad->save();

        $new_status = $ad->status;

        if ($old_status != $new_status) {
            $new_history = new AdsStatusHistory;
            $new_history->user_id = Auth::user()->id;
            $new_history->usertype = 'staff';
            $new_history->ad_id = $ad->id;
            $new_history->type = 'car';
            $new_history->status = $new_history->ads_status($old_status);
            $new_history->new_status = $new_history->ads_status($new_status);
            $new_history->save();
        }


        $emailType = EmailType::where('slug', 'ad_not_approved')->first();
        $template = EmailTemplate::where('type', $emailType->id)->first();
        $template = EmailTemplateDescription::where('email_template_id', $template->id)->where('language_id',  $ad->customer->language_id)->first();
        $not_approved_reasons = ReasonsDescription::whereIn('reason_id', $request->reason)->where('language_id', $ad->customer->language_id)->get();

        $all_res = '';
        foreach ($not_approved_reasons as $npr) {
            $all_res .= '<li>' . @$npr->title . '</li>';
        }
        $data = [
            'name' => @$ad->customer->customer_company,
            'ad_title' => @$ad->maker->title,
            'reason' => @$all_res,
        ];
        Mail::to($ad->customer->customer_email_address)->send(new AdMessage($data, $template));

        return redirect('admin/ad-details/' . $ad->id);
    }

    public function approveSpAd(Request $request)
    {
        $customer_account        = CustomerAccount::where('ad_id', $request->id)->where('type', 'sparepart_ad')->where('status','!=', 2)->orderBy('id','DESC')->first();
        if (!empty($customer_account) && $customer_account->debit < $customer_account->paid_amount) {

            return response()->json([
                "success" => false,  'url' => ''
            ]);
        }
        
        $sp_ad                   = SparePartAd::find($request->id);
        $old_status              = $sp_ad->status;
        $sp_ad->status           = 1;

        if ($customer_account !== null) {
            $start = Carbon::now();
            $start->addDays($customer_account->number_of_days);
            $active_until = $start->endOfDay()->toDateTimeString();

            $sp_ad->active_until = $active_until;
        }else{
           $start = Carbon::now();
            $start->addDays(30)->format('Y-m-d');
            $active_until = $start->endOfDay()->toDateTimeString();

            $sp_ad->active_until = $active_until; 
        }
        
        $sp_ad->save();

        $new_history             = new AdsStatusHistory;
        $new_history->user_id    = Auth::user()->id;
        $new_history->usertype   = 'staff';
        $new_history->ad_id      = $sp_ad->id;
        $new_history->type       = 'sparepart';
        $new_history->status     = $new_history->ads_status($old_status);
        $new_history->new_status = $new_history->ads_status($sp_ad->status);
        $new_history->save();

        $data = [
            'id' => $sp_ad->id,
            'poster_name' => $sp_ad->get_customer->customer_company,
            'title'       => @$sp_ad->get_sp_ad_title($sp_ad->id, $sp_ad->get_customer->language_id)
        ];

        $templatee = EmailTemplate::where('type', 2)->first();
        $template  = EmailTemplateDescription::where('email_template_id', $templatee->id)->where('language_id', @$sp_ad->get_customer->language_id)->first();
        Mail::to($sp_ad->get_customer->customer_email_address)->send(new SpartPartAd($data, $template));

        return response()->json([
            "success" => true,  'url' => url('admin/sp-part-ad-detail/' . $sp_ad->id)
        ]);
    }
    public function makependingSpAd(Request $request)
    {
        $sp_ad = SparePartAd::find($request->id);
        $old_status = $sp_ad->status;
        $sp_ad->status = 0;
        $sp_ad->save();

        $new_history = new AdsStatusHistory;
        $new_history->user_id = Auth::user()->id;
        $new_history->usertype = 'staff';
        $new_history->ad_id = $sp_ad->id;
        $new_history->type = 'sparepart';
        $new_history->status = $new_history->ads_status($old_status);
        $new_history->new_status = $new_history->ads_status($sp_ad->status);
        $new_history->save();

        return response()->json([
            "success" => true,  'url' => url('admin/parts-ads-list/pending-ads')
        ]);
    }
    public function notApproveSpAd(Request $request)
    {

        SparepartsAdsMessage::where('spare_parts_ads_id', $request->msg_sp_ad_id)->delete();

        $reasons = $request->reason;
        foreach ($reasons as $res) {
            $ad_message = new SparepartsAdsMessage;
            $ad_message->user_id = Auth::user()->id;
            $ad_message->spare_parts_ads_id = $request->msg_sp_ad_id;
            $ad_message->reason_id = $res;
            $ad_message->save();
        }

        $data = array();

        $ad = SparePartAd::find($request->msg_sp_ad_id);
        $old_status = $ad->status;
        $ad->status = 3;
        $ad->save();

        $new_status = $ad->status;

        if ($old_status != $new_status) {
            $new_history = new AdsStatusHistory;
            $new_history->user_id = Auth::user()->id;
            $new_history->usertype = 'staff';
            $new_history->ad_id = $ad->id;
            $new_history->type = 'sparepart';
            $new_history->status = $new_history->ads_status($old_status);
            $new_history->new_status = $new_history->ads_status($ad->status);;
            $new_history->save();
        }

        $spare_part_title = $ad->get_sp_ad_title($ad->id, $ad->get_customer->language_id);
        $emailType = EmailType::where('slug', 'ad_not_approved')->first();
        $template = EmailTemplate::where('type', $emailType->id)->first();
        $template = EmailTemplateDescription::where('email_template_id', $template->id)->where('language_id', $ad->get_customer->language_id)->first();
        $not_approved_reasons = ReasonsDescription::whereIn('reason_id', $request->reason)->where('language_id', $ad->get_customer->language_id)->get();

        $all_res = '';
        foreach ($not_approved_reasons as $npr) {
            $all_res .= '<li>' . @$npr->title . '</li>';
        }

        $data = [
            'name' => @$ad->get_customer->customer_company,
            'sp_ad_title' => @$spare_part_title,
            'reason' => @$all_res,
        ];

        Mail::to($ad->get_customer->customer_email_address)->send(new SpAdMsgMail($data, $template));
        return redirect('admin/parts-ads-list/not-approved-ads');
    }

    public function CarAdsList($status)
    {
        $page_title = '';
        if ($status == 'pending-ads') {
            $ads = Ad::where('status', 0)->orderBy('updated_at', 'desc')->get();
            $page_title = 'Pending';
        } else if ($status == 'not-approved-ads') {
            $ads = Ad::where('status', 3)->orderBy('updated_at', 'desc')->get();
            $page_title = 'Not Approved';
        } else if ($status == 'active-ads') {
            $ads = Ad::where('status', 1)->orderBy('updated_at', 'desc')->get();
            $page_title = 'Active';
        } else if ($status == 'remove-ads') {
            $ads = Ad::where('status', 2)->orderBy('updated_at', 'desc')->get();
            $page_title = 'Removed';
        } else if ($status == 'unpaid-ads') {
            $ads = Ad::where('status', 5)->has('is_paid_ad')->orderBy('updated_at', 'desc')->get();
            $page_title = 'UnPaid';
        }

        return view('admin.ads.listing', compact('ads', 'page_title', 'status'));
    }

    public function PartsAdsList($status)
    {
        $page_title = '';
        if ($status == 'pending-ads') {
            $ads = SparePartAd::where('status', 0)->orderBy('updated_at', 'desc')->get();
            $page_title = 'Pending';
        } else if ($status == 'not-approved-ads') {
            $ads = SparePartAd::where('status', 3)->orderBy('updated_at', 'desc')->get();
            $page_title = 'Not Approved';
        } else if ($status == 'active-ads') {
            $ads = SparePartAd::where('status', 1)->orderBy('updated_at', 'desc')->get();
            $page_title = 'Active';
        } else if ($status == 'remove-ads') {
            $ads = SparePartAd::where('status', 2)->orderBy('updated_at', 'desc')->get();
            $page_title = 'Removed';
        } else if ($status == 'unpaid-ads') {
            $ads = SparePartAd::where('status', 5)->has('is_paid_ad')->orderBy('updated_at', 'desc')->get();
            $page_title = 'UnPaid';
        }

        return view('admin.spare-part-ads.listing', compact('ads', 'page_title', 'status'));
    }

    public function pending()
    {
        $ads = Ad::where('status', 0)->orderBy('updated_at', 'desc')->get();
        return view('admin.ads.pending', compact('ads'));
    }

    public function unPaidAds()
    {
        $ads = Ad::where('status', 5)->has('is_paid_ad')->get();
        // dd($ads[0]->country);
        return view('admin.ads.unpaid', compact('ads'));
    }

    public function unPaidSpareParts()
    {
        $ads = SparePartAd::where('status', 5)->has('is_paid_ad')->get();
        // dd($ads[0]->country);
        return view('admin.spare-part-ads.unpaid', compact('ads'));
    }

    public function notApprovedAdslist()
    {
        $ads = Ad::where('status', 3)->get();
        // dd($ads);
        return view('admin.ads.not-approved', compact('ads'));
    }

    public function notApprovedSpAdslist()
    {
        $ads = SparePartAd::where('status', 3)->get();
        return view('admin.spare-part-ads.not-approved', compact('ads'));
    }

    public function notApprovedAdDetail($id)
    {
        $ads = Ad::find($id);
        $languages = Language::all();
        $ads_images = $ads->ads_images;
        $ads_colors = $ads->color;
        $ads_city   = $ads->city;
        $ads_model  = $ads->model;
        $ads_maker  = $ads->maker;
        $ads_version  = $ads->versions;
        $ads_bodyType  = $ads->body_type;
        $features    = explode(',', $ads->features);
        $tags    = AdTag::where('ad_id', $ads->id)->pluck('tag_id')->toArray();
        $ad_tags     = TagDescription::whereIn('tag_id', $tags)->where('language_id', 2)->get();
        $all_tags     = TagDescription::whereNotIn('tag_id', $tags)->where('language_id', 2)->get();
        return view('admin.ads.not-approved-detail', compact('ads', 'ads_images', 'ads_colors', 'ads_city', 'ads_model', 'ads_maker', 'ads_version', 'ads_bodyType', 'features', 'languages', 'ad_tags', 'all_tags'));
    }

    public function notApprovedSpAdDetail($id)
    {
        // dd($id);
        $ads = SparePartAd::find($id);
        // dd($ads);
        $languages = Language::all();
        $ads_images = $ads->ads_images;
        $ads_colors = $ads->color;
        $ads_city   = $ads->city;
        $ads_model  = $ads->model;
        $ads_maker  = $ads->maker;
        $ads_version  = $ads->versions;
        $ads_bodyType  = $ads->body_type;
        $features    = explode(',', $ads->features);
        $spare_parts_imagee = $ads->spare_parts_images;
        return view('admin.spare-part-ads.not-approved-detail', compact('suggessions', 'ads', 'ads_images', 'ads_colors', 'ads_city', 'ads_model', 'ads_maker', 'ads_version', 'ads_bodyType', 'features', 'seller_comments', 'languages', 'spare_parts_imagee'));
    }

    public function storeDeatil(Request $request)
    {
        // dd($request->all());
        $languages = Language::all();
        foreach ($request->except('_token', 'ad_id') as $key => $value) {
            if ($key != null) {
                $language_id = explode('_', $key);
                // dd($language_id[1]);
                $ad_desc = AdDescription::where('ad_id', $request->ad_id)->where('language_id', $language_id[1])->first();
                $old_des = $ad_desc != null ? $ad_desc->description : '';
                if ($ad_desc == null) {
                    $ad_desc = new AdDescription;
                }
                $ad_desc->ad_id = $request->ad_id;
                $ad_desc->description = $value;
                $ad_desc->language_id = $language_id[1];
                $ad_desc->save();

                if ($old_des != null && $value != '' && $old_des != $value) {
                    $history = new PostsHistory;
                    $history->user_id = Auth::user()->id;
                    $history->usertype = 'staff';
                    $history->username = Auth::user()->name;
                    $history->ad_id = $request->ad_id;
                    if ($language_id[1] == 1) {
                        $history->column_name = 'Description(Estonia)';
                    } else if ($language_id[1] == 2) {
                        $history->column_name = 'Description(English)';
                    } else if ($language_id[1] == 3) {
                        $history->column_name = 'Description(Russia)';
                    }
                    $history->status = $old_des;
                    $history->new_status = $ad_desc->description;
                    $history->type = 'car';
                    $history->save();
                }
            }
        }
        return redirect()->back();
        # code...
    }

    public function makeAdsTranslate(Request $request)
    {
        $car_ad      = Ad::find($request->id);
        $languages     = Language::all();
        $dec_old_value = '';
        $dec_new_value = '';

        $title_old_value = '';
        $title_new_value = '';


        foreach ($languages as $language) {
            $description = @$car_ad->get_ad_description($car_ad->id, $language->id)->description;
            if (!empty($description)) {
                $notEmptydescription = $car_ad->get_ad_description($car_ad->id, $language->id)->description;
                $dec_old_value = $language->language_title;
            }
        }

        foreach ($languages as $language) {
            $description = trim(@$car_ad->get_ad_description($car_ad->id, $language->id)->description);
            $code =  $language->language_code;
            if (empty($description)) {
                $description = GoogleTranslate::translate($notEmptydescription, $code);
                $description = $description['translated_text'];

                $car_ad_desc = AdDescription::updateOrCreate(
                    ['ad_id' => $car_ad->id, 'language_id' => $language->id],
                    ['description' => $description]
                );

                $dec_new_value .= $language->language_title . ',';
            }
        }

        if ($dec_old_value != '' && $dec_new_value != '') {
            $history              = new PostsHistory;
            $history->user_id     = Auth::user()->id;
            $history->usertype    = 'staff';
            $history->username    = Auth::user()->name;
            $history->ad_id       = $car_ad->id;
            $history->column_name = 'Description (Google Translate)';
            $history->status      = $dec_old_value;
            $history->new_status  = $dec_new_value;
            $history->type        = 'car';
            $history->save();
        }


        return response()->json([
            "success" => true,  'url' => url('admin/ad-details/' . $car_ad->id)
        ]);
    }

    public function active()
    {
        $ads = Ad::where('status', 1)->orderBy('updated_at', 'DESC')->get();
        return view('admin.ads.active', compact('ads'));
    }

    public function makeModelVersions()
    {
        $records = Makemodelversion::all();
        return view('admin.ads.make_model_versions', compact('records'));
    }

    public function deleteMakeModelVersion(Request $request)
    {
        // dd($request->all());
        $del = Makemodelversion::where('id', $request->id)->delete();

        return Redirect::back()->with('deleted', 'Record Deleted Successfully!');
    }

    public function remove()
    {
        $ads = Ad::where('status', 2)->orderBy('updated_at', 'DESC')->get();
        return view('admin.ads.remove', compact('ads'));
    }

    public function soldout()
    {
        $ads = Ad::where('status', 3)->orderBy('updated_at', 'DESC')->get();
        return view('admin.ads.soldout', compact('ads'));
    }

    public function rejected()
    {
        $ads = Ad::where('status', 4)->orderBy('updated_at', 'DESC')->get();
        return view('admin.ads.rejected', compact('ads'));
    }

    public function indexOfParts()
    {
        $ads = SparePartAd::all();
        return view('admin.spare-part-ads.index', compact('ads'));
    }

    public function approveAdOfParts(Request $request)
    {
        //dd($request->all());

        $ad = SparePartAd::find($request->ad_id);
        $ad->status = 2;            //status 2 because we need to directly publish this ad 
        $ad->save();

        $customer_name = $ad->get_customer->customer_company;
        $customer_email = $ad->get_customer->customer_email_address;


        $data = [

            'customer_name' => $customer_name,
        ];

        $template = EmailTemplate::where('type', 'publish-spare-part-ad')->first();
        //dd($template);
        Mail::to($customer_email)->send(new PublishSparePartAd($data, $template));

        //
        return response()->json([
            "success" => true,
        ]);
    }

    public function pendingOfParts()
    {
        $ads = SparePartAd::where('status', 0)->orderBy('updated_at', 'DESC')->get();
        return view('admin.spare-part-ads.pending', compact('ads'));
    }

    public function pendingOfPartDetail($id)
    {
        $ads = SparePartAd::find($id);
        // dd($ads->spare_parts_images);
        $languages = Language::all();
        $spare_parts_imagee = $ads->spare_parts_images;
        $reasons = Reason::where('status', 1)->get();
        $status_history = AdsStatusHistory::with('get_user')->where('ad_id', $id)->where('type', 'sparepart')->orderBy('updated_at', 'DESC')->get();
        $ad_history = PostsHistory::where('ad_id', $id)->where('type', 'sparepart')->orderBy('updated_at', 'DESC')->get();
        // dd($spare_parts_image);

        return view('admin.spare-part-ads.pending_detail', compact('ads', 'languages', 'spare_parts_imagee', 'reasons', 'status_history', 'ad_history'));
    }

    public function SpPartDetail($id)
    {
        $ads = SparePartAd::find($id);
        $languages = Language::all();
        $spare_parts_imagee = $ads->spare_parts_images;
        $reasons = Reason::where('status', 1)->get();
        $status_history = AdsStatusHistory::with('get_user')->where('ad_id', $id)->where('type', 'sparepart')->get();
        $ad_history = PostsHistory::where('ad_id', $id)->where('type', 'sparepart')->get();
        return view('admin.spare-part-ads.sp_part_detail', compact('ads', 'languages', 'spare_parts_imagee', 'reasons', 'status_history', 'ad_history'));
    }


    public function activeOfPartDetail($id)
    {
        $ads = SparePartAd::find($id);
        // dd($ads->spare_parts_images);
        $languages = Language::all();
        $spare_parts_imagee = $ads->spare_parts_images;

        return view('admin.spare-part-ads.active_detail', compact('ads', 'languages', 'spare_parts_imagee'));
    }

    public function removedOfPartDetail($id)
    {
        $ads = SparePartAd::find($id);
        // dd($ads->spare_parts_images);
        $languages = Language::all();
        $spare_parts_imagee = $ads->spare_parts_images;

        return view('admin.spare-part-ads.removed_detail', compact('ads', 'languages', 'spare_parts_imagee'));
    }

    public function storeSpAdDetail(Request $request)
    {

        //dd($request->all());
        $languages = Language::all();
        foreach ($request->except('_token', 'sp_ad_id') as $key => $value) {
            if ($key != null) {
                $language_id = explode('_', $key);
                if ($language_id[0] == 'lang') {
                    $sp_ad_desc = SpAdDescription::where('spare_part_ad_id', $request->sp_ad_id)->where('language_id', $language_id[1])->first();
                    $old_des = $sp_ad_desc != null ? $sp_ad_desc->description : '';

                    if ($sp_ad_desc == null) {
                        $sp_ad_desc = new SpAdDescription;
                    }
                    $sp_ad_desc->spare_part_ad_id = $request->sp_ad_id;
                    $sp_ad_desc->description = $value;
                    $sp_ad_desc->language_id = $language_id[1];
                    $sp_ad_desc->save();

                    if ($old_des != null && $value != '' && $old_des != $value) {
                        $history = new PostsHistory;
                        $history->user_id = Auth::user()->id;
                        $history->usertype = 'staff';
                        $history->username = Auth::user()->name;
                        $history->ad_id = $request->sp_ad_id;
                        if ($language_id[1] == 1) {
                            $history->column_name = 'Description(Estonia)';
                        } else if ($language_id[1] == 2) {
                            $history->column_name = 'Description(English)';
                        } else if ($language_id[1] == 3) {
                            $history->column_name = 'Description(Russia)';
                        }
                        $history->status = $old_des;
                        $history->new_status = $value;
                        $history->type = 'sparepart';
                        $history->usertype = 'staff';
                        $history->save();
                    }
                } 
                else {

                    $sp_ad_title = SparePartAdTitle::where('spare_part_ad_id', $request->sp_ad_id)->where('language_id', $language_id[1])->first();
                    $old_title = $sp_ad_title != null ? $sp_ad_title->title : '';
                    if ($sp_ad_title == null) {
                        $sp_ad_title = new SparePartAdTitle;
                    }
                    $sp_ad_title->spare_part_ad_id = $request->sp_ad_id;
                    $sp_ad_title->title = $value;
                    $sp_ad_title->language_id = $language_id[1];
                    $sp_ad_title->save();

                    if ($old_title != null && $value != '' && $old_title != $value) {
                        $history = new PostsHistory;
                        $history->user_id = Auth::user()->id;
                        $history->usertype = 'staff';
                        $history->username = Auth::user()->name;
                        $history->ad_id = $request->sp_ad_id;
                        if ($language_id[1] == 1) {
                            $history->column_name = 'Title(Estonia)';
                        } else if ($language_id[1] == 2) {
                            $history->column_name = 'Title(English)';
                        } else if ($language_id[1] == 3) {
                            $history->column_name = 'Title(Russia)';
                        }

                        $history->status = $old_title;
                        $history->new_status = $value;
                        $history->type = 'sparepart';
                        $history->usertype = 'staff';
                        $history->save();
                    }
                }
            }
        }
        return redirect()->back();
    }

    public function makeSparepartsTranslate(Request $request)
    {
        $sp_ad       = SparePartAd::find($request->id);
        $languages     = Language::all();
        $dec_old_value = '';
        $dec_new_value = '';

        $title_old_value = '';
        $title_new_value = '';


        foreach ($languages as $language) {
            $description = @$sp_ad->get_sp_ad_description($sp_ad->id, $language->id)->description;
            if (!empty($description)) {
                $notEmptydescription = $sp_ad->get_sp_ad_description($sp_ad->id, $language->id)->description;
                $dec_old_value = $language->language_title;
            }

            //title
            $title = @$sp_ad->get_sp_ad_title($sp_ad->id, $language->id);
            if (!empty($title)) {
                $notEmptytitle = $sp_ad->get_sp_ad_title($sp_ad->id, $language->id);
                $title_old_value = $language->language_title;
            }
        }

        foreach ($languages as $language) {
            $description = trim(@$sp_ad->get_sp_ad_description($sp_ad->id, $language->id)->description);
            $code =  $language->language_code;
            if (empty($description)) {
                $description = GoogleTranslate::translate($notEmptydescription, $code);
                $description = $description['translated_text'];

                $sp_ad_desc = SpAdDescription::updateOrCreate(
                    ['spare_part_ad_id' => $sp_ad->id, 'language_id' => $language->id],
                    ['description' => $description]
                );

                $dec_new_value .= $language->language_title . ',';
            }
            $title = trim(@$sp_ad->get_sp_ad_title($sp_ad->id, $language->id));
            $code =  $language->language_code;
            if (empty($title)) {
                $title = GoogleTranslate::translate($notEmptytitle, $code);
                $title = $title['translated_text'];

                $sp_ad_title = SparePartAdTitle::updateOrCreate(
                    ['spare_part_ad_id' => $sp_ad->id, 'language_id' => $language->id],
                    ['title' => $title]
                );
            }
        }

        if ($dec_old_value != '' && $dec_new_value != '') {
            $history = new PostsHistory;
            $history->user_id = Auth::user()->id;
            $history->usertype = 'staff';
            $history->username = Auth::user()->name;
            $history->ad_id = $sp_ad->id;
            $history->column_name = 'Description (Google Translate)';
            $history->status = $dec_old_value;
            $history->new_status = $dec_new_value;
            $history->type = 'sparepart';
            $history->save();
        }

        if ($title_old_value != '' && $title_new_value != '') {
            $history = new PostsHistory;
            $history->user_id = Auth::user()->id;
            $history->usertype = 'staff';
            $history->username = Auth::user()->name;
            $history->ad_id = $sp_ad->id;
            $history->column_name = 'Title (Google Translate)';
            $history->status = $title_old_value;
            $history->new_status = $title_new_value;
            $history->type = 'sparepart';
            $history->save();
        }


        return response()->json([
            "success" => true,  'url' => url('admin/sp-part-ad-detail/' . $sp_ad->id)
        ]);
    }


    public function activeOfParts()
    {
        $ads = SparePartAd::where('status', 1)->get();
        return view('admin.spare-part-ads.active', compact('ads'));
    }

    public function removeOfParts()
    {
        $ads = SparePartAd::where('status', 2)->get();
        return view('admin.spare-part-ads.remove', compact('ads'));
    }

    public function MakeAdFeatured($id)
    {
        $ads = explode(',', $id);
        foreach ($ads as $id) {

            $ads = Ad::where('id', $id)->first();

            $ads->is_featured = "true";
            $ads->save();
        }
        return response()->json([
            "success" => true,
        ]);
    }

    public function MakeAdUnFeatured($id)
    {
        $ads = explode(',', $id);
        //dd($ads);
        foreach ($ads as $id) {

            $ads = Ad::where('id', $id)->first();

            $ads->is_featured = "false";
            $ads->save();
        }


        return response()->json([
            "success" => true,
        ]);
    }

    public function MakeAdPending($ad_id)
    {
        $ads = explode(',', $ad_id);
        //dd($ads);
        foreach ($ads as $id) {

            $ads = Ad::where('id', $id)->first();
            $old_status = $ads->status;

            $ads->status = 0;
            $ads->save();
            $new_status = $ads->status;

            if ($old_status != $new_status) {
                $new_history = new AdsStatusHistory;

                $new_history->user_id = Auth::user()->id;
                $new_history->usertype = 'staff';
                $new_history->ad_id = $ads->id;
                $new_history->type = 'car';
                $new_history->status = $new_history->ads_status($old_status);
                $new_history->new_status = $new_history->ads_status($new_status);
                $new_history->save();
            }
        }


        return response()->json([
            "success" => true,
            "url" => url('admin/active-ads'),
        ]);
    }

    public function MakeAdRemoved($ad_id)
    {
        $ads = explode(',', $ad_id);
        foreach ($ads as $id) {

            $ads = Ad::where('id', $id)->first();

            $ads->status = 2;
            $ads->save();
        }

        return response()->json([
            "success" => true,
        ]);
    }

    public function MakeAdSoldOut($ad_id)
    {
        $ads = explode(',', $ad_id);
        foreach ($ads as $id) {

            $ads = Ad::where('id', $id)->first();

            $ads->status = 3;
            $ads->save();
        }

        return response()->json([
            "success" => true,
        ]);
    }

    public function MakeAdRejected($ad_id)
    {
        $ads = explode(',', $ad_id);
        foreach ($ads as $id) {
            $ads = Ad::where('id', $id)->first();

            $ads->status = 4;
            $ads->save();
        }

        return response()->json([
            "success" => true,
        ]);
    }

  

    public function activeAdDetail($id)
    {
        $ads = Ad::find($id);
        // dd($ads->is_featured);
        $languages = Language::all();
        $ads_images = $ads->ads_images;
        $ads_colors = $ads->color;
        $ads_city   = $ads->city;
        $ads_model  = $ads->model;
        $ads_maker  = $ads->maker;
        $ads_version  = $ads->versions;
        $ads_bodyType  = $ads->versions->bodyTypes;
        $features    = explode(',', $ads->features);
        $tags    = AdTag::where('ad_id', $ads->id)->pluck('tag_id')->toArray();
        $ad_tags     = TagDescription::whereIn('tag_id', $tags)->where('language_id', 2)->get();
        $all_tags     = TagDescription::whereNotIn('tag_id', $tags)->where('language_id', 2)->get();
        return view('admin.ads.active_ad_details', compact('ads', 'ads_images', 'ads_colors', 'ads_city', 'ads_model', 'ads_maker', 'ads_version', 'ads_bodyType', 'features', 'languages', 'ad_tags', 'all_tags'));
    }

    public function removeAdDetail($id)
    {
        $ads = Ad::find($id);
        // dd($ads->is_featured);
        $languages = Language::all();
        $ads_images = $ads->ads_images;
        $ads_colors = $ads->color;
        $ads_city   = $ads->city;
        $ads_model  = $ads->model;
        $ads_maker  = $ads->maker;
        $ads_version  = $ads->versions;
        $ads_bodyType  = $ads->body_type;
        $features    = explode(',', $ads->features);
        $tags    = AdTag::where('ad_id', $ads->id)->pluck('tag_id')->toArray();
        $ad_tags     = TagDescription::whereIn('tag_id', $tags)->where('language_id', 2)->get();
        $all_tags     = TagDescription::whereNotIn('tag_id', $tags)->where('language_id', 2)->get();
        return view('admin.ads.removed_ad_detail', compact('ads', 'ads_images', 'ads_colors', 'ads_city', 'ads_model', 'ads_maker', 'ads_version', 'ads_bodyType', 'features', 'languages', 'ad_tags', 'all_tags'));
    }

    public function featuredRequests()
    {
        $featured_requests = FeaturedRequest::all();
        return view('admin.featured_requests', compact('featured_requests'));
    }

    public function customersAccount()
    {
        $customers_accounts = CustomerAccount::all();
        return view('admin.customers_account', compact('customers_accounts'));
    }

    public function pendingInvoices()
    {
        $customers_accounts = CustomerAccount::where('status', 0)->orderBy('id', 'desc')->get();
        $status = 0;
        return view('admin.pending_invoices', compact('customers_accounts', 'status'));
    }

    public function unpaidInvoices()
    {
        $customers_accounts = CustomerAccount::where('status', 2)->orderBy('id', 'desc')->get();
        $status = 0;
        return view('admin.unpaid_invoices', compact('customers_accounts', 'status'));
    }

    public function InvoiceDetail($id)
    {
        $invoice = CustomerAccount::where('id', $id)->first();
        return view('admin.invoice_detail', compact('invoice'));
    }

    public function approvedInvoices()
    {
        $customers_accounts = CustomerAccount::where('status', 1)->orderBy('updated_at', 'desc')->get();
        $status = 1;
        return view('admin.approved_invoices', compact('customers_accounts', 'status'));
    }

    public function approveFeatureRequest(Request $request)
    {
        // dd($request->all());

        $featured_request = FeaturedRequest::find(@$request->id);
        $account = new CustomerAccount;
        $account->customer_id = @$featured_request->user_id;
        $account->debit = $featured_request->paid_amount;
        if (@$featured_request->type == 'car') {
            $account->detail = 'Amount Paid For Featuring ' . @$featured_request->ad->maker->title . ' ' . @$featured_request->ad->model->name . ' ' . @$featured_request->ad->versions->name . ' ' . @$featured_request->ad->year . ' Car';
            @$featured_request->ad->is_featured = true;
            @$featured_request->ad->save();
        } else if (@$featured_request->type == 'spare part') {
            @$account->detail = 'Amount Paid For Featuring ' . @$featured_request->sparepart->title . ' Spare Part';
            @$featured_request->sparepart->is_featured = true;
            @$featured_request->sparepart->save();
        } else if (@$featured_request->type == 'offer service') {
            @$featured_request->detail = 'Amount Paid For Featuring ' . @$featured_request->offerservice->primary_service->title . ' Offer Service';
            @$featured_request->offerservice->is_featured = true;
            @$featured_request->offerservice->save();
        }
        $account->status = 1;
        $account->save();

        @$featured_request->status = 1;
        @$featured_request->save();

        return response()->json(['success' => true]);
    }

    public function approveAccountRequest(Request $request)
    {
        $account = CustomerAccount::find(@$request->id);
        
        if (@$account->ad_id === null) {
            @$account->status = 1;
            @$account->approved_date = Carbon::now();
            @$account->save();
            return response()->json(['success' => true]);
        } 
        else if ($account->type == 'car_ad') {
            $ad = Ad::find(@$account->ad_id);
            $old_status = $ad->status;

            $account->debit = @$account->paid_amount;
            $account->credit = @$account->paid_amount;
            $account->status = 1;
            $account->approved_date = Carbon::now();
            $account->save();

            $ad->status = 0;
            $ad->save();

            $new_history = new AdsStatusHistory;
            $new_history->user_id = Auth::user()->id;
            $new_history->usertype = 'staff';
            $new_history->ad_id = $ad->id;
            $new_history->type = 'car';
            $new_history->status = $new_history->ads_status($old_status);
            $new_history->new_status = $new_history->ads_status($ad->status);
            $new_history->save();

            $pay_data = [
                'poster_name' => @$ad->customer->customer_company,
                'invoice_id' => @$request->id,
                'title' => @$ad->title,
            ];

            $pay_templatee = EmailTemplate::where('type', 15)->first(); // email for payment recieved
            $pay_template  = EmailTemplateDescription::where('email_template_id', $pay_templatee->id)->where('language_id', @$ad->customer->language_id)->first();
            Mail::to($ad->customer->customer_email_address)->send(new SparePartAdPayRecieved($pay_data, $pay_template));

            return response()->json(['success' => true]);
        } 
        else if ($account->type == 'sparepart_ad') {
            $ad = SparePartAd::find(@$account->ad_id);
            $old_status = $ad->status;

            $account->debit = @$account->paid_amount;
            $account->credit = @$account->paid_amount;
            $account->status = 1;
            $account->save();

            $ad->status = 0;
            $ad->save();

            $new_history = new AdsStatusHistory;
            $new_history->user_id = Auth::user()->id;
            $new_history->usertype = 'staff';
            $new_history->ad_id = $ad->id;
            $new_history->type = 'sparepart';
            $new_history->status = $new_history->ads_status($old_status);
            $new_history->new_status = $new_history->ads_status($ad->status);
            $new_history->save();

            $pay_data = [
                'poster_name' => @$ad->customer->customer_company,
                'invoice_id' => @$request->id,
                'title' => @$ad->title,
            ];

            $pay_templatee = EmailTemplate::where('type', 15)->first(); // email for payment recieved
            $pay_template  = EmailTemplateDescription::where('email_template_id', $pay_templatee->id)->where('language_id', @$ad->customer->language_id)->first();
            Mail::to($ad->customer->customer_email_address)->send(new SparePartAdPayRecieved($pay_data, $pay_template));

            return response()->json(['success' => true]);
        }
        else if ($account->type == 'offerservice_ad') {
            $ad = Services::find(@$account->ad_id);
            $old_status = $ad->status;

            $account->debit = @$account->paid_amount;
            $account->credit = @$account->paid_amount;
            $account->status = 1;
            $account->save();

            $ad->status = 0;
            $ad->save();

            $new_history = new AdsStatusHistory;
            $new_history->user_id = Auth::user()->id;
            $new_history->usertype = 'staff';
            $new_history->ad_id = $ad->id;
            $new_history->type = 'offerservice';
            $new_history->status = $new_history->ads_status($old_status);
            $new_history->new_status = $new_history->ads_status($ad->status);
            $new_history->save();

            $pay_data = [
                'poster_name' => @$ad->customer->customer_company,
                'invoice_id' => @$request->id,
                'title' => @$ad->title,
            ];

            $pay_templatee = EmailTemplate::where('type', 15)->first(); // email for payment recieved
            $pay_template  = EmailTemplateDescription::where('email_template_id', $pay_templatee->id)->where('language_id', @$ad->customer->language_id)->first();
            Mail::to($ad->customer->customer_email_address)->send(new SparePartAdPayRecieved($pay_data, $pay_template));

            return response()->json(['success' => true]);
        } 
        else {
            $start = Carbon::now();
            $start->addDays($account->number_of_days);
            $featured_until = $start->endOfDay()->toDateTimeString();

            if (@$account->type == 'car') {
                $ad = Ad::find(@$account->ad_id);
            } else if (@$account->type == 'sparepart') {
                $ad = SparePartAd::find(@$account->ad_id);
            } else if (@$account->type == 'offerservice') {
                $ad = Services::find(@$account->ad_id);
            }

            $account->status = 1;
            $account->approved_date = Carbon::now();
            $account->save();

            $ad->is_featured = 'true';
            $ad->feature_expiry_date = @$featured_until;
            $ad->save();

            return response()->json(['success' => true]);
        }
    }

    public function exportPDF(Request $request)
    {
        $account = CustomerAccount::find(@$request->invoice_number);
        $user = Customer::where('id', @$account->customer_id)->first();

        // dd($account);
        $pdf = PDF::loadView('users.invoice', compact('account', 'user'));

        // making pdf name starts
        $makePdfName = 'invoice';
        return $pdf->download($makePdfName . '.pdf');
    }
}