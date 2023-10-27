<?php

namespace App\Http\Controllers\Admin;

use App\Ad;
use App\Car;
use App\CarYear;
use App\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CityController extends Controller
{
    public function addCity(Request $request)
    {
        $city=new City;
        $city->name=$request->title;
        $city->code=$request->code;
        $city->save();
        return Redirect::back();
          
    }

    public function index()
    {
        $cities = City::where('status',1)->orderBy('name','ASC')->get();
    	return view('admin.city', compact('cities'));
    }


     public function updateCity(Request $request)
    {

        $update_city=City::where('id',$request->id)->update([
            'name' => $request->edit_title,
            'code' => $request->edit_code
        
        ]);

        return Redirect::back();
    } 


 public function deleteCity(Request $request)
    {   

        $del=City::where('id',$request->id)->first();
        $del->status = 0;
        $del->save();
        
        return Redirect()->back()->with('city_deleted','City Deleted Successfully!');
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



}
