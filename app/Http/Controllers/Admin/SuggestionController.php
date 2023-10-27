<?php

namespace App\Http\Controllers\Admin;

use App\Ad;
use App\Car;
use App\CarYear;
use App\Suggesstion;
use App\SuggestionDescriptions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\Language;

class SuggestionController extends Controller
{
    public function addSuggesstion(Request $request)
    {
        // dd($request->all());
        // dd($languages);
        $add_suggestion = new Suggesstion;
        $add_suggestion->save();

        $suggestion_desc_en = new SuggestionDescriptions;
        $suggestion_desc_en->suggesstion_id = $add_suggestion->id;
        $suggestion_desc_en->title = $request->en_add_title;
        $suggestion_desc_en->sentence = $request->en_add_suggestion;
        $suggestion_desc_en->language_id = 2;
        $suggestion_desc_en->save();

        $suggestion_desc_ru = new SuggestionDescriptions;
        $suggestion_desc_ru->suggesstion_id = $add_suggestion->id;
        $suggestion_desc_ru->title = $request->ru_add_title;
        $suggestion_desc_ru->sentence = $request->ru_add_suggestion;
        $suggestion_desc_ru->language_id = 3;
        $suggestion_desc_ru->save();

        $suggestion_desc_et = new SuggestionDescriptions;
        $suggestion_desc_et->suggesstion_id = $add_suggestion->id;
        $suggestion_desc_et->title = $request->et_add_title;
        $suggestion_desc_et->sentence = $request->et_add_suggestion;
        $suggestion_desc_et->language_id = 1;
        $suggestion_desc_et->save();
            
        return Redirect::back()->with('message','Suggesstion Added Successfully!');
          
    }

    //
    public function index()
    {
        $suggestions = Suggesstion::where('status',1)->get();
        $suggestion_decs = SuggestionDescriptions::whereHas('suggestion',function($q){
            $q->where('status',1);
        })->where('language_id' ,2)->get();
        $languages = Language::all();
    	return view('admin.suggestion', compact('suggestions','languages','suggestion_decs'));
    }


     public function updateSuggestion(Request $request)
    {
        // dd($request->all());
        
        $languages = Language::all();

        foreach ($languages as $language) {
        $suggestion_description = SuggestionDescriptions::where('suggesstion_id' , $request->suggestion_id)->where('language_id', $language->id)->first();

        $suggestion_title = $language->language_code.'_edit_title';
        $suggestion_description->title = $request->$suggestion_title;

        $suggestion_sentence = $language->language_code.'_edit_suggestion'; 
        $suggestion_description->sentence = $request->$suggestion_sentence;



        $suggestion_description->language_id = $language->id;
        $suggestion_description->save();
        }

        return redirect()->route('admin-suggestions')->with('message', 'Suggestion updated successfully');
    } 

    public function editSuggestion(Request $request)
    {
        // dd($request->all());
        $e_suggesstion = SuggestionDescriptions::where('suggesstion_id',$request->id)->get();
        // dd($e_suggesstion);
        return response()->json(['success' => true , 'e_suggesstion' => $e_suggesstion]);
    }


    public function deleteSuggestion(Request $request)
    { 
        $del=Suggesstion::where('id',$request->id)->first();
        // $del_sug_desc=SuggestionDescriptions::where('suggesstion_id',$request->id)->delete();
        $del->status = 0;
        $del->save();
        return response()->json(['success' => true, 'message' => 'Suggesstion Deleted successfully']);
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
