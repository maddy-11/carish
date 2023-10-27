<?php

namespace App\Http\Controllers\Admin;

use App\EmailTemplate;
use App\EmailTemplateDescription;
use App\Http\Controllers\Controller;
use App\Mail\PublishOfferServiceAd;
use App\Mail\ServicesMsgMail;
use App\Models\AdsStatusHistory;
use App\Models\Cars\Make;
use App\Models\Customers\PrimaryService;
use App\Models\Customers\SubService;
use App\Models\Language;
use App\Models\PrimaryServicesDescription;
use App\Models\ServiceDescription;
use App\Models\Services;
use App\Models\SubServicesDescription;
use App\ServiceTitle;
use App\PostsHistory;
use App\ServiceDetail;
use App\ServiceMessage;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Mail;
use GoogleTranslate;
use App\Reason;
use App\ReasonsDescription;
use App\EmailType;
use App\Mail\OfferServiceMail;
use App\Models\Customers\CustomerAccount;
use Carbon\Carbon;

class ServiceManagementController extends Controller
{
       public function ServicesAdsList($status)
    {
        $page_title ='';
        if($status == 'pending-ads')
        {
            $ads = Services::where('status',0)->orderBy('updated_at','desc')->get();
            $page_title = 'Pending';
        }
        else if($status == 'not-approved-ads')
        {
            $ads = Services::where('status',3)->orderBy('updated_at','desc')->get();
            $page_title = 'Not Approved'; 
        }
        else if($status == 'active-ads')
        {
            $ads = Services::where('status',1)->orderBy('updated_at','desc')->get();
            $page_title = 'Active';
        }
        else if($status == 'remove-ads')
        {
            $ads = Services::where('status',2)->orderBy('updated_at','desc')->get();
            $page_title = 'Removed';
        }
        else if($status == 'unpaid-ads')
        {
            $ads = Services::where('status',5)->has('is_paid_ad')->orderBy('updated_at', 'desc')->get();
            $page_title = 'UnPaid';
        }

        return view('admin.services.listing',compact('ads','page_title','status'));
    }

    public function pending()
    {
        $pending_services = Services::where('status',0)->orderBy('updated_at','DESC')->get();

        return view('admin.services.pending',compact('pending_services'));
    }

    public function pendingServiceDetail($id)
    {
        // dd($id);
        $service = Services::find($id);
        $categories_id = ServiceDetail::where('service_id',$service->id)->where('category_id' , '<>' , 'null')->pluck('category_id')->unique()->toArray();
        $sub_services = SubService::whereIn('id',$categories_id)->where('status',1)->get();

        $sub_services_data = [];
        $cs_titles=[];

        foreach($sub_services as $sub_service) {
            
            $sub_categories_id = ServiceDetail::where('service_id',$service->id)->where('primary_service_id',$service->primary_service_id)->where('category_id',$sub_service->id)->pluck('sub_category_id')->toArray();
            if($sub_service->is_make==0)
            {
                $child_services = SubService::whereIn('id',$sub_categories_id)->where('status',1)->get();
                 foreach($child_services as $child_service) {
        
                $cs_titles[] = [
                    'cs_title' => $child_service->title,
                ];
            }
            }
            else
            {
                $child_makes = Make::whereIn('id',$sub_categories_id)->get();
                 foreach($child_makes as $child_make) {
        
                $cs_titles[] = [
                    'cs_title' => $child_make->title,
                ];
            }
            }

           

            $sub_services_data[] = [
                    'ps_title' => $sub_service->title,
                    'cs_titles' => $cs_titles,
                ];
            $cs_titles = [];
        }
        // dd($sub_services_data);
        $status_history = AdsStatusHistory::with('get_user')->where('ad_id',$id)->where('type','offerservice')->get();
        $ad_history = PostsHistory::where('ad_id',$id)->where('type','offerservice')->get();
        $languages = Language::all();
        return view('admin.services.pending-detail',compact('service' , 'languages','sub_services_data','status_history','ad_history'));

    }

