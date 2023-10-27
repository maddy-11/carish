<?php

namespace App\Http\Controllers\Admin;

use App\Ad;
use App\ServiceDetail;
use App\Models\Services;
use App\Models\ServiceImage;
use App\SparePartAd;
use App\SparePartAdImage;
use App\ServiceMessage;
use App\ServiceDescription;
use App\SparepartsAdsDescription;
use App\SparepartsAdsMessage;
use App\Car;
use App\CarYear;
use App\Http\Controllers\Controller;
use App\Imports\makesImport;
use App\Models\Cars\Carmodel;
use App\Models\Cars\Features;
use App\Models\Cars\BodyTypes;
use App\Models\Cars\Make;
use App\Models\Cars\Version;
use App\Year;
use Illuminate\Support\Facades\Input;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\VehicleTypeDetail;
use DB;
use App\AdMsg;
use App\AdImage;
use App\Models\AdDescription;
use App\Models\Language;
use App\BodyTypesDescription;
use App\Models\FeaturesDescription;
use Yajra\Datatables\Datatables;

class YearController extends Controller
{
    public function addYear(Request $request)
    {
        $year = new Year;
        $year->title = $request->title;
        $year->save();
        return Redirect::back()->with('message', 'Year Added Successfully!');
    }

    public function index()
    {
        $years = Year::all();
        return view('admin.years', compact('years'));
    }

    public function updateYear(Request $request)
    {

        $updateyear = Year::where('id', $request->id)->update([
            'title' => $request->edit_title
        ]);
        return Redirect::back()->with('message', 'Year Updated Successfully!');
    }

    public function makers()
    {
        $makers = Make::orderBy('title', 'ASC')->get();
        return view('admin.makers', compact('makers'));
    }

    public function addMakers(Request $request)
    {

        if ($request->img != null) {
            $image = $request->img;
            $imageName = 'car-' . time() . '-' . rand(000000, 999999) . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/image/');
            $image->move($destinationPath, $imageName);
        }
        $car = new Make();
        $car->title = $request->title;
        $car->status = $request->status;
        $car->image = $imageName;
        $car->save();
        return redirect('admin/makers')->with('message', 'Maker Added Successfully!');
    }

    public function editMaker(Request $request)
    {   
        $maker = Make::find($request->id);
        //$file  = Input::file('edit_img');
        if($request->hasFile('edit_img')) 
        {
            $maker->image=$request['edit_img'];
            $name=$request['edit_img']->getClientOriginalName();
            $extension=$request['edit_img']->getClientOriginalExtension();
            $filename=date('m-d-Y').mt_rand(999,999999).'__'.time().'.'.$name;
            $request['edit_img']->move(public_path('/uploads/image'),$filename);
            $maker->image = $filename;
        } else {
            $filename = null;
        }

        $maker->title  = $request->edit_title;
        $maker->status = $request->status;
        $maker->save();

        return Redirect::back()->with('message', 'Maker Updated Successfully!');;
    }

    public function deleteMaker(Request $request)
    {
        $maker = Make::where('id', $request->id)->first();
        $maker->status = 0;
        $maker->save();

        return response()->json(['success' => true, 'message' => 'Maker Disable successfully']);
    }

    public function updateMakeYear(Request $request){

        $car_makes = DB::table('car_make')->orderBy('name', 'ASC')->get();
        foreach($car_makes as $car_make)
        {  
            $model_IDs = array();
            $year_from = '';
            $year_to = '';
            $car_models = DB::table('car_model')->where('id_car_make',$car_make->id_car_make)->orderBy('name', 'ASC')->get();
            if (!$car_models->isEmpty())
            {
                foreach($car_models as $car_model)
                {
                    $model_IDs[] =  $car_model->id_car_model;
                }
                $genration_from = DB::table('car_generation')->whereIn('id_car_model',$model_IDs)->orderBy('year_begin', 'ASC')->first();
                if ($genration_from != null) 
                $year_from = $genration_from->year_begin;


                $genration_to = DB::table('car_generation')->whereIn('id_car_model',$model_IDs)->where('year_end',NULL)->first();
                if ($genration_to != null) 
                {
                    $year_to = $genration_to->year_end;
                }
                else{
                $genration_to = DB::table('car_generation')->whereIn('id_car_model',$model_IDs)->orderBy('year_end', 'DESC')->first();
                    if($genration_to != null)                    
                    $year_to =   $genration_to->year_end; 
                
                }

                $make = Make::where('title',$car_make->name)->first();
                $make->year_begin  = $year_from;
                $make->year_end = $year_to;
                $make->save();

                //dd($car_make->name,$model_IDs,$year_from,$year_to);
                //UPDATE `makes` SET `year_begin`=NULL,`year_end`=NULL WHERE 1
            }
        }


        return response()->json(['success' => true, 'message' => 'Make Year Update Successfully']);
    }
    public function activeMaker(Request $request)
    {
        $maker = Make::where('id', $request->id)->first();
        $maker->status = 1;
        $maker->save();

        return response()->json(['success' => true, 'message' => 'Maker Active successfully']);
    }

