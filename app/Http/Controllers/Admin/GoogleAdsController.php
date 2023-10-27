<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\AdsPage;
use App\Models\GoogleAd;
use Illuminate\Support\Facades\Redirect;

class GoogleAdsController extends Controller
{
    public function index()
    {
    	$ads_pages = AdsPage::where('status',1)->latest()->get();
        // dd($templates[0]->emailTemplateDescription[0]);
        return view('admin.google_ads.index',compact('ads_pages'));
    }

    public function addGoogleAdPage(Request $request)
    {
        // dd($request->all());

        $ad_page = new AdsPage;
        $ad_page->page_name = $request->name;
        $ad_page->slug = $request->slug;
        $ad_page->status = 1;
        $ad_page->save();

        return Redirect()->back()->with('page_added','Google Ad Page Added Successfully!');;
          
    }

    public function updateGoogleAdPage(Request $request)
    {

        $update_page = AdsPage::find($request->id);
        $update_page->page_name = $request->name;
        $update_page->slug = $request->slug;
        $update_page->save(); 

    
        return Redirect::back()->with('message','Google Ad Page Updated Successfully!');
    }

     public function deleteGoogleAdPage(Request $request)
    {   
        // dd($request->all());
        $del = AdsPage::where('id',$request->id)->first();
        $del->status = 0;
        $del->save();
        
        return Redirect::back()->with('deleted','Google Ad Page Deleted Successfully!');
    }

    public function googleAdsListing()
    {
    	$google_ads = GoogleAd::where('status',1)->latest()->get();
    	$all_pages = AdsPage::where('status',1)->get();
        // dd($templates[0]->emailTemplateDescription[0]);
        return view('admin.google_ads.google_ads_listing',compact('google_ads','all_pages'));
    }

    public function addGoogleAd(Request $request)
    {
        // dd($request->all());

        $google_ad = new GoogleAd;
        $google_ad->page_id = $request->page_name;
        $google_ad->ad_position = $request->position;
        $google_ad->ad_title = $request->title;
        $google_ad->ad_description = $request->description;
        $google_ad->ad_link = $request->link;
        $google_ad->status = 1;
        if($request->hasFile('logo') && $request->logo->isValid())
        {         
            $fileNameWithExt = $request->file('logo')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt,PATHINFO_FILENAME);
            $extension = $request->file('logo')->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            $path = $request->file('logo')->move('public/uploads/ads/',$fileNameToStore);
            $google_ad->img = $fileNameToStore;
        }
        $google_ad->save();

        return Redirect()->back()->with('ad_added','Google Ad Added Successfully!');;
          
    }

     public function updateGoogleAd(Request $request)
    {

        $google_ad = GoogleAd::find($request->id);
        $google_ad->page_id = $request->page_name;
        $google_ad->ad_position = $request->position;
        $google_ad->ad_title = $request->title;
        $google_ad->ad_description = $request->description;
        $google_ad->ad_link = $request->link;
        $google_ad->save(); 
        return Redirect::back()->with('message','Google Ad Updated Successfully!');
    }

    public function deleteGoogleAd(Request $request)
    {   
        // dd($request->all());
        $del = GoogleAd::where('id',$request->id)->first();
        $del->status = 0;
        $del->save();
        
        return Redirect::back()->with('deleted','Google Ad Deleted Successfully!');
    }
}