    public function notApproveService(Request $request)
    {

         ServiceMessage::where('services_id',$request->msg_service_id)->delete();
       
        $reasons = $request->reason;
        foreach ($reasons as $res) {
            $ad_message = new ServiceMessage;
            $ad_message->user_id = Auth::user()->id;
            $ad_message->services_id = $request->msg_service_id;
            $ad_message->reason_id = $res;
            $ad_message->save();
        }

        $data = array();
        $service = Services::find($request->msg_service_id);
        $old_status = $service->status;
        $service->status = 3;
        $service->save();

        $new_status = $service->status;

        if($old_status != $new_status)
        {
            $new_history = new AdsStatusHistory;
            $new_history->user_id = Auth::user()->id;
            $new_history->usertype = 'staff';
            $new_history->ad_id = $service->id;
            $new_history->type = 'offerservice';
            $new_history->status = $new_history->ads_status($old_status);
            $new_history->new_status = $new_history->ads_status($new_status);
            $new_history->save();
        }

        $emailType = EmailType::where('slug','ad_not_approved')->first();
        $template = EmailTemplate::where('type',$emailType->id)->first();
        $template = EmailTemplateDescription::where('email_template_id' , $template->id)->where('language_id' , $service->get_customer->language_id)->first();

        $not_approved_reasons = ReasonsDescription::whereIn('reason_id',$request->reason)->where('language_id', $service->get_customer->language_id)->get();
        
        $all_res = '';
        foreach ($not_approved_reasons as $npr) {
            $all_res .= '<li>'.@$npr->title.'</li>';
        }
        $data = [
            'name' => @$service->get_customer->customer_company,
            'service_title' => @$service->get_service_ad_title($service->id,$service->get_customer->language_id)->title,
            'reason' => @$all_res,
        ];
        Mail::to($service->get_customer->customer_email_address)->send(new ServicesMsgMail($data, $template));

        return redirect('admin/services-ads-list/not-approved-ads');
    
        
    
    }

    public function ServiceDetail($id)
    {
        // dd($id);
        $service = Services::find($id);
        // dd($service);
        $categories_id = ServiceDetail::where('service_id',$service->id)->where('category_id' , '<>' , 'null')->pluck('category_id')->unique()->toArray();
        $sub_services = SubService::whereIn('id',$categories_id)->where('status',1)->get();

        $sub_services_data = [];
        $cs_titles=[];

        foreach($sub_services as $sub_service) {
            
            $sub_categories_id = ServiceDetail::where('service_id',$service->id)->where('primary_service_id',$service->primary_service_id)->where('category_id',$sub_service->id)->pluck('sub_category_id')->toArray();
            if($sub_service->is_make==0)
            {
                $child_services = SubService::whereIn('id',$sub_categories_id)->where('status',1)->get();
                 foreach($child_services as $child_service) {
        
                $cs_titles[] = [
                    'cs_title' => $child_service->title,
                ];
            }
            }
            else
            {
                $child_makes = Make::whereIn('id',$sub_categories_id)->get();
                 foreach($child_makes as $child_make) {
        
                $cs_titles[] = [
                    'cs_title' => $child_make->title,
                ];
            }
            }

           

            $sub_services_data[] = [
                    'ps_title' => $sub_service->title,
                    'cs_titles' => $cs_titles,
                ];
            $cs_titles = [];
        }
        $status_history = AdsStatusHistory::with('get_user')->where('ad_id',$id)->where('type','offerservice')->get();
        $ad_history = PostsHistory::where('ad_id',$id)->where('type','offerservice')->get();
        $languages = Language::all();
        $ads_images = $service->services_images;
        $reasons = Reason::where('status',1)->get();
        return view('admin.services.service-detail',compact('service' , 'languages','sub_services_data','status_history','ad_history','ads_images','reasons'));

    }


