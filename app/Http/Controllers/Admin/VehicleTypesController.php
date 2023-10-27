<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\VehicleType;
use App\VehicleTypeDetail;
use App\Models\Language;
use Illuminate\Support\Facades\Redirect;

class VehicleTypesController extends Controller
{
    public function index()
    {
    	$vehicle_type = VehicleType::where('status',1)->get();
        $vehicle_types_detail = VehicleTypeDetail::whereHas('vehicle_type',function($q){
            $q->where('status',1);
        })->where('language_id' ,2)->get();
        $languages = Language::all();
    	return view('admin.vehicle-type', compact('vehicle_type','languages','vehicle_types_detail'));
    }

    public function addVehicleType(Request $request)
    {
    	// dd($request->all());

        $vehicle_type 				= new VehicleType;
        $vehicle_type->save();

        $languages = Language::all();

        foreach ($languages as $language) {
        $vehicle_types_detail = new VehicleTypeDetail;
        $vehicle_types_detail->vehicle_type_id = $vehicle_type->id;

        $vehicle_type_title = $language->language_code.'_vt_title';
        $vehicle_types_detail->title = $request->$vehicle_type_title;

        $vehicle_types_detail->language_id = $language->id;
        $vehicle_types_detail->save();

            
       }

       	return Redirect::back()->with('message','Vehicle Type Added Successfully!');
     }

     public function deleteVehicletype(Request $request)
    { 
        $del=VehicleType::where('id',$request->id)->first();
        // $del=VehicleTypeDetail::where('vehicle_type_id',$request->id)->delete();
        $del->status = 0;
        $del->save();
        return response()->json(['success' => true, 'message' => 'Vehicle type Deleted successfully']);
    }

    public function editVehicleType(Request $request)
    {
        // dd($request->all());
        $e_vehicle_type = VehicleTypeDetail::where('vehicle_type_id',$request->id)->get();
        // dd($e_suggesstion);
        return response()->json(['success' => true , 'e_vehicle_type' => $e_vehicle_type]);
    }

    public function updateVehicleType(Request $request)
    {
        // dd($request->all());
        
        $languages = Language::all();

        foreach ($languages as $language) {
        $vehicle_types_detail = VehicleTypeDetail::where('vehicle_type_id' , $request->vehicle_type_id)->where('language_id', $language->id)->first();

        $vehicle_type_title = $language->language_code.'_edit_title';
        $vehicle_types_detail->title = $request->$vehicle_type_title;

        $vehicle_types_detail->language_id = $language->id;
        $vehicle_types_detail->save();
        }

        return redirect()->route('vehicles-types')->with('message', 'Vehicle Type updated successfully');
    }

    public function changeVehicleTypeStutus(Request $request)
    {
        $vehicle_type = VehicleType::find($request->id);
        $vehicle_type->status = $request->val;
        $vehicle_type->save();
        return response()->json(['success' => true ]);

    }
}
