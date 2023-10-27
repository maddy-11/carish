<?php

namespace App\Http\Controllers\Admin;

use App\Ad;
use App\Car;
use App\CarYear;
use App\Tag;
use App\Models\Cars\Carmodel;
use App\Models\Cars\Make;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\Language;
use App\Models\TagDescription;
use App\Suggesstion;

class TagController extends Controller
{
    public function addTag(Request $request)
    {
        $request  = $request->all();
        $tags     = Tag::create($request);
        $descripts = $request;

        if ($tags) {
        if(!empty($request)){
            for($i=1; $i<=count($request['name']);$i++)
            {
                $tag_description = array('name' => $request['name'][$i], 'code'=> $request['code'][$i], 'tag_id' => $tags->id, 'language_id'=>$i);
                TagDescription::create($tag_description);
            }
        }

        }
        return Redirect::back()->with('message','Tag Added Successfully!');
          
    }

    //
    public function index()
    {
        $active_language = \Session::get('language'); 
        $language_id    = $active_language['id'];

        $tags      = Tag::where('status',1)->get();
        $makes     = make::where('status',1)->get();
        $languages = Language::all();
        $suggessionsQuery = Suggesstion::query()->where('status',1);
        $select_array     = array('s.title', 's.suggesstion_id', 's.language_id');
        $suggessionsQuery->select($select_array);
        $suggessionsQuery->join('suggesstion_descriptions AS s', 's.suggesstion_id', '=', 'suggesstions.id');
        $suggessionsQuery->where('language_id','=', 2);
        $suggessions =  $suggessionsQuery->get();
    	return view('admin.tag', compact('tags', 'makes', 'languages', 'language_id', 'suggessions'));
    }
    public function getModels(){
        $data    = request()->all();
        $make_id = $data['id'];
        $models  = Carmodel::where('make_id','=',$make_id)->get();
        $html    = "";
        
        if(!$models->isEmpty())
        {
            foreach($models as $model){
                $html .= "<option value='".$model->id."'>".$model->name."</option>";
            }
        } 
        return $html;
    }

     public function updateTag(Request $request)
    {
        // dd($request->all());
        $update_tag = Tag::find($request->id);
        $update_tag->make_id = $request->make_id;
        $update_tag->model_id = $request->model_id;
        $update_tag->average_fuel = $request->average_fuel;
        $update_tag->mileage_total = $request->mileage_total;
        $update_tag->mileage_per_year = $request->mileage_per_year;
        $update_tag->suggesstion_id = $request->suggesstion_id;
        $update_tag->save();

        $languages = Language::all();

        foreach ($languages as $language) {
             $tag_description = TagDescription::where('language_id',$language->id)->where('tag_id',$update_tag->id)->first();

             $tag_name = 'name_'.$language->language_code;
             $code_name = 'code_'.$language->language_code;
             // $tag_description->name = $request->$tag_name;
             // $tag_description->code = $request->$code_name;
             // $tag_description->save();
             // dd($tag_description);

             \DB::table('tag_description')->where(['language_id' => $language->id, 'tag_id' => $update_tag->id])->update([
            'name' => $request->$tag_name,
            'code' => $request->$code_name
        ]);
         } 


        return Redirect::back()->with('message','Tag Updated Successfully!');
    } 

    public function deleteTag(Request $request)
    {   

        $del=Tag::where('id',$request->id)->first();
        $del->status = 0;
        $del->save();        
        return response()->json(['success' => true, 'message' => 'Tag Deleted successfully']);
    }

}