    public function activeServiceDetail($id)
    {
        // dd($id);
        $service = Services::find($id);
        // dd($service);
        $categories_id = ServiceDetail::where('service_id',$service->id)->where('category_id' , '<>' , 'null')->pluck('category_id')->unique()->toArray();
        $sub_services = SubService::whereIn('id',$categories_id)->where('status',1)->get();

        $sub_services_data = [];
        $cs_titles=[];

        foreach($sub_services as $sub_service) {
            
            $sub_categories_id = ServiceDetail::where('service_id',$service->id)->where('primary_service_id',$service->primary_service_id)->where('category_id',$sub_service->id)->pluck('sub_category_id')->toArray();
            if($sub_service->is_make==0)
            {
                $child_services = SubService::whereIn('id',$sub_categories_id)->where('status',1)->get();
                 foreach($child_services as $child_service) {
        
                $cs_titles[] = [
                    'cs_title' => $child_service->title,
                ];
            }
            }
            else
            {
                $child_makes = Make::whereIn('id',$sub_categories_id)->get();
                 foreach($child_makes as $child_make) {
        
                $cs_titles[] = [
                    'cs_title' => $child_make->title,
                ];
            }
            }

           

            $sub_services_data[] = [
                    'ps_title' => $sub_service->title,
                    'cs_titles' => $cs_titles,
                ];
            $cs_titles = [];
        }
        $languages = Language::all();
        return view('admin.services.active-detail',compact('service' , 'languages','sub_services_data'));

    }

    public function notApprovedServiceDetail($id)
    {
        // dd($id);
        $service = Services::find($id);
        // dd($service);
        $categories_id = ServiceDetail::where('service_id',$service->id)->where('category_id' , '<>' , 'null')->pluck('category_id')->unique()->toArray();
        $sub_services = SubService::whereIn('id',$categories_id)->where('status',1)->get();

        $sub_services_data = [];
        $cs_titles=[];

        foreach($sub_services as $sub_service) {
            
            $sub_categories_id = ServiceDetail::where('service_id',$service->id)->where('primary_service_id',$service->primary_service_id)->where('category_id',$sub_service->id)->pluck('sub_category_id')->toArray();
            if($sub_service->is_make==0)
            {
                $child_services = SubService::whereIn('id',$sub_categories_id)->where('status',1)->get();
                 foreach($child_services as $child_service) {
        
                $cs_titles[] = [
                    'cs_title' => $child_service->title,
                ];
            }
            }
            else
            {
                $child_makes = Make::whereIn('id',$sub_categories_id)->get();
                 foreach($child_makes as $child_make) {
        
                $cs_titles[] = [
                    'cs_title' => $child_make->title,
                ];
            }
            }

           

            $sub_services_data[] = [
                    'ps_title' => $sub_service->title,
                    'cs_titles' => $cs_titles,
                ];
            $cs_titles = [];
        }
        $languages = Language::all();
        return view('admin.services.not-approved-detail',compact('service' , 'languages','sub_services_data'));

    }

    public function makeServiceActive(Request $request)
    {
        $customer_account        = CustomerAccount::where('ad_id', $request->id)->where('type', 'offerservice_ad')->where('status','!=', 2)->orderBy('id','DESC')->first();
        if (!empty($customer_account) && $customer_account->debit < $customer_account->paid_amount) {

            return response()->json([
                "success" => false,  'url' => ''
            ]);
        }

        $service = Services::find($request->id);
        // dd($service);
        $check_des = $service->service_description()->count();
        if($check_des < 3)
        {
            return response()->json(['des' => false]);
        }
        $old_status = $service->status;
        $service->status = 1;
        
        if ($customer_account !== null) {
            $start = Carbon::now();
            $start->addDays($customer_account->number_of_days);
            $active_until = $start->endOfDay()->toDateTimeString();

            $service->active_until = $active_until;
        }else{
           $start = Carbon::now();
            $start->addDays(30)->format('Y-m-d');
            $active_until = $start->endOfDay()->toDateTimeString();

            $service->active_until = $active_until; 
        }
        

        $service->save();

        $new_history = new AdsStatusHistory;
        $new_history->user_id = Auth::user()->id;
        $new_history->usertype = 'staff';
        $new_history->ad_id = $service->id;
        $new_history->type = 'offerservice';
        $new_history->status = $new_history->ads_status($old_status);
        $new_history->new_status = $new_history->ads_status($service->status);
        $new_history->save();

        $data = [
            'id' => $service->id,
            'poster_name' => $service->get_customer->customer_company,
            'title'       => @$service->get_service_ad_title($service->id,$service->get_customer->language_id)->title
        ];

        $templatee = EmailTemplate::where('type', 2)->first();
        $template = EmailTemplateDescription::where('email_template_id', $templatee->id)->where('language_id', @$service->get_customer->language_id)->first();
        Mail::to($service->get_customer->customer_email_address)->send(new OfferServiceMail($data, $template));
        return response()->json([
            "success" => true,  'url'=> url('admin/service-details/'.$service->id)
         ]);
    }

