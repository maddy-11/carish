<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Faq\Faq;
use App\Models\Faq\FaqsDescription;
use App\Models\Faq\FaqCategory;
use App\Models\Faq\FaqCategoryDescription;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class FaqsController extends Controller
{
    public function index()
    {
    
    $faqsQuery = Faq::query()->select("faq_category_id","fd.faq_id", "fd.question","fd.answer","fd.language_id");
    $faqsQuery->join('faqs_description AS fd', 'faqs.id', '=', 'fd.faq_id')->where('status', 1)->where('language_id', 2);
    $getfaqs = $faqsQuery->orderBy('fd.question', 'ASC')->get();
    //dd($getfaqs);


    	$faq_descriptions = FaqsDescription::where('language_id' , 2)->get();
        return view('admin.faqs.index',compact('faq_descriptions','getfaqs'));
    }

    public function create()
    {
        $languages = Language::all();
        $faq_category_decs = FaqCategoryDescription::whereHas('FaqCategory',function($q){
            $q->where('status',1);
        })->where('language_id' ,2)->get();
        return view('admin.faqs.create',compact('languages','faq_category_decs'));
    }

    public function store(Request $request)
    {
        $faq = new Faq;
        $faq->faq_category_id 	= $request->faq_category_id;
        $faq->status = 1;
        $faq->save();

        $languages = Language::all();

        foreach ($languages as $language) {
           
        $faq_description = new FaqsDescription;
        $faq_description->faq_id = $faq->id;

        $faq_question = $language->language_code.'_question';
        $faq_description->question = $request->$faq_question;

        $faq_answer = $language->language_code.'_answer'; 
        $faq_description->answer = $request->$faq_answer;

        $faq_description->language_id = $language->id;
        $faq_description->save();

        }


        return redirect()->route('list-faqs')->with('successmsg', 'New Faq added successfully');
    }

    public function edit($id)
    {
        $faq = Faq::find($id);
        $faq_description = FaqsDescription::where('faq_id',$id)->get();
        $languages = Language::all();

        $faq_category_decs = FaqCategoryDescription::whereHas('FaqCategory',function($q){
            $q->where('status',1);
        })->where('language_id' ,2)->get();

        return view('admin.faqs.edit',compact('faq','faq_description','languages','faq_category_decs'));

    }

    public function update(Request $request)
    {

        $faq               = Faq::find($request->faq_id);
        $faq->faq_category_id   = $request->faq_category_id;
        $faq->save();

        $languages = Language::all();

        foreach ($languages as $language) {
 
        $faq_description = FaqsDescription::where('faq_id', $request->faq_id)->where('language_id', $language->id)->first();

        $faq_question = $language->language_code.'_question';
        $faq_description->question = $request->$faq_question;

        $faq_answer = $language->language_code.'_answer'; 
        $faq_description->answer = $request->$faq_answer;

        $faq_description->save();
            
        }


        return redirect()->route('list-faqs')->with('successmsg', 'Faq edited successfully');
    }

    public function FaqCategories()
    {
        $faq_categories = FaqCategory::where('status',1)->get();
        $faq_category_decs = FaqCategoryDescription::whereHas('FaqCategory',function($q){
            $q->where('status',1);
        })->where('language_id' ,2)->get();
        //dd($faq_category_decs);
        $languages = Language::all();
        return view('admin.faqs.faq_categories', compact('faq_categories','languages','faq_category_decs'));
    }

    public function addFaqCategories(Request $request)
    {
        // dd($request->all());
        $name = 'en_add_title';
        $faqcategory= new FaqCategory;

        if($request->edit_image != null)
         {
            $image= $request->edit_image;
            $imageName = 'faqCategory-'.time().'-'.rand(000000,999999).'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/image/');
            $image->move($destinationPath, $imageName);
            $faqcategory->image = $imageName;
         } 
       

        $faqcategory->status    = 1;
       // $faqcategory->image     = $request->edit_image;
        $faqcategory->save();

         $languages = Language::all();
        foreach ($languages as $language) {
        
             $res_des = new FaqCategoryDescription;
              $title = $language->language_code.'_add_title';
                $res_des->title = @$request->$title;
                 $res_des->faq_category_id = $faqcategory->id;
                $res_des->language_id = $language->id;
                $res_des->save();

    }
        return Redirect::back()->with('message','Faq Category Added Successfully!');
    }

    public function editfaqcatget(Request $request)
    {
        $faq_categories_descp = FaqCategoryDescription::where('faq_category_id',$request->id)->get();
        return response()->json(['success' => true , 'faq_categories_descp' => $faq_categories_descp]);
    }
    public function editFaqCategories(Request $request)
    {
        // dd($request->all());
        $faqcategory=FaqCategory::find($request->id);
        $languages = Language::all(); 
      if($request->edit_image!=null)
         {
            $image= $request->edit_image;
            $imageName = 'car-'.time().'-'.rand(000000,999999).'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/image/');
            $image->move($destinationPath, $imageName);
            $faqcategory->image     = $imageName;
         }
        $faqcategory->status    = 1;        
        $faqcategory->save();

        foreach ($languages as $language) {
        $FaqCategoryDescription = FaqCategoryDescription::where('faq_category_id' , $request->id)->where('language_id', $language->id)->first();

        if(@$FaqCategoryDescription !== null){
        $title_prefix = $language->language_code.'_edit_title';
        $FaqCategoryDescription->title = $request->$title_prefix;
        $FaqCategoryDescription->language_id = $language->id;
        $FaqCategoryDescription->faq_category_id = $request->id;
        $FaqCategoryDescription->save();
        }else{
        $FaqCategoryDescription = new FaqCategoryDescription;
        $title_prefix = $language->language_code.'_edit_title';
        $FaqCategoryDescription->title = $request->$title_prefix;
        $FaqCategoryDescription->faq_category_id = $request->id;
        $FaqCategoryDescription->language_id = $language->id;
        $FaqCategoryDescription->save();
        }
    }
        return Redirect::back()->with('message','Faq Category Updated Successfully!');
    }
    public function deleteFaqCategories(Request $request)
    {   
        $del = FaqCategory::where('id',$request->id)->first();
        $del->status = 0;
        $del->save(); 
        \DB::table('faqs')->where(['faq_category_id' => $request->id])->update(['status' => 0]);
        return response()->json(['success' => true, 'message' => 'Faq Category Deleted successfully']);
    }
    public function deleteFaq(Request $request)
    {   
    
    $del = Faq::where('id',$request->id)->delete();
    \DB::table('faqs_description')->where(['faq_id' => $request->id])->delete();

   /* $faqsQuery = Faq::query()->select("fd.faq_id");
    $faqsQuery->join('faqs_description AS fd', 'faqs.id', '=', 'fd.faq_id')->where('faq_id', $request->id);
    $getfaqs = $faqsQuery->delete();*/

        return response()->json(['success' => true, 'message' => 'Faq Deleted successfully']);
    }
}