<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customers\Customer;
use App\Models\Customers\CustomerAccount;
use Mail;
use App\Reason;
use App\AdsPricing;
use App\ReasonsDescription;
use App\Models\Language;
use App\Mail\CustomerMailable;
use App\Mail\AdMessage;
use Illuminate\Support\Facades\Redirect;
use App\EmailType;
use App\EmailTemplate;
use App\EmailTemplateDescription;
use App\Models\Role;
use App\Models\RoleMenu;
use Auth,DB;
use File;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = Customer::where('customer_role','individual')->get();
        //dd($users);
        return view('admin.customers.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
        echo 'I am create';
    }

    /**
     * Activating And Deactivating a resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function active()
    {
        echo 'I am active';
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {   
      DB::statement('SET FOREIGN_KEY_CHECKS=0;'); 
      //App\Models\SubServicesDescription;
      $customer_id = $request->input('customer_id');
      $get_customer = Customer::where('id',$customer_id)->first();
      if (request()->has('deleteads') && request()->get('deleteads') !='') { 

       $collection = \App\Ad::select('id')->where('customer_id',$customer_id)->get();
       $adIds      = array();
       if($collection->isNotEmpty()) 
       {
        foreach($collection as $rows){
            $adIds[] = $rows->id;
            $ads_images = \App\AdImage::where('ad_id',$rows->id)->get();
            if($ads_images->isNotEmpty()) 
            {
            $folder_path =  'public/uploads/ad_pictures/cars/' . @$rows->id;  
            foreach($ads_images as $ads_image)
            {
            $image_path =  'public/uploads/ad_pictures/cars/' . @$ads_image->ad_id . '/' . @$ads_image->img;  
            if(File::exists($image_path)) {
            File::delete($image_path);
            } 
            }
            File::deleteDirectory($folder_path);
            }

       }
       \App\AdImage::whereIn('ad_id',$adIds)->delete();
       \App\AdTag::whereIn('ad_id',$adIds)->delete();
       \App\Models\AdDescription::whereIn('ad_id',$adIds)->delete();
       \App\AdMsg::where('user_id',$customer_id)->delete(); 
       \App\Ad::where('customer_id',$customer_id)->delete();
       } 
      } 
 // here
      if (request()->has('delete_spareparts') && request()->get('delete_spareparts') !='') {
         $sparePartsCollection = \App\SparePartAd::select('id')->where('customer_id',$customer_id)->get();
         $sparePartsIds      = array();
         if($sparePartsCollection->isNotEmpty())
         {
          foreach($sparePartsCollection as $rows){
            $sparePartsIds[] = $rows->id;
            $ads_images = \App\SparePartAdImage::where('spare_part_ad_id',$rows->id)->get();
            if($ads_images->isNotEmpty()) 
            {
            $folder_path =  'public/uploads/ad_pictures/spare-parts-ad/' . @$rows->id;  
            foreach($ads_images as $ads_image)
            {
            $image_path =  'public/uploads/ad_pictures/spare-parts-ad/' . @$ads_image->spare_part_ad_id . '/' . @$ads_image->img;  
            if(File::exists($image_path)) {
            File::delete($image_path);
            } 
            }
            File::deleteDirectory($folder_path);
            }
        }
        \App\SparePartAdImage::whereIn('spare_part_ad_id',$sparePartsIds)->delete();
        \App\Models\SpAdDescription::whereIn('spare_part_ad_id',$sparePartsIds)->delete();
        \App\SparePartAdTitle::whereIn('spare_part_ad_id',$sparePartsIds)->delete();
        \App\SparepartsAdsMessage::whereIn('spare_parts_ads_id',$sparePartsIds)->delete(); 
        \App\SparePartAd::where('customer_id',$customer_id)->delete();
        
        
        

        }
      }

      if(request()->has('delete_services') && request()->get('delete_services') !=''){
        $services = \App\Models\Services::select('id')->where('customer_id',$customer_id)->get();
        if($services->isNotEmpty()){
          $serviceId = array();
          foreach($services as $service){
            $serviceId[] = $service->id;
            $ads_images = \App\Models\ServiceImage::where('service_id',$service->id)->get();
            if($ads_images->isNotEmpty()) 
            {
            $folder_path =  'public/uploads/ad_pictures/services/' . @$service->id;  
            foreach($ads_images as $ads_image)
            {
            $image_path =  'public/uploads/ad_pictures/services/' . @$ads_image->service_id . '/' . @$ads_image->image_name;  
            if(File::exists($image_path)) {
            File::delete($image_path);
            } 
            }
            File::deleteDirectory($folder_path);
            }
          }

          \App\Models\ServiceImage::whereIn('service_id',$serviceId)->delete();
          \App\Models\ServiceDescription::whereIn('service_id',$serviceId)->delete();
          \App\ServiceTitle::whereIn('services_id',$serviceId)->delete();
          \App\ServiceMessage::where('user_id',$customer_id)->delete();
          \App\Models\Services::where('customer_id',$customer_id)->delete();
        }

        }

        \App\Chat::where('from_id',$customer_id)->orWhere('to_id',$customer_id)->delete();
        \App\CustomerMessages::where('from_id',$customer_id)->orWhere('to_id',$customer_id)->delete();
        \App\Models\CustomerTiming::where('customer_id',$customer_id)->delete();
        \App\Models\Customers\InvoiceSetting::where('customer_id',$customer_id)->delete();
        \App\MyAlert::where('customer_id',$customer_id)->delete(); 
        \App\UserSavedAds::where('customer_id',$customer_id)->delete();
        \App\AccessoriesAlert::where('customer_id',$customer_id)->delete();
        \App\UserSavedSpareParts::where('customer_id',$customer_id)->delete();
        \App\Models\Customers\FeaturedRequest::where('user_id',$customer_id)->delete();
        \App\PostsHistory::where('user_id',$customer_id)->delete();
        \App\Models\AdsStatusHistory::where('user_id',$customer_id)->delete();

        $customer_logo =  'public/uploads/customers/logos/'.@$get_customer->logo;  
        if(File::exists($customer_logo)) {
        File::delete($customer_logo);
        } 
        
        $customer    = Customer::where('id',$customer_id)->delete();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); 
        return Redirect::back()->with('message','Customer deleted Successfully!');
    }

    public function activeUsers()
    {
        $buisness = Customer::where('customer_role','business')->where('customer_status','Active')->where('is_adminverify',1)->get();
        $users = Customer::where('customer_role','individual')->where('customer_status','Active')->get();

        //dd($buisness);
        return view('admin.customers.active-users',compact('buisness','users'));
    }

    public function inActiveUsers()
    {
        $buisness = Customer::where('customer_role','business')->where('customer_status','Inactive')->get();
        $users = Customer::where('customer_role','individual')->where('customer_status','Inactive')->get();

        //dd($buisness);
        return view('admin.customers.in-active-users',compact('buisness','users'));
    }

    public function adminPendingUsers()
    {
        $reasons        = Reason::where('status', 1)->where('type','business-not-approved')->get();
        $buisness = Customer::where('customer_role','business')->where('is_adminverify',0)->get();
        //$users = Customer::where('customer_role','individual')->where('customer_status','Inactive')->get();

        //dd($buisness);
        return view('admin.customers.peding-admin-users',compact('buisness','reasons'));
    }

    public function verifyCustomer(Request $request)
    {
        $customer = Customer::where('id', $request->id)->first();
        $customer->is_adminverify = 1;

        $data = [
            'customer_company' => $customer->customer_company
        ];

        $templatee = EmailTemplate::where('type', 18)->first();
        $template = EmailTemplateDescription::where('email_template_id', $templatee->id)->where('language_id', @$customer->language_id)->first();
        Mail::to($customer->customer_email_address)->send(new CustomerMailable($data, $template));

        $customer->save();

        return response()->json(['success' => true, 'message' => 'Customer verify successfully.']);
    }

    public function notApproveBusiness(Request $request)
    {
        $customer = Customer::where('id', $request->msg_customer_id)->first();  

        $emailType = EmailType::where('slug', 'account_verification_failed')->first();
        $template = EmailTemplate::where('type', $emailType->id)->first();
        $template = EmailTemplateDescription::where('email_template_id', $template->id)->where('language_id',  $customer->language_id)->first();
        $not_approved_reasons = ReasonsDescription::whereIn('reason_id', $request->reason)->where('language_id', $customer->language_id)->get();

        $all_res = '';
        foreach ($not_approved_reasons as $npr) {
            $all_res .= '<li>' . @$npr->title . '</li>';
        }
        $data = [
            'name' => @$customer->customer_company,
            'reason' => @$all_res,
        ];
        Mail::to($customer->customer_email_address)->send(new AdMessage($data, $template));

        return redirect('admin/pending-admin/user');
    }

    public function inActiveUserDeatil($id)
    {  
      $user = Customer::find($id); 
        return view('admin.customers.inactive-user-detail',compact('user'));
    }

    public function deleteinActiveUser(Request $request)
    {  
        Customer::where('id',$request->id)->delete();
        return response()->json(['success' => true, 'message' => 'Customer Delete Successfully']);
    }

    public function activeUserDeatil($id)
    {
        
        $user = Customer::find($id);
        $customers_accounts = CustomerAccount::where('customer_id',$id)->orderBy('id','desc')->get(); 
        return view('admin.customers.active-user-detail',compact('user','customers_accounts'));
    }

    public function sendMail(Request $request,$id)
    { 
        $customer = Customer::find($id);

        $data = [
           
            'firstname' => $customer->customer_firstname,
            'lastname' => $customer->customer_lastname,
            'body' => $request->message,
        ];
       //dd($data);
        $template = EmailTemplate::where('type', 'send-mail-to-customers')->first();
        //dd($template);
        Mail::to($customer->customer_email_address)->send(new CustomerMailable($data, $template));

    }

    public function deleteInvoices(Request $request)
    {
        // dd($request->all());
        $ad_id_array = $request->input('id');

        $invoices = CustomerAccount::whereIn('id',$ad_id_array)->delete();

        return response()->json(['success' => true, 'message' => 'Invoice(s) Deleted successfully']);
    }

    public function reasons()
    {
        $reasons = Reason::where('status',1)->orderBy('id','ASC')->get();
        $languages = Language::all();
        return view('admin.reason', compact('reasons','languages'));
    }

     public function addReason(Request $request)
    {
        // dd($request->all());
        // $lowerString = strtolower($request->en_add_title);
        // $slug = str_replace(' ','-',$string);
        $reason = new Reason;
        $reason->status = 1;
        $reason->save();

        $languages = Language::all();
        foreach ($languages as $language) {
        
             $res_des = new ReasonsDescription;
              $title = $language->language_code.'_add_title';
                $res_des->title = @$request->$title;
                 $res_des->reason_id = $reason->id;
                $res_des->language_id = $language->id;
                $res_des->save();

    }
        return Redirect()->back()->with('reason_added','Reason Added Successfully!');
          
    }

    public function editReason(Request $request)
    {
        // dd($request->all());
        $spareparts = ReasonsDescription::where('reason_id',$request->id)->get();
        // dd($spareparts);
        return response()->json(['success' => true , 'spareparts' => $spareparts]);
    }
     public function deleteReason(Request $request)
    {   

        $del=Reason::where('id',$request->id)->first();
        $del->status = 0;
        $del->save();
        
        // return Redirect::back();
        return Redirect()->back()->with('reason_deleted','Reason Deleted Successfully!');
    }

    public function updateReason(Request $request)
    {
        // dd($request->all());
        //  $sparepart_title = 'en_edit_title';
        // $update_city=Country::where('id',$request->id)->update([
        //     'name' => $request->$sparepart_title,
        //     'code' => $request->edit_code
        
        // ]);

        $update_tag = Reason::where('id',$request->id)->first();
        $languages = Language::all(); 

        foreach ($languages as $language) {
        $reason_description = ReasonsDescription::where('reason_id' , $request->id)->where('language_id', $language->id)->first();

        if(@$reason_description !== null){
        $sparepart_title = $language->language_code.'_edit_title';
        $reason_description->title = $request->$sparepart_title;

        $reason_description->language_id = $language->id;
        $reason_description->reason_id = $request->id;
        $reason_description->save();
        }else{
             $reason_description = new ReasonsDescription;
              $sparepart_title = $language->language_code.'_edit_title';
                $reason_description->title = $request->$sparepart_title;
                 $reason_description->reason_id = $request->id;
                $reason_description->language_id = $language->id;
                $reason_description->save();
        }
    }

        return Redirect::back()->with('message','Reason Updated Successfully!');
    }

    public function emailTypes()
    {
        $email_types = EmailType::where('status',1)->orderBy('id','ASC')->get();
        $languages = Language::all();
        return view('admin.email_type', compact('email_types','languages'));
    }

    public function addEmailType(Request $request)
    {
        // dd($request->all());

        $email_type = new EmailType;
        $email_type->type = $request->title;
        $email_type->slug = $request->slug;
        $email_type->status = 1;
        $email_type->save();

        return Redirect()->back()->with('type_added','Email Type Added Successfully!');;
          
    }

    public function updateEmailType(Request $request)
    {

        $update_tag = EmailType::find($request->id);
        $languages = Language::all();

        $update_tag->type = $request->title;
        $update_tag->slug = $request->slug;
        $update_tag->save(); 

    
        return Redirect::back()->with('message','Email Type Updated Successfully!');
    }

    public function deleteEmailType(Request $request)
    {   
        // dd($request->all());
        $del = EmailType::where('id',$request->id)->first();
        $del->status = 0;
        $del->save();
        
        return Redirect::back()->with('deleted','Email Type Deleted Successfully!');
    }

     public function deleteEmailTemplate(Request $request)
    {   
        // dd($request->all());
        $del = EmailTemplate::where('id',$request->id)->first();
        $del->status = 0;
        $del->save();
        // $del_des = EmailTemplateDescription::where('email_template_id',$request->id)->delete();
        
        return Redirect::back()->with('deleted','Email Template Deleted Successfully!');
    }

    public function roles()
    {
        $roles = Role::where('status',1)->get();
        $languages = Language::all();
        return view('admin.roles', compact('roles'));
    }

    public function addRole(Request $request)
    {
       
        $role = new Role;
        $role->name = $request->name;
        $role->status = 1;
        $role->save();
        return Redirect::back()->with('message','Role Added Successfully!');
    }

    public function updateRole(Request $request)
    {
       $role = Role::find($request->id);
       $role->name = $request->name;
       $role->save();
        return Redirect::back()->with('updated','Role Update Successfully!');
    } 

    public function deleteRole(Request $request)
    {   
        $del=Role::where('id',$request->id)->first();
        $del->status = 0;
        $del->save();
        
       return response()->json(['success' => true, 'message' => 'Role Deleted successfully']);
    }
     public function viewRoleDetails(Request $request){
        $role_id=$request->role_id;
        $role_name=Role::where('id',$role_id)->pluck('name')->first();
        $role_menus=RoleMenu::where('role_id',$role_id)->pluck('menu_title')->toArray();

        return view('admin.role-menus',compact('role_name','role_id','role_menus'));
  }
  public function storeRoleMenu(Request $request){
        RoleMenu::where('role_id',$request['role_id'])->delete();
        foreach($request['menus'] as $menu)
        {
            $rolemenu=new RoleMenu();
            $rolemenu->menu_title=$menu;
            $rolemenu->role_id=$request['role_id'];         
            $rolemenu->save();
        }
        return response(['success'=>true]);
      }

    public function createTokenOfUserForAdminLogin(){

      if(isset($_GET['user_id'])){

        $user_id=$_GET['user_id'];
        $token_for_admin_login=uniqid();

        $user=Customer::where('id',$user_id)->first();

        if($user->login_status != 1){
            return response()->json(                [
                    "success" => false,
                    'user_id'=>$user_id,
                ]
            );
        }

        $user->token_for_admin_login=$token_for_admin_login;
        $user->save();

        return response()->json([
          'token_for_admin_login'=>$token_for_admin_login,
          'user_id'=>$user_id
          ]);
      }
    }

    public function ads_pricing_list()
    {
        $ads_pricing = AdsPricing::orderBy('number_of_days', 'ASC')->get();
        return view('admin.ads-pricing.list',compact('ads_pricing'));
    }

    public function store_pricing(Request $request)
    {
        $validator = $request->validate([
            'user_category' => 'required',
            'pricing_for' => 'required',
            'days' => 'required|integer',
            'pricing' => 'required',

        ]);

        $ad_pricing = new AdsPricing;
        $ad_pricing->user_category = $request->user_category;
        $ad_pricing->type = $request->pricing_for;
        $ad_pricing->number_of_days = $request->days;
        $ad_pricing->pricing = $request->pricing;
        $ad_pricing->save();

        return Redirect::back()->with('message','Ads Pricing added Successfully!');
    }

    public function update_pricing(Request $request)
    {
        $validator = $request->validate([
            'edit_user_category' => 'required',
            'edit_pricing_for' => 'required',
            'edit_days' => 'required|integer',
            'edit_pricing' => 'required',

        ]);

        $pricing = AdsPricing::findOrFail($request->pricing_id);
        $pricing->user_category = $request->edit_user_category;
        $pricing->type = $request->edit_pricing_for;
        $pricing->number_of_days = $request->edit_days;
        $pricing->pricing = $request->edit_pricing;
        $pricing->save();

        return Redirect::back()->with('message','Ads Pricing updated Successfully!');
    }

    public function delete_pricing(Request $request)
    {
        $pricing = AdsPricing::where('id',$request->id)->first();
        $pricing->delete();

        return response()->json(['success' => true]);
    }
}