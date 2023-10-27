<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\CountriesDescription;
use App\Models\Language;
use Illuminate\Support\Facades\Redirect;
class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::where('status',1)->orderBy('name','ASC')->get();
        $languages = Language::all();
    	return view('admin.country', compact('countries','languages'));
    }

    public function addCountry(Request $request)
    {
        // dd($request->all());
        $name = 'en_add_title';
        $country = new Country;
        $country->name=$request->$name;
        $country->code=$request->code;
        $country->save();

        // $country_description = new CountriesDescription;
        // $country_description->country_id = $country->id;
        // $country_description->title = $request->title;
        // $country_description->language_id = 2;
        // $country_description->save();
        $languages = Language::all();
        foreach ($languages as $language) {
        
             $res_des = new CountriesDescription;
              $title = $language->language_code.'_add_title';
                $res_des->title = @$request->$title;
                 $res_des->country_id = $country->id;
                $res_des->language_id = $language->id;
                $res_des->save();

    }

        return Redirect()->back()->with('country_added','Country Added Successfully!');;
          
    }

    public function editCountry(Request $request)
    {
        // dd($request->all());
        $spareparts = CountriesDescription::where('country_id',$request->id)->get();
        // dd($spareparts);
        return response()->json(['success' => true , 'spareparts' => $spareparts]);
    }

     public function deleteCountry(Request $request)
    {   

        $del=Country::where('id',$request->id)->first();
        $del->status = 0;
        $del->save();        
        return Redirect()->back()->with('country_deleted','Country Deleted Successfully!');
    }

    public function updateCountry(Request $request)
    {
    	// dd($request->all());
    	 $sparepart_title = 'en_edit_title';
        $update_city=Country::where('id',$request->id)->update([
        	'name' => $request->$sparepart_title,
            'code' => $request->edit_code
        
        ]);

        $update_tag = Country::where('id',$request->id)->first();
        $languages = Language::all(); 

        foreach ($languages as $language) {
        $sparepart_description = CountriesDescription::where('country_id' , $request->id)->where('language_id', $language->id)->first();

        if(@$sparepart_description !== null){
        $sparepart_title = $language->language_code.'_edit_title';
        $sparepart_description->title = $request->$sparepart_title;

        $sparepart_description->language_id = $language->id;
        $sparepart_description->country_id = $request->id;
        $sparepart_description->save();
        }else{
             $sparepart_description = new CountriesDescription;
              $sparepart_title = $language->language_code.'_edit_title';
                $sparepart_description->title = $request->$sparepart_title;
                $sparepart_description->country_id = $request->id;
                $sparepart_description->language_id = $language->id;
                $sparepart_description->save();
        }
    }

        return Redirect::back()->with('message','Country Updated Successfully!');
    } 
}