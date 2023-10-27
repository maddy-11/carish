<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transmission;
use App\Models\TransmissionDescription;
use App\Models\Language;
use Illuminate\Support\Facades\Redirect;

class TransmissionController extends Controller
{
    public function index()
    {
        $transmissions = Transmission::where('status',1)->get();
        $languages = Language::all();
    	return view('admin.transmissions', compact('transmissions','languages'));
    }

    public function addTransmission(Request $request)
    {
        // dd($request->all());
        $title = 'en_add_title';
        $transmission = new Transmission;
        // $color->name = $request->$title;
        $transmission->api_code = $request->code;
        $transmission->status = 1;
        $transmission->save();

        $languages = Language::all();
        foreach ($languages as $language) {
        
             $res_des = new TransmissionDescription;
              $title = $language->language_code.'_add_title';
                $res_des->title = @$request->$title;
                 $res_des->transmission_id = $transmission->id;
                $res_des->language_id = $language->id;
                $res_des->save();

    }

        return Redirect::back()->with('message','Transmission Added Successfully!');
    }

    public function editTransmission(Request $request)
    {
        // dd($request->all());
        $spareparts = TransmissionDescription::where('transmission_id',$request->id)->get();
        // dd($spareparts);
        return response()->json(['success' => true , 'spareparts' => $spareparts]);
    }

    public function updateTransmission(Request $request)
    {
    	// dd($request->all());
        $title = 'en_edit_title';
        $update_engine = Transmission::where('id',$request->id)->update([
            'api_code' => $request->edit_code
        ]);
        $update_tag = Transmission::where('id',$request->id)->first();
        $languages = Language::all(); 

        foreach ($languages as $language) {
        $transmission_description = TransmissionDescription::where('transmission_id' , $request->id)->where('language_id', $language->id)->first();

        if(@$transmission_description !== null){
        $transmission_title = $language->language_code.'_edit_title';
        $transmission_description->title = $request->$transmission_title;

        $transmission_description->language_id = $language->id;
        $transmission_description->transmission_id = $request->id;
        $transmission_description->save();
        }else{
             $transmission_description = new TransmissionDescription;
              $transmission_title = $language->language_code.'_edit_title';
                $transmission_description->title = $request->$transmission_title;
                 $transmission_description->transmission_id = $request->id;
                $transmission_description->language_id = $language->id;
                $transmission_description->save();
        }
    }
        return Redirect::back()->with('updated','Transmission Updated Successfully!');
    }

    public function deleteTransmission(Request $request)
    {   

        $del = Transmission::where('id',$request->id)->first();
        // $del->transmission_description()->delete();
        $del->status = 0;
        $del->save();
        
       return response()->json(['success' => true, 'message' => 'Transmission Deleted successfully']);
    }
}
