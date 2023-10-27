<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cars\Version;
use App\Models\Cars\BodyTypes;
use App\BodyTypesDescription;
use App\Models\Transmission;
use App\Models\Cars\Carmodelversions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use App\Ad;
use App\Models\Cars\Carmodel;
use DB;
class CarmodelversionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $model             = Carmodel::where('id', $id)->where('status', 1)->first();
        $bodyTypesQuery    = BodyTypes::query()->select("body_type_id", "btd.name", "api_code", "image", "name_slug");
        $bodyTypesQuery->join('body_types_description AS btd', 'body_types.id', '=', 'btd.body_type_id')->where('language_id', 2);
        $version_body_types         = $bodyTypesQuery->where('status', 1)->orderBy('btd.name', 'ASC')->get();


        $TransmissionTypesQuery    = Transmission::query()->select("transmission_id", "ttd.title", "api_code", "status");
        $TransmissionTypesQuery->join('transmission_description AS ttd', 'transmissions.id', '=', 'ttd.transmission_id')->where('language_id', 2);
        $version_TransmissionTypes         = $TransmissionTypesQuery->where('status', 1)->orderBy('ttd.title', 'ASC')->get();



        DB::enableQueryLog();
        $versions_query =  Version::query();
        if(!empty(request()->get('version_year'))){
            $version_year = request()->get('version_year');
            $versions_query->whereRaw("'" . $version_year . "' >= from_date")
            ->whereRaw("(to_date ='.' OR '" . $version_year . "' <= to_date)");
        }
        if(!empty(request()->get('version_cc'))){
            $version_cc = request()->get('version_cc');
            $versions_query->where('engine_capacity', '=', $version_cc);
        }
        if(!empty(request()->get('version_kilowatt'))){
            $version_kilowatt = request()->get('version_kilowatt');
            $versions_query->where('kilowatt', '=', $version_kilowatt);
        }
        if(!empty(request()->get('bodytype'))){
            $bodytype = request()->get('bodytype');
            $versions_query->where('body_type_id', '=', $bodytype);
        }

        if(!empty(request()->get('transmissiontype'))){
            $transmissiontype = request()->get('transmissiontype');
            $versions_query->where('transmissiontype', '=', $transmissiontype);
        }

        
        $versions_query->where('model_id', '=', $id);
        $model_versions = $versions_query->get();
        return view('admin.car_model_versions.index', compact('model_versions', 'model','version_body_types','version_TransmissionTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.car_model_versions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $jason_test = array('abs' => false, 'air_bags' => false, 'air_conditioning' => false, 'alloy_rims' => false);
        if ($request->ABS == 'on') {
            $jason_test['abs'] = true;
        }
        if ($request->Air_Bags  == 'on') {
            $jason_test['air_bags'] = true;
        }
        if ($request->Air_Conditioning  == 'on') {
            $jason_test['air_conditioning'] = true;
        }
        if ($request->Alloy_Rims  == 'on') {
            $jason_test['alloy_rims'] = true;
        }
        $input                = $request->all();
        $input['features']    =  json_encode($jason_test);
        Carmodelversions::create($input);

        /* $car_model_version->name = $request->name;
        $car_model_version->engin_capacity = $request->engine_capacity;
        $car_model_version->fuel_type = $request->fuel_type;
        $car_model_version->assembly = $request->assembly;
        $car_model_version->features =  json_encode($jason_test);
        $car_model_version->save();*/
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function importMakeModelVersions()
    {
        $destinationPath = public_path('/spare-parts-ads/Book1.xlsx');

        /*   $row = array();
        $data = $this->csvToArray($destinationPath);
        foreach ($data as $values)
        {
            $row[$values['Make']][$values['Model']][] =   array('label'=>$values['Label'],'details'=> $values['Details'],
            'from'=> $values['from'],'to'=> $values['to']); 
        }
        dd($row); */
    }


    private function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        return $data;
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
    public function destroy($id)
    {
        //
    }

    public function addCarVersion(Request $request)
    {
        // dd($request->all());
        $version = new Version;
        $version->label = $request->v_name;
        $version->model_id = $request->model_id;
        $version->from_date = $request->from_date;
        $version->to_date = $request->to_date;
        $version->body_type_id = $request->body_type;
        $version->cc = $request->cc;
        $version->kilowatt = $request->kw;
        $version->save();

        return redirect()->back()->with(['message' => 'Version added Successfully']);
    }

    public function deleteVersion(Request $request)
    {
        // dd($request->all());
        $del_version = Version::find($request->id);
        // dd($del_version);
        $del_version->delete();
        return response()->json(['success' => true, 'message' => 'Version Deleted successfully']);
    }

    // public function editVersion(Request $request)
    // {
    //     // dd($request->all());
    //     $e_version = Version::find($request->id);
    //     return response()->json(['success' => true , 'e_version' => $e_version]);
    // }

    public function editVersion($id)
    {
        $edit_version = Version::find($id);

        //$version_bodyTypes = BodyTypes::where('status',1)->get();

        $bodyTypesQuery    = BodyTypes::query()->select("body_type_id", "btd.name", "api_code", "image", "name_slug");
        $bodyTypesQuery->join('body_types_description AS btd', 'body_types.id', '=', 'btd.body_type_id')->where('language_id', 2);
        $version_bodyTypes         = $bodyTypesQuery->where('status', 1)->orderBy('btd.name', 'ASC')->get();

        $TransmissionTypesQuery    = Transmission::query()->select("transmission_id", "ttd.title", "api_code", "status");
        $TransmissionTypesQuery->join('transmission_description AS ttd', 'transmissions.id', '=', 'ttd.transmission_id')->where('language_id', 2);
        $version_TransmissionTypes         = $TransmissionTypesQuery->where('status', 1)->orderBy('ttd.title', 'ASC')->get();

        return view('admin.car_model_versions.edit', compact('edit_version', 'version_bodyTypes', 'version_TransmissionTypes'));
    }

    public function storeEditVersion(Request $request)
    {

        // $validator = $request->validate([
        //     'v_name' => 'required',            
        //     'v_from_date' => 'required',            
        //     'v_kw' => 'required',            
        //     'v_cc' => 'required',            
        //     'body_type' => 'required'           
        // ]);

        $edit_version = Version::find($request->version_id);
        $edit_version->label = $request->edit_label;

        $edit_version->transmission_label = $request->edit_transmission_label;
        $edit_version->extra_details = $request->edit_extra_details;
        $edit_version->engine_capacity = $request->edit_engine_capacity;
        $edit_version->engine_power = $request->edit_engine_power;
        $edit_version->from_date = $request->edit_fromDate;
        $edit_version->to_date = $request->edit_toDate;
        $edit_version->cc = $request->edit_cc;
        $edit_version->kilowatt = $request->edit_kilowatt;
        $edit_version->body_type_id = $request->edit_bodyType;
        $edit_version->car_length = $request->edit_length;
        $edit_version->car_width = $request->edit_width;
        $edit_version->car_height = $request->edit_height;
        $edit_version->weight = $request->edit_weight;
        $edit_version->wheel_base = $request->edit_wheelBase;
        $edit_version->ground_clearance = $request->edit_groundClearance;
        $edit_version->seating_capacity = $request->edit_seatingCapacity;
        $edit_version->fuel_tank_capacity = $request->edit_fuelTankCapacity;
        $edit_version->number_of_door = $request->edit_doors;
        $edit_version->displacement = $request->edit_displacement;
        $edit_version->torque = $request->edit_torque;
        $edit_version->gears = $request->edit_gears;
        $edit_version->max_speed = $request->edit_maxSpeed;
        $edit_version->acceleration = $request->edit_acceleration;
        $edit_version->number_of_cylinders = $request->edit_cylinders;
        $edit_version->front_wheel_size = $request->edit_frontWheelSize;
        $edit_version->back_wheel_size = $request->edit_backWheelSize;
        $edit_version->front_tyre_size  = $request->edit_frontTyreSize;
        $edit_version->back_tyre_size = $request->edit_backTyreSize;
        $edit_version->drive_type = $request->edit_driveType;
        $edit_version->fueltype = $request->edit_fueltype;
        $edit_version->average_fuel = $request->edit_averageFuel;
        $edit_version->transmissiontype = $request->edit_transmissionType;

        $edit_version->save();
        return redirect('admin/versions/' . $request->model_id . '/showall')->with('success', 'Updated Successfully');
    }
}