    public function makeServiceTranslate(Request $request)
    {
        // dd($request->id);
        $service = Services::find($request->id);        
        $languages = Language::all();
        $dec_old_value ='';
        $dec_new_value = '';

        $title_old_value ='';
        $title_new_value ='';


        foreach($languages as $language)
        {
            //description
            $description = @$service->get_service_description($service->id , $language->id)->description;
            if(!empty($description))
            { 
            $notEmptydescription = $service->get_service_description($service->id , $language->id)->description;
            $dec_old_value = $language->language_title;
            }

            //title
            $title = @$service->get_service_ad_title($service->id , $language->id)->title;
            if(!empty($title)) 
            {
            $notEmptytitle = $service->get_service_ad_title($service->id , $language->id)->title;
            $title_old_value = $language->language_title;
            }
        }

        foreach($languages as $language)
        {
            //description
            $description = trim(@$service->get_service_description($service->id , $language->id)->description);
            $code =  $language->language_code;
            if(empty($description)) 
            {
                $description = GoogleTranslate::translate($notEmptydescription,$code);
                $description = $description['translated_text'];

                $service_desc = ServiceDescription::updateOrCreate(
                ['service_id' => $service->id, 'language_id' => $language->id],
                ['description' => $description]); 

                $dec_new_value .= $language->language_title.',';

            }

            //title
            $title = trim(@$service->get_service_ad_title($service->id , $language->id)->title);
            $code =  $language->language_code;
            if(empty($title)) 
            {
                $title = GoogleTranslate::translate($notEmptytitle,$code);
                $title = $title['translated_text'];

                $service_title = ServiceTitle::updateOrCreate(
                ['services_id' => $service->id, 'language_id' => $language->id],
                ['title' => $title]); 

                $title_new_value .= $language->language_title.',';

            }

        }
    
        if($dec_old_value !='' && $dec_new_value != '')
        {
        $history = new PostsHistory;
        $history->user_id = Auth::user()->id;
        $history->usertype = 'staff';
        $history->username = Auth::user()->name;
        $history->ad_id = $service->id;
        $history->column_name = 'Description (Google Translate)';
        $history->status = $dec_old_value;
        $history->new_status = $dec_new_value;
        $history->type = 'offerservice';
        $history->save();
        }

        if($title_old_value !='' && $title_new_value !='')
        {
        $history = new PostsHistory;
        $history->user_id = Auth::user()->id;
        $history->usertype = 'staff';
        $history->username = Auth::user()->name;
        $history->ad_id = $service->id;
        $history->column_name = 'Title (Google Translate)';
        $history->status = $title_old_value;
        $history->new_status = $title_new_value;
        $history->type = 'offerservice';
        $history->save();
        }
        

        return response()->json([
            "success" => true,  'url'=> url('admin/service-details/'.$service->id)
         ]);
    }


    public function makeServicePending(Request $request)
    {
        // dd($request->id);
        $service = Services::find($request->id);
        // dd($service);
        $old_status = $service->status;
        $service->status = 0;
        $service->save();

        $new_history = new AdsStatusHistory;
        $new_history->user_id = Auth::user()->id;
        $new_history->usertype = 'staff';
        $new_history->ad_id = $service->id;
        $new_history->type = 'offerservice';
        $new_history->status = $new_history->ads_status($old_status);
        $new_history->new_status = $new_history->ads_status($service->status);
        $new_history->save();
        return response()->json([
            "success" => true,  'url'=> url('admin/pending-services')
         ]);
    }