    public function models()
    {
        // dd('here');
        $makers = make::where('status', 1)->orderBy('title', 'ASC')->get();
        $vehicle_types = VehicleTypeDetail::whereHas('vehicle_type', function ($q) {
            $q->where('status', 1);
        })->where('language_id', 2)->get();
        $models = $model1 = $makers;
        $make_models = Carmodel::where('status', 1)->orderBy('name', 'ASC')->get();
        return view('admin.models', compact('models', 'makers', 'model1', 'make_models', 'vehicle_types'));
    }

    public function makerModels($make_id)
    {
        // dd($make_id);
        $makers = make::where('status', 1)->orderBy('title', 'ASC')->get();
        $maker = Make::where('id', $make_id)->first();
        // dd($maker);
        $vehicle_types = VehicleTypeDetail::whereHas('vehicle_type', function ($q) {
            $q->where('status', 1);
        })->where('language_id', 2)->get();
        $make_models = Carmodel::where('make_id', $make_id)->orderBy('name', 'ASC')->get();
        // dd($make_models->count());
        $models = $model1 = $makers;
        $make_id =  $make_id;

        return view('admin.models', compact('maker', 'models', 'makers', 'model1', 'make_models', 'vehicle_types'));
    }

    public function addModel(Request $request)
    {
        $car = new Carmodel();
        $car->name = $request->title;
        $car->make_id = $request->parent;
        $car->vehicle_type_id = $request->vehicle_type_id;
        $car->save();

        return redirect('admin/models')->with('message', 'Model Added Successfully!');
    }

    public function uploadModelsFile(Request $request)
    {
        //makesImport
        Excel::import(new makesImport, $request->file('excel'));
        // Excel::import(new uploadExcel,$path);
        return redirect()->back()->with('successmsg', 'Excel Uploaded successfully');
    }

    public function getEditmodel(Request $request)
    {
        $model = Carmodel::find($request->id);
        return response()->json(['success' => true, 'model' => $model]);
    }

    public function editmodel(Request $request)
    {
        // dd($request->all());

        $car = Carmodel::where('id', $request->make_model_id)->update([
            'name' => $request->edittitle,
            'vehicle_type_id' => $request->e_vehicle_type_id,
            'make_id' => $request->editparent

        ]);
        return back()->with('message', 'Model Updated Successfully!');
    }

    public function deleteModel(Request $request)
    {

        // $ads = Ad::where('model_id',$request->id)->first();
        // if($ads != null)
        // {
        // return response()->json(['success' => false, 'message' => 'Model cannot be deleted because it is used in ads']);

        // }
        // $versions = Version::where('model_id' , $request->id)->delete();

        $del = Carmodel::where('id', $request->id)->first();
        $del->status = 0;
        $del->save();

        return response()->json(['success' => true, 'message' => 'Model Deleted successfully']);
    }



    public function deleteRemovedAdModel(Request $request)
    {
        $ads_msgs = AdMsg::where('ad_id', $request->id)->delete();

        $ads_description = AdDescription::where('ad_id', $request->id)->delete();

        $ads_features = DB::table('ad_features')->where('ad_id', $request->id)->delete();

        $ads_imgs = AdImage::where('ad_id', $request->id)->delete();

        $ads_sugggestions = DB::table('ad_suggesstion')->where('ad_id', $request->id)->delete();

        $ads_tag = DB::table('ad_tag')->where('ad_id', $request->id)->delete();

        $ads = Ad::where('id', $request->id)->delete();

        return response()->json(['success' => true, 'message' => 'Ad Deleted successfully']);
    }

    public function deleteAllRemovedAdModel(Request $request)
    {
        // dd($request->all());
        $ad_id_array = $request->input('id');

        $ads_msgs = AdMsg::whereIn('ad_id', $ad_id_array)->delete();

        $ads_description = AdDescription::whereIn('ad_id', $ad_id_array)->delete();

        $ads_features = DB::table('ad_features')->whereIn('ad_id', $ad_id_array)->delete();

        $ads_imgs = AdImage::whereIn('ad_id', $ad_id_array)->delete();

        $ads_sugggestions = DB::table('ad_suggesstion')->whereIn('ad_id', $ad_id_array)->delete();

        $ads_tag = DB::table('ad_tag')->whereIn('ad_id', $ad_id_array)->delete();

        $ads = Ad::whereIn('id', $ad_id_array)->delete();

        return response()->json(['success' => true, 'message' => 'Ads Deleted successfully']);
    }

