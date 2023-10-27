<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\SparePartCategory;
use App\Models\SparePartCategoriesDescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Models\Language;

class SparePartsController extends Controller
{
    public function index()
    {   
        //this one is needed for editModal
        $parent_categories = SparePartCategory::where('parent_id',0)->where('status',1)->orderBy('title', 'ASC')->get();  
        $categories = SparePartCategory::where('parent_id',0)->where('status',1)->orderBy('title', 'ASC')->get();
        $parent_category = null;
        $languages = Language::all();  
    	return view('admin.spare-part-category', compact('categories','parent_categories','parent_category','languages'));
    }

public function editPart(Request $request)
    {
        // dd($request->all());
        $spareparts = SparePartCategoriesDescription::where('spare_part_category_id',$request->id)->get();
        // dd($spareparts);
        return response()->json(['success' => true , 'spareparts' => $spareparts]);
    }
    public function addPartCategory(Request $request)
    {
        // dd($request->all());
        $name = 'en_add_title';
		$category            = new SparePartCategory;
        if($request->image != null)
         {
            $image= $request->image;
            $imageName = 'partCategory-'.time().'-'.rand(000000,999999).'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/image/');
            $image->move($destinationPath, $imageName);
            $category->image = $imageName;
         } 
		$category->title     = $request->$name;
		$category->parent_id = $request->parent_id;
		$category->save();
        $languages = Language::all();
        foreach ($languages as $language) {
        
             $res_des = new SparePartCategoriesDescription;
              $title = $language->language_code.'_add_title';
                $res_des->title = @$request->$title;
                 $res_des->spare_part_category_id = $category->id;
                $res_des->language_id = $language->id;
                $res_des->save();

    }
        return Redirect::back()->with('message','Spare Part Added Successfully!');
          
    }

    public function updatePartCategory(Request $request)
    {
        // dd(@$request->all());
        $update_tag = SparePartCategory::where('id',$request->id)->first();
        $languages = Language::all(); 

        $file =Input::file('editimage');
        if($request->hasFile('editimage')) 
        {
            $update_tag->image=$request['editimage'];
            $name=$request['editimage']->getClientOriginalName();
            $extension=$request['editimage']->getClientOriginalExtension();
            $filename=date('m-d-Y').mt_rand(999,999999).'__'.time().'.'.$name/*.$extension*/;
            $request['editimage']->move(public_path('/uploads/image'),$filename);
            $update_tag->image = $filename;
        }
        else
        {
            $filename=null;
        }
         $sparepart_title = 'en_edit_title';
        $update_tag->title = $request->$sparepart_title;
        $update_tag->parent_id = $request->parent_id;
        $update_tag->save();

        foreach ($languages as $language) {
        $sparepart_description = SparePartCategoriesDescription::where('spare_part_category_id' , $request->id)->where('language_id', $language->id)->first();

        if(@$sparepart_description !== null){
        $sparepart_title = $language->language_code.'_edit_title';
        $sparepart_description->title = $request->$sparepart_title;

        $sparepart_description->language_id = $language->id;
        $sparepart_description->spare_part_category_id = $request->id;
        $sparepart_description->save();
        }else{
             $sparepart_description = new SparePartCategoriesDescription;
              $sparepart_title = $language->language_code.'_edit_title';
                $sparepart_description->title = $request->$sparepart_title;
                 $sparepart_description->spare_part_category_id = $request->id;
                $sparepart_description->language_id = $language->id;
                $sparepart_description->save();
        }
    }


        return Redirect::back()->with('message','Spare Part Category Updated Successfully!');
    } 

    public function deletePartCategory(Request $request)
    {   

        $del = SparePartCategory::where('id',$request->id)->orWhere('parent_id',$request->id)->first();
        $del->status = 0;
        $del->save();        
        return response()->json(['success' => true, 'message' => 'Spare Part Category Deleted successfully']);
    }

    public function getChilds($id)
    {
        $parent_categories = SparePartCategory::where('parent_id',0)->where('status',1)->where('status',1)->orderBy('title', 'ASC')->get();
    	$categories = SparePartCategory::where('parent_id',$id)->where('status',1)->orderBy('title', 'ASC')->get();
        $parent_category = SparePartCategory::where('id',$id)->first();  
     $languages = Language::all(); 
    	return view('admin.spare-part-category', compact('categories','parent_categories','parent_category','languages'));
    }

}
