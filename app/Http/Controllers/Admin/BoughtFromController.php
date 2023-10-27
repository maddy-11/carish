<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BoughtFrom;
use App\Models\BoughtFromDescription;
use App\Models\Language;
use Illuminate\Support\Facades\Redirect;
class BoughtFromController extends Controller
{
    public function index()
    {
        $boughtfrom    = BoughtFrom::query()->select("bought_from_id", "title", "code", "slug","status");
        $boughtfrom->join('bought_from_description AS bfd', 'bought_from.id', '=', 'bfd.bought_from_id')->where('language_id', 2);
        $boughtfrom         = $boughtfrom->orderBy('title', 'ASC')->get();

        $languages = Language::all();
    	return view('admin.bought_from', compact('boughtfrom','languages'));
    }

    public function addBoughtFrom(Request $request)
    {
        // dd($request->all());
        $name = 'en_add_title';
        $boughtfrom = new BoughtFrom;
        $boughtfrom->code=$request->code;
        $boughtfrom->save();

        $languages = Language::all();
        foreach ($languages as $language) {
            $res_des = new BoughtFromDescription;
            $title = $language->language_code.'_add_title';
            $res_des->title = @$request->$title;
            $res_des->slug = str_replace(" ","-",strtolower($request->$title));
            $res_des->bought_from_id = $boughtfrom->id;
            $res_des->language_id = $language->id;
            $res_des->save();

    }

        return Redirect()->back()->with('boughtfrom_added','Bought From Added Successfully!');;
          
    }

    public function editBoughtFrom(Request $request)
    {
        $bfd = BoughtFromDescription::where('bought_from_id',$request->id)->get();
        return response()->json(['success' => true , 'bfd' => $bfd]);
    }

     public function deleteBoughtFrom(Request $request)
    {   

        $del=BoughtFrom::where('id',$request->id)->first();
        $del->status = 0;
        $del->save();        
        return Redirect()->back()->with('boughtfrom_deleted','Bought From Deleted Successfully!');
    }

    public function updateBoughtFrom(Request $request)
    {
    	// dd($request->all());
        $update_bf=BoughtFrom::where('id',$request->id)->update([
        'code' => $request->edit_code,
        'status' => $request->status
        ]);

        $languages = Language::all(); 

        foreach ($languages as $language) {
        $bf_des = BoughtFromDescription::where('bought_from_id' , $request->id)->where('language_id', $language->id)->first();

        if(@$bf_des !== null){
            $bf_title = $language->language_code.'_edit_title';
            $bf_des->title = $request->$bf_title;  
            $bf_des->slug = str_replace(" ","-",strtolower($request->$bf_title));

            $bf_des->language_id = $language->id;
            $bf_des->bought_from_id = $request->id;
            $bf_des->save();
        }
        else{
            $bf_des = new BoughtFromDescription;
            $bf_title = $language->language_code.'_edit_title';
            $bf_des->title = $request->$bf_title;
            $bf_des->slug = str_replace(" ","-",strtolower($request->$bf_title));
            $bf_des->bought_from_id = $request->id;
            $bf_des->language_id = $language->id;
            $bf_des->save();
        }
    }

        return Redirect::back()->with('message','Bought From Updated Successfully!');
    } 
}