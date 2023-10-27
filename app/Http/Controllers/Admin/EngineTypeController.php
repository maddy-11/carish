<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EngineType;
use App\Models\EngineTypeDescription;
use App\Models\Language;
use Illuminate\Support\Facades\Redirect;

class EngineTypeController extends Controller
{
    public function index()
    {
        $engineTypes = EngineType::where('status',1)->get();
        $languages = Language::all();
    	return view('admin.engine-types', compact('engineTypes','languages'));
    }

    public function addEngineType(Request $request)
    {
        // dd($request->all());
        $title = 'en_add_title';
        $engine = new EngineType;
        // $color->name = $request->$title;
        $engine->api_code = $request->code;
        $engine->status = 1;
        $engine->save();

        $languages = Language::all();
        foreach ($languages as $language) {
        
             $res_des = new EngineTypeDescription;
              $title = $language->language_code.'_add_title';
                $res_des->title = @$request->$title;
                 $res_des->engine_type_id = $engine->id;
                $res_des->language_id = $language->id;
                $res_des->save();

    }

        return Redirect::back()->with('message','Engine Type Added Successfully!');
    }

     public function editEngineType(Request $request)
    {
        // dd($request->all());
        $spareparts = EngineTypeDescription::where('engine_type_id',$request->id)->get();
        // dd($spareparts);
        return response()->json(['success' => true , 'spareparts' => $spareparts]);
    }

    public function updateEngineType(Request $request)
    {
    	// dd($request->all());
        $title = 'en_edit_title';
        $update_engine = EngineType::where('id',$request->id)->update([
            'api_code' => $request->edit_code
        ]);
        $update_tag = EngineType::where('id',$request->id)->first();
        $languages = Language::all(); 

        foreach ($languages as $language) {
        $engine_description = EngineTypeDescription::where('engine_type_id' , $request->id)->where('language_id', $language->id)->first();

        if(@$engine_description !== null){
        $engine_title = $language->language_code.'_edit_title';
        $engine_description->title = $request->$engine_title;

        $engine_description->language_id = $language->id;
        $engine_description->engine_type_id = $request->id;
        $engine_description->save();
        }else{
             $engine_description = new EngineTypeDescription;
              $engine_title = $language->language_code.'_edit_title';
                $engine_description->title = $request->$engine_title;
                 $engine_description->engine_type_id = $request->id;
                $engine_description->language_id = $language->id;
                $engine_description->save();
        }
    }
        return Redirect::back()->with('updated','Engine Type Updated Successfully!');
    }

     public function deleteEngineType(Request $request)
    {   

        $del = EngineType::where('id',$request->id)->first();
        // $del->engine_type_description()->delete();
        $del->status = 0;
        $del->save();
        // $del->delete();
        
       return response()->json(['success' => true, 'message' => 'Engine Type Deleted successfully']);
    }
}
