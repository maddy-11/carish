<?php

namespace App\Http\Controllers\Admin;

use App\Ad;
use App\Car;
use App\CarYear;
use App\Color;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\Language;
use App\ColorsDescription;

class ColorController extends Controller
{
    public function addColor(Request $request)
    {
        // dd($request->all());
        $title = 'en_add_title';
        $color = new Color;
        $color->name = $request->$title;
        $color->api_code = $request->code;
        $color->status = 1;
        $color->save();

        $languages = Language::all();
        foreach ($languages as $language) {
        
             $res_des = new ColorsDescription;
              $title = $language->language_code.'_add_title';
                $res_des->name = @$request->$title;
                 $res_des->color_id = $color->id;
                $res_des->language_id = $language->id;
                $res_des->save();

    }

        return Redirect::back()->with('message','Color Added Successfully!');
    }

    //
    public function index()
    {
    $colorsQuery    = Color::query()->select("color_id", "cd.name","api_code","status");
    $colorsQuery->join('colors_description AS cd', 'colors.id', '=', 'cd.color_id')->where('language_id', 2);
    $getcolors         = $colorsQuery->orderBy('cd.name', 'ASC')->orderBy('status', 'DESC')->get();

        $colors = Color::all();
        $languages = Language::all();
    	return view('admin.colors', compact('colors','languages','getcolors'));
    }


     public function updateColor(Request $request)
    {
        $title = 'en_edit_title';
        $update_color=Color::where('id',$request->id)->update([
            'api_code' => $request->edit_code
        ]);
        $update_tag = Color::where('id',$request->id)->first();
        $languages = Language::all(); 

        foreach ($languages as $language) {
        $color_description = ColorsDescription::where('color_id' , $request->id)->where('language_id', $language->id)->first();

        if(@$color_description !== null){
        $color_name = $language->language_code.'_edit_title';
        $color_description->name = $request->$color_name;

        $color_description->language_id = $language->id;
        $color_description->color_id = $request->id;
        $color_description->save();
        }else{
             $color_description = new ColorsDescription;
              $color_name = $language->language_code.'_edit_title';
                $color_description->name = $request->$color_name;
                 $color_description->color_id = $request->id;
                $color_description->language_id = $language->id;
                $color_description->save();
        }
    }
        return Redirect::back()->with('updated','Color Update Successfully!');
    } 


    public function deleteColor(Request $request)
    {   

        $del=Color::where('id',$request->id)->delete();
        
       return response()->json(['success' => true, 'message' => 'Color Deleted successfully']);
    }


    public function makers()
    {
        $cars = Car::where('parent_id',0)->get();
        $years = Year::all();
        return view('admin.makers',compact('cars','years'));
    }




    public function addMakers(Request $request)
    {   

        if($request->img!=null)
     {
        $image= $request->img;
        $imageName = 'car-'.time().'-'.rand(000000,999999).'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('/image/');
        $image->move($destinationPath, $imageName);
     }
        $car = new Car();
        $car->title = $request->title;
        $car->image = $imageName;
        $car->parent_id = 0;
        $car->save();

        foreach ($request->year as $year)
        {
            $car_year = new CarYear();
            $car_year->car_id = $car->id;
            $car_year->year_id = $year;
            $car_year->save();
        }
        return redirect('admin/makers');
    }

     public function editMaker(Request $request)
    {
       
        if($request->edit_img!= null || $request->edit_img!= '')
        {
           // dd($request->edit_img);
            $image= $request->edit_img;
            $imageName = 'profile-'.time().'-'.rand(000000,999999).'.'.$image->getClientOriginalExtension();
           // dd($imageName);
            $destinationPath = public_path('image/');
            $image->move($destinationPath, $imageName); 


            $maker=Car::where('id',$request->id)->first();
            $caryear=CarYear::where('car_id',$maker['id'])->delete();
            $carid=Car::where('id',$request->id)->first();
             $updatemaker=Car::where('id',$request->id)->Update([
           'title' =>$request->edit_title,
            'image' => $imageName

             ]);

           foreach ($request->edityear as $year)
        {
            $car_year = new CarYear();
            $car_year->car_id = $carid['id'];
            $car_year->year_id = $year;
            $car_year->save();
        }
            return Redirect::back();


        }else{
         $maker=Car::where('id',$request->id)->first();
         $caryear=CarYear::where('car_id',$maker['id'])->delete();
          $carid=Car::where('id',$request->id)->first();
        $updatemaker=Car::where('id',$request->id)->Update([
           'title' => $request->edit_title
             ]);

           foreach ($request->edityear as $year)
        {
            $car_year = new CarYear();
            $car_year->car_id = $carid['id'];
            $car_year->year_id = $year;
            $car_year->save();
        }
       
        return Redirect::back();
        }
    }


      public function deleteMaker(Request $request)
    {   $del=Car::where('id',$request->id)->first();
        $caryear=CarYear::where('car_id',$del['id'])->delete();
        $updateyear=Car::where('id',$request->id)->where('parent_id',$request->id)->delete();
        
        return Redirect::back();
    }










    public function models()
    {
        $models = Car::where('parent_id','!=',0)->get();
        $model1 = Car::where('parent_id',0)->get();
        $makers = Car::where('parent_id',0)->get();
        return view('admin.models',compact('models','makers','model1'));
    }

    public function addModel(Request $request)
    {

         if($request->image!=null)
     {
        $image= $request->image;
        $imageName = 'profile-'.time().'-'.rand(000000,999999).'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('/image/');
        $image->move($destinationPath, $imageName);
     }
        $car = new Car();
        $car->title = $request->title;
        $car->image = $imageName;
        $car->parent_id = $request->parent;
        $car->save();

        return redirect('admin/models');
    }

     public function editmodel(Request $request)
    {
       
    if($request->editimage!=null)
     {
        $image= $request->editimage;
        $imageName = 'profile-'.time().'-'.rand(000000,999999).'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('/image/');
        $image->move($destinationPath, $imageName);

        $car=Car::where('id',$request->id)->update([
            'title' => $request->edittitle,
            'image' => $imageName ,
            'parent_id' => $request->editparent
        ]);
        return back();
     }
      else
      {
        $car=Car::where('id',$request->id)->update([
            'title' => $request->edittitle,
            'parent_id' => $request->editparent
            
        ]);
        return back();
      }
        

        
    }


      public function deleteModel(Request $request)
    {   

        $del=Car::where('id',$request->id)->delete();
        
        return Redirect::back();
    }

    public function editColor(Request $request)
    {
        // dd($request->all());
        $spareparts = ColorsDescription::where('color_id',$request->id)->get();
        // dd($spareparts);
        return response()->json(['success' => true , 'spareparts' => $spareparts]);
    }



}
