<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Page;
use App\Models\Language;
use App\PageDescription;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index()
    {
    	$page_descriptions = PageDescription::where('language_id' , 2)->get();
        return view('admin.pages.index',compact('page_descriptions'));
    }

    public function create()
    {
        $languages = Language::all();

        return view('admin.pages.create',compact('languages'));
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'title' => 'required',
        //     'sort_order' => 'required',
        //     'description' => 'required'
        // ]);

        $page 				= new Page;
        $page->sort_order 	= $request->sort_order;
        // $page->slug   = $request->page_slug;
        $page->customer_id 	= 63;
        $page->save();

        $languages = Language::all();

        foreach ($languages as $language) {
            if($language->id == 2)
            {
                $pagetitle = $language->language_code.'_add_title';
                $page_title = $request->$page_title;

                $final_title = preg_replace('/\s+/', '_', $page_title);

                $page->slug = strtolower($final_title);
                $page->save();
            }
        $page_description = new PageDescription;
        $page_description->page_id = $page->id;

        $page_title = $language->language_code.'_add_title';
        $page_description->title = $request->$page_title;

        $page_content = $language->language_code.'_add_content'; 
        $page_description->description = $request->$page_content;



        $page_description->language_id = $language->id;
        $page_description->save();

            
        }


        return redirect()->route('list-pages')->with('successmsg', 'New Page added successfully');
    }

    public function edit($id)
    {
        $page = Page::find($id);
        $page_description = PageDescription::where('page_id',$id)->get();
        // dd($page , $page_description);

        $languages = Language::all();
        // dd($languages[0]->page_description);

        return view('admin.pages.edit',compact('page','page_description','languages'));

    }

    public function update(Request $request)
    {

        $page               = Page::find($request->page_id);
        $page->sort_order   = $request->sort_order;
        // $page->slug   = $request->page_slug;
        $page->save();

        $languages = Language::all();

        foreach ($languages as $language) {
            if($language->id == 2)
            {
                $pagetitle = $language->language_code.'_add_title';
                $page_title = $request->$page_title;

                $final_title = preg_replace('/\s+/', '_', $page_title);

                $page->slug = strtolower($final_title);
                $page->save();
            }
        $u_page_description = PageDescription::where('page_id', $request->page_id)->where('language_id', $language->id)->first();

        $page_title = $language->language_code.'_add_title';
        $u_page_description->title = $request->$page_title;

        $page_content = $language->language_code.'_add_content'; 
        $u_page_description->description = $request->$page_content;
        $u_page_description->save();
            
        }


        return redirect()->route('list-pages')->with('successmsg', 'Page edited successfully');
    }
}
