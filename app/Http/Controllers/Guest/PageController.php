<?php

namespace App\Http\Controllers\Guest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Lang;
use App\Page;
use App\PageDescription;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('guest.pages');
    }

    public function TermOfService()
    {
      $activeLanguage = \Session::get('language');

      $page_descriptionQuery = Page::query()->select("pd.title", "pd.description");
      $page_descriptionQuery->join('page_desciption AS pd', 'pages.id', '=', 'pd.page_id')->where('pd.language_id', $activeLanguage['id']);
      $page_description = $page_descriptionQuery->where('page_id',1)->first();


      
      // dd($page_description_dealer);
        return view('guest.terms_of_services',compact('page_description'));
    } 

    public function UsefulInformation()
    {
      $activeLanguage = \Session::get('language');

      $page_descriptionQuery = Page::query()->select("pd.title", "pd.description");
      $page_descriptionQuery->join('page_desciption AS pd', 'pages.id', '=', 'pd.page_id')->where('pd.language_id', $activeLanguage['id']);
      $page_description = $page_descriptionQuery->where('page_id',10)->first();


      
      // dd($page_description_dealer);
        return view('guest.useful_information',compact('page_description'));
    } 


    public function PrivacyPolicy()
    {
      $activeLanguage = \Session::get('language');

      $page_descriptionQuery = Page::query()->select("pd.title", "pd.description");
      $page_descriptionQuery->join('page_desciption AS pd', 'pages.id', '=', 'pd.page_id')->where('pd.language_id', $activeLanguage['id']);
      $page_description = $page_descriptionQuery->where('page_id',2)->first();


      
      // dd($page_description_dealer);
        return view('guest.privacy_policy',compact('page_description'));
    }     

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
}