    public function storeDeatil(Request $request)
    {
        // dd($request->all());
        $languages = Language::all();
        foreach($request->except('_token' , 'service_id','title_lang_') as $key => $value){
            if($key != null)
            { 
                $language_id = explode('_', $key);

                if($language_id[0] == 'lang')
                {
                $service_desc = ServiceDescription::where('service_id' , $request->service_id)->where('language_id' , $language_id[1])->first();
                $old_des = $service_desc != null ? $service_desc->description : '';
                if($service_desc == null)
                {
                    $service_desc = new ServiceDescription;
                }
                $service_desc->service_id = $request->service_id;
                $service_desc->description = $value;
                $service_desc->language_id = $language_id[1];
                $service_desc->save();

                if($old_des != null && $value != '' && $old_des != $value)
                {
                    $history = new PostsHistory;
                    $history->user_id = Auth::user()->id;
                    $history->usertype = 'staff';
                    $history->username = Auth::user()->name;
                    $history->ad_id = $request->service_id;
                    if($language_id[1] == 1)
                    {
                        $history->column_name = 'Description(Estonia)';
                    }
                    else if($language_id[1] == 2)
                    {
                        $history->column_name = 'Description(English)';
                    }
                    else if($language_id[1] == 3)
                    {
                        $history->column_name = 'Description(Russia)';
                    }
                    $history->status = $old_des;
                    $history->new_status = $value;
                    $history->type = 'offerservice';
                    $history->save();
                }
                
                }
                else
                {
                $service_title = ServiceTitle::where('services_id' , $request->service_id)->where('language_id' , $language_id[1])->first();
                $old_title = $service_title != null ? $service_title->title : '';
                if($service_title == null)
                {
                    $service_title = new ServiceTitle;
                }
                $service_title->services_id = $request->service_id;
                $service_title->title = $value;
                $service_title->language_id = $language_id[1];
                $service_title->save();

                if($old_title != null && $value != '' && $old_title != $value)
                {
                    $history = new PostsHistory;
                    $history->user_id = Auth::user()->id;
                    $history->usertype = 'staff';
                    $history->username = Auth::user()->name;
                    $history->ad_id = $request->service_id;
                    if($language_id[1] == 1)
                    {
                        $history->column_name = 'Title(Estonia)';
                    }
                    else if($language_id[1] == 2)
                    {
                        $history->column_name = 'Title(English)';
                    }
                    else if($language_id[1] == 3)
                    {
                        $history->column_name = 'Title(Russia)';
                    }
                    $history->status = $old_title;
                    $history->new_status = $value;
                    $history->type = 'offerservice';
                    $history->save();
                }
                }  
            }
        }

        return redirect()->back();
            # code...
    
    }

      public function active()
    {
        $active_services = Services::where('status',1)->get();

        return view('admin.services.active',compact('active_services'));
    }

       public function removed()
    {
        $removed_services = Services::where('status',2)->get();

        return view('admin.services.removed',compact('removed_services'));
    }

    public function notApproveServicesList()
    {
        $not_approve_services = Services::where('status',3)->get();

        return view('admin.services.not-approved',compact('not_approve_services'));
    }

    public function primaryServices()
    {

        $primary_service  = PrimaryService::query()->select("psd.primary_service_id", "psd.title","image","status");
        $primary_service->join('primary_services_description AS psd', 'primary_services.id', '=', 'psd.primary_service_id')->where('language_id', 2)->orderBy('psd.title', 'ASC');
        $primary_services      = $primary_service->get();


        $languages = Language::all();
        
        return view('admin.services.primary_services',compact('primary_services','languages'));
    }

    public function disablePrimaryService(Request $request)
    {   

        $del = PrimaryService::where('id',$request->id)->first();
        $del->status = 0;
        $del->save();        
        return response()->json(['success' => true, 'message' => 'Parent Category Disable Successfully']);
    }

    public function activePrimaryService(Request $request)
    {   

        $del = PrimaryService::where('id',$request->id)->first();
        $del->status = 1;
        $del->save();        
        return response()->json(['success' => true, 'message' => 'Parent Category Active Successfully']);
    }
    