    public function deleteRemovedPartAdModel(Request $request)
    {


        $part_imgs = SparePartAdImage::where('spare_part_ad_id', $request->id)->delete();
        //for image delet call this removeSparePartImage function in customer controller.

        $part_description = SparePartAdTitle::where('spare_part_ad_id', $request->id)->delete();

        $part_description = SparepartsAdsDescription::where('spare_part_ad_id', $request->id)->delete();

        $part_msgs = SparepartsAdsMessage::where('spare_parts_ads_id', $request->id)->delete();

        $parts = SparePartAd::where('id', $request->id)->delete();

        return response()->json(['success' => true, 'message' => 'SparePartAd Deleted successfully']);
    }

    public function deleteAllRemovedPartAdModel(Request $request)
    {
        // dd($request->all());
        $part_id_array = $request->input('id');

        $part_imgs = SparePartAdImage::whereIn('spare_part_ad_id', $part_id_array)->delete();

        $part_description = SparepartsAdsDescription::whereIn('spare_part_ad_id', $part_id_array)->delete();

        $part_msgs = SparepartsAdsMessage::whereIn('spare_parts_ads_id', $part_id_array)->delete();

        $part = SparePartAd::whereIn('id', $part_id_array)->delete();

        return response()->json(['success' => true, 'message' => 'SpareParts Deleted successfully']);
    }


    public function deleteRemovedServiceModel(Request $request)
    {
        $service_msgs = ServiceMessage::where('services_id', $request->id)->delete();

        $service_description = ServiceDescription::where('service_id', $request->id)->delete();

        $service_imgs = ServiceImage::where('service_id', $request->id)->delete();

        $service_detail = ServiceDetail::where('service_id', $request->id)->delete();

        $services = Services::where('id', $request->id)->delete();

        return response()->json(['success' => true, 'message' => 'Service Deleted successfully']);
    }

    public function deleteAllRemovedServiceModel(Request $request)
    {
        // dd($request->all());
        $service_id_array = $request->input('id');

        $service_msgs = ServiceMessage::whereIn('services_id', $service_id_array)->delete();

        $service_description = ServiceDescription::whereIn('service_id', $service_id_array)->delete();

        $service_imgs = ServiceImage::whereIn('service_id', $service_id_array)->delete();

        $service_detail = ServiceDetail::whereIn('service_id', $service_id_array)->delete();

        $services = Services::whereIn('id', $service_id_array)->delete();

        return response()->json(['success' => true, 'message' => 'Service Deleted successfully']);
    }

    public function modelsMassRemove(Request $request)
    {
        // dd($request->all());
        foreach ($request->id as $model_id) {
            $ads = Ad::where('model_id', $model_id)->first();
            $car_model = Carmodel::where('id', $model_id)->first();

            if ($ads != null) {
                return response()->json(['success' => false, 'model' => $car_model->name]);
            }
            $versions = Version::where('model_id', $model_id)->delete();

            $del = Carmodel::where('id', $model_id)->delete();
        }
        return response()->json(['success' => true, 'message' => 'Models Deleted successfully']);
    }

    public function features()
    {
        $languages = Language::all();
        $features = Features::where('status', 1)->orderBy('name', 'ASC')->get();


        return view('admin.features', compact('features', 'languages'));
    }

    public function addFeature(Request $request)
    {
        //dd($request->all());
        $title = 'en_add_title';
        $feature = new Features();
        if ($request->image != null) {
            $image = $request->image;
            $imageName = 'feature-' . time() . '-' . rand(000000, 999999) . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/image/');
            $image->move($destinationPath, $imageName);
            $feature->image = $imageName;
        }
        $feature->name = $request->$title;
        $feature->name_slug = $request->name_slug;
        $feature->save();

        $languages = Language::all();
        foreach ($languages as $language) {

            $res_des = new FeaturesDescription;
            $title = $language->language_code . '_add_title';
            $res_des->name = @$request->$title;
            $res_des->feature_id = $feature->id;
            $res_des->language_id = $language->id;
            $res_des->save();
        }

        return redirect('admin/features')->with('message', 'Features Added Successfully!');
    }