       public function subServices($id)
    {
        
        $engineTypesQuery = SubService::query()->select("sub_service_id as sub_cat_id","is_make","sc.title as SubTitle","primary_service_id","status");
        $engineTypesQuery->join('sub_services_description AS sc', 'sub_services.id', '=', 'sc.sub_service_id')->where('language_id', 2);
        $sub_services   = $engineTypesQuery->where('parent_id', 0)
        ->where('primary_service_id',$id)->orderBy('primary_service_id')->get();
        // $sub_services = SubService::where('parent_id',0)->get();
        
        $primary_service  = PrimaryService::query()->select("psd.primary_service_id", "psd.title","image");
        $primary_service->join('primary_services_description AS psd', 'primary_services.id', '=', 'psd.primary_service_id')->where('language_id', 2)->where('primary_service_id', $id)->orderBy('psd.title', 'ASC');
        $primary_services      = $primary_service->first();

        //dd($primary_services);

        $languages = Language::all();
        return view('admin.services.subServices',compact('sub_services','primary_services','languages'));
    }

       public function SubSubServices($id)
    {
        $engineTypesQuery = SubService::query()->select("sub_service_id as sub_cat_id","is_make","sc.title as SubTitle","primary_service_id","status");
        $engineTypesQuery->join('sub_services_description AS sc', 'sub_services.id', '=', 'sc.sub_service_id')->where('language_id', 2);
        $sub_subservices   = $engineTypesQuery->where('parent_id', $id)->orderBy('primary_service_id')->get();


        $engineTypesQuery = SubService::query()->select("sub_service_id as sub_cat_id","is_make","sc.title as SubTitle","primary_service_id","status");
        $engineTypesQuery->join('sub_services_description AS sc', 'sub_services.id', '=', 'sc.sub_service_id')->where('language_id', 2);
        $sub_category   = $engineTypesQuery->where('sub_service_id', $id)->where('parent_id', 0)->first();

        $primary_service  = PrimaryService::query()->select("psd.primary_service_id", "psd.title","image");
        $primary_service->join('primary_services_description AS psd', 'primary_services.id', '=', 'psd.primary_service_id')->where('language_id', 2)->where('primary_service_id', $sub_category->primary_service_id)->orderBy('psd.title', 'ASC');
        $primary_services      = $primary_service->first();

        $languages = Language::all();

        return view('admin.services.subsubServices',compact('sub_subservices','primary_services','sub_category','languages'));
    }

    public function disableSubService(Request $request)
    { 
        $del = SubService::where('id',$request->id)->first();
        $del->status = 0;
        $del->save();   
        if($del->parent_id == 0)     
        return response()->json(['success' => true, 'message' => 'Sub Category Disable Successfully']);
        else     
        return response()->json(['success' => true, 'message' => 'Detail Disable Successfully']);

    }

    public function activeSubService(Request $request)
    { 
        $del = SubService::where('id',$request->id)->first();
        $del->status = 1;
        $del->save(); 
        if($del->parent_id == 0)     
        return response()->json(['success' => true, 'message' => 'Sub Category Active Successfully']);
        else     
        return response()->json(['success' => true, 'message' => 'Detail Active Successfully']);       
    }

     public function getParent($id){
        //dd($id);
        $parent = SubService::where('primary_service_id',$id)->where('parent_id',0)->where('status',1)->get();
        //dd($parent);
        return response()->json([
            'Assignedparent' => $parent,
        ]);
    }

     public function addPrimaryServices(Request $request)
    {
        // dd($request->all());
        $name = 'en_add_title';
        $service= new PrimaryService;

        if($request->edit_image != null)
         {
            $image= $request->edit_image;
            $imageName = 'primaryService-'.time().'-'.rand(000000,999999).'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/image/');
            $image->move($destinationPath, $imageName);
            $service->image = $imageName;
         } 
       

        $service->title     = $request->$name;
        $service->status    = 1;
        $service->image     = $request->edit_image;
        $service->save();