    public function deleteFeature(Request $request)
    {

        // $ads = Ad::where('model_id',$request->id)->first();
        // if($ads != null)
        // {
        // return response()->json(['success' => false, 'message' => 'Model cannot be deleted because it is used in ads']);

        // }
        // $versions = Version::where('model_id' , $request->id)->delete();

        $del = Features::where('id', $request->id)->first();
        $del->status = 0;
        $del->save();

        return response()->json(['success' => true, 'message' => 'Feature Deleted successfully']);
    }

    public function editFeature(Request $request)
    {
        // dd($request->all());
        $spareparts = FeaturesDescription::where('feature_id', $request->id)->get();
        // dd($spareparts);
        return response()->json(['success' => true, 'spareparts' => $spareparts]);
    }

    public function updateFeature(Request $request)
    {
        $title = 'en_edit_title';
        // dd($request->all());
        // $update_color=Feature::where('id',$request->id)->update([
        //     'name_' => $request->edit_code,
        //     'status'  => $request->status
        // ]);
        $feature = Features::where('id', $request->id)->first();
        $feature->name_slug = $request->editSlug;
        $file = Input::file('editimage');
        if ($request->hasFile('editimage')) {
            $feature->image = $request['editimage'];
            $name = $request['editimage']->getClientOriginalName();
            $extension = $request['editimage']->getClientOriginalExtension();
            $filename = date('m-d-Y') . mt_rand(999, 999999) . '__' . time() . '.' . $name/*.$extension*/;
            $request['editimage']->move(public_path('/uploads/image/'), $filename);
            $feature->image = $filename;
        } else {
            $filename = null;
        }
        $feature->status = 1;
        $feature->name = $request->$title;
        $feature->save();
        // $update_tag = Color::where('id',$request->id)->first();
        $languages = Language::all();

        foreach ($languages as $language) {
            $feature_description = FeaturesDescription::where('feature_id', $request->id)->where('language_id', $language->id)->first();

            if (@$feature_description !== null) {
                $feature_name = $language->language_code . '_edit_title';
                $feature_description->name = $request->$feature_name;

                $feature_description->language_id = $language->id;
                $feature_description->feature_id = $request->id;
                $feature_description->save();
            } else {
                $feature_description = new FeaturesDescription;
                $feature_name = $language->language_code . '_edit_title';
                $feature_description->name = $request->$feature_name;
                $feature_description->feature_id = $request->id;
                $feature_description->language_id = $language->id;
                $feature_description->save();
            }
        }
        return Redirect::back()->with('updated', 'Feature Updated Successfully!');
    }

    public function bodyTypes()
    {
        $bodyTypesQuery    = BodyTypes::query()->select("body_type_id", "btd.name", "api_code", "image", "name_slug");
        $bodyTypesQuery->join('body_types_description AS btd', 'body_types.id', '=', 'btd.body_type_id')->where('language_id', 2);
        $getbodyTypes         = $bodyTypesQuery->where('status', 1)->orderBy('btd.name', 'ASC')->get();

        $bodyTypes = BodyTypes::where('status', '1')->orderBy('name', 'ASC')->get();
        // dd($bodyTypes);
        $languages = Language::all();
        return view('admin.bodyTypes', compact('bodyTypes', 'languages', 'getbodyTypes'));
    }

    public function deleteBodyType(Request $request)
    {

        // $ads = Ad::where('model_id',$request->id)->first();
        // if($ads != null)
        // {
        // return response()->json(['success' => false, 'message' => 'Model cannot be deleted because it is used in ads']);

        // }
        // $versions = Version::where('model_id' , $request->id)->delete();

        $del = BodyTypes::where('id', $request->id)->first();
        $del->status = 0;
        $del->save();

        return response()->json(['success' => true, 'message' => 'Body Type Deleted successfully']);
    }

    public function addBodyType(Request $request)
    {
        // dd($request->all());
        $title = 'en_add_title';
        $bodyType = new BodyTypes();
        if ($request->image != null) {
            $image = $request->image;
            $imageName = 'bodyType-' . time() . '-' . rand(000000, 999999) . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/image/');
            $image->move($destinationPath, $imageName);
            $bodyType->image = $imageName;
        }
        $bodyType->name = $request->$title;
        $bodyType->name_slug = strtolower(preg_replace('/\s+/', '_', $request->$title));
        $bodyType->api_code = $request->code;
        $bodyType->status = 1;
        $bodyType->save();

        $languages = Language::all();
        foreach ($languages as $language) {

            $res_des = new BodyTypesDescription;
            $title = $language->language_code . '_add_title';
            $res_des->name = @$request->$title;
            $res_des->body_type_id = $bodyType->id;
            $res_des->language_id = $language->id;
            $res_des->save();
        }

        return redirect('admin/body-types')->with('message', 'BodyType Added Successfully!');
    }

    public function editBodyType(Request $request)
    {
        //dd($request->all());
        $title = 'en_edit_title';
        $bodyType = BodyTypes::find($request->id);

        $file = Input::file('editimage');
        if ($request->hasFile('editimage')) {
            $bodyType->image = $request['editimage'];
            $name = $request['editimage']->getClientOriginalName();
            $extension = $request['editimage']->getClientOriginalExtension();
            $filename = date('m-d-Y') . mt_rand(999, 999999) . '__' . time() . '.' . $name/*.$extension*/;
            $request['editimage']->move(public_path('/uploads/image'), $filename);
            $bodyType->image = $filename;
        } else {
            $filename = null;
        }
        // $bodyType->name_slug = $request->editSlug;
        $bodyType->api_code = $request->edit_code;
        $bodyType->save();

        $languages = Language::all();

        foreach ($languages as $language) {
            $bodyType_description = BodyTypesDescription::where('body_type_id', $request->id)->where('language_id', $language->id)->first();

            if (@$bodyType_description !== null) {
                $bodyType_name = $language->language_code . '_edit_title';
                $bodyType_description->name = $request->$bodyType_name;

                $bodyType_description->language_id = $language->id;
                $bodyType_description->body_type_id = $request->id;
                $bodyType_description->save();
            } else {
                $bodyType_description = new BodyTypesDescription;
                $bodyType_name = $language->language_code . '_edit_title';
                $bodyType_description->name = $request->$bodyType_name;
                $bodyType_description->body_type_id = $request->id;
                $bodyType_description->language_id = $language->id;
                $bodyType_description->save();
            }
        }

        return redirect('admin/body-types')->with('updated', 'BodyType updated Successfully!');
    }

    public function getEditBodyType(Request $request)
    {
        // dd($request->all());
        $spareparts = BodyTypesDescription::where('body_type_id', $request->id)->get();
        // dd($spareparts);
        return response()->json(['success' => true, 'spareparts' => $spareparts]);
    }

    public function getModels(Request $request)
    {
        // dd('hi');
        // $query = User::with('getCompany')->orderBy('role_id')->with('roles')->select('users.*')->get();
        if ($request->make_id == null) {
            $query = Carmodel::where('status', 1)->orderBy('name', 'ASC');
        } else {
            $query = Carmodel::where('status', 1)->where('make_id', $request->make_id)->orderBy('name', 'ASC');
        }
        return Datatables::of($query)

            ->addColumn('checkbox', function ($item) {

                return '<input type="checkbox"  value="' . $item->id . '" class="student_checkbox" name="student_checkbox[]">';
            })

            ->addColumn('action', function ($item) {
                $html_string = '';

                $html_string = '<div class="d-flex text-center">
                            <a data-toggle="modal" class="actionicon bg-info editaction"  data-id = "' . $item->id . '"><i class="fa fa-pencil"></i></a>

                            <a data-toggle="modal"  class="actionicon bg-danger deleteaction delete-btn" data-id = "' . $item->id . '"><i class="fa fa-close"></i></a>
                            <a class="actionicon bg-primary viewaction" href = "' . url('admin/versions/' . $item->id . '/showall') . '"><i class="fa fa-eye"></i></a>
                            <a href=""></a>
                          </div>';
                return $html_string;
            })

            ->addColumn('model_name', function ($item) {
                return @$item->name != null ? @$item->name : '--';
            })

            ->addColumn('maker', function ($item) {
                $num = $item->make !== null ? $item->make->title : '--';
                return $num;
            })

            ->addColumn('maker_image', function ($item) {
                if ($item->make->image != null) {
                    $html_string = '<img src="' . asset('public/uploads/image/' . $item->make->image) . '" alt="carish used cars for sale in estonia" style="height:50px; width:50px; margin-right:1rem;">';
                } else {
                    $html_string = '<img src="' . asset('public/uploads/image/car.png') . '" alt="carish used cars for sale in estonia" style="height:50px; width:50px; margin-right:1rem;">';
                }
                return $html_string;
            })

            ->addColumn('version', function ($item) {
                $html_string = '<a target="_blank" href="' . url('admin/versions/' . $item->id . '/showall') . '">' . $item->getVersionCount($item->id) . '</a>';
                return $html_string;
            })
            ->rawColumns(['checkbox', 'action', 'model_name', 'maker', 'maker_image', 'version'])
            ->make(true);
    }
}