         $languages = Language::all();
        foreach ($languages as $language) {
        
             $res_des = new PrimaryServicesDescription;
              $title = $language->language_code.'_add_title';
                $res_des->title = @$request->$title;
                 $res_des->primary_service_id = $service->id;
                $res_des->language_id = $language->id;
                $res_des->save();

    }
        return Redirect::back()->with('message','Primary Service Added Successfully!');
    }

    public function addSubService(Request $request)
    {  
        //dd($request->all());
        $name = 'en_add_title';
        $service                         = new SubService;
        $service->primary_service_id     = $request->primary_service;
        $service->title                  = $request->$name;
        $service->parent_id              = $request->parent_id;
        $service->is_make                = $request->make;
        $service->save();

        $languages = Language::all();
        foreach ($languages as $language) {
            $sparepart_description = new SubServicesDescription;
            $sparepart_title = $language->language_code.'_add_title';
            $sparepart_description->title = $request->$sparepart_title;
            $sparepart_description->Sub_service_id = $service->id;
            $sparepart_description->language_id = $language->id;
            $sparepart_description->save();
        }
        if($request->parent_id == 0)
        return Redirect::back()->with('message','Sub Category Added Successfully!');
        else
        return Redirect::back()->with('message','Detail Added Successfully!');
    }

     public function editPrimaryServices(Request $request)
    {
        // dd($request->all());
        $service=PrimaryService::find($request->id);
        $languages = Language::all(); 
      if($request->edit_image!=null)
         {
            $image= $request->edit_image;
            $imageName = 'car-'.time().'-'.rand(000000,999999).'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/image/');
            $image->move($destinationPath, $imageName);
            $service->image     = $imageName;
         }
          $sparepart_title = 'en_edit_title';
        $service->title = $request->$sparepart_title;
        // $service->title     = $request->edit_title;
        $service->status    = 1;
        
        $service->save();

        foreach ($languages as $language) {
        $sparepart_description = PrimaryServicesDescription::where('primary_service_id' , $request->id)->where('language_id', $language->id)->first();

        if(@$sparepart_description !== null){
        $sparepart_title = $language->language_code.'_edit_title';
        $sparepart_description->title = $request->$sparepart_title;

        $sparepart_description->language_id = $language->id;
        $sparepart_description->primary_service_id = $request->id;
        $sparepart_description->save();
        }else{
             $sparepart_description = new PrimaryServicesDescription;
              $sparepart_title = $language->language_code.'_edit_title';
                $sparepart_description->title = $request->$sparepart_title;
                 $sparepart_description->primary_service_id = $request->id;
                $sparepart_description->language_id = $language->id;
                $sparepart_description->save();
        }
    }
        return Redirect::back()->with('message','Primary Service Updated Successfully!');
    }

    public function editSubServices(Request $request)
    {
        // dd($request->all());
      
        $languages = Language::all(); 
     
        foreach ($languages as $language) {
        $sparepart_description = SubServicesDescription::where('sub_service_id' , $request->id)->where('language_id', $language->id)->first();

        if(@$sparepart_description !== null){
        $sparepart_title = $language->language_code.'_edit_title';
        $sparepart_description->title = $request->$sparepart_title;

        $sparepart_description->language_id = $language->id;
        $sparepart_description->sub_service_id = $request->id;
        $sparepart_description->save();
        }else{
             $sparepart_description = new SubServicesDescription;
              $sparepart_title = $language->language_code.'_edit_title';
                $sparepart_description->title = $request->$sparepart_title;
                 $sparepart_description->Sub_service_id = $request->id;
                $sparepart_description->language_id = $language->id;
                $sparepart_description->save();
        }
    }

        return Redirect::back()->with('message','Updated Successfully!');
    }

    public function approveService(Request $request)
    {
        //dd($request->all());
        //dd($request->service_id);
        $services = Services::find($request->service_id);
        $services->status = 2;            //status 2 because we need to directly publish this service
        $services->save();

        $customer_name = $services->get_customer->customer_company;

        $customer_email = $services->get_customer->customer_email_address;


        $data =[

            'customer_name' => $customer_name,
        ];

        $template = EmailTemplate::where('type', 'publish-offer-service-ad')->first();
        //dd($template);
        Mail::to($customer_email)->send(new PublishOfferServiceAd($data, $template));

        //
         
         return response()->json([
            "success" => true,  'url'=> url('admin/unpaid-spareparts')
         ]);
    }

    public function editService(Request $request)
    {
        // dd($request->all());
        $services = PrimaryServicesDescription::where('primary_service_id',$request->id)->get();
        // dd($services);
        return response()->json(['success' => true , 'services' => $services]);
    }

    public function editSubService(Request $request)
    {
        // dd($request->all());
        $services = SubServicesDescription::where('sub_service_id',$request->id)->get();
        // dd($services);
        return response()->json(['success' => true , 'services' => $services]);
    }
        
}
