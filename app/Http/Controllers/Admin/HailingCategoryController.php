<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cars\HailingCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cars\Make; 
use App\Year;
use Illuminate\Support\Facades\Redirect;

class HailingCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $years           = Year::all();
        $hailing         = HailingCategory::all();
        $HailingCategory = HailingCategory::all();
        return view('admin.hailing_category.index',compact('HailingCategory','years','hailing'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        echo 'Hi I am create';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data         = $request->all();
        $file         = $request->file('logo'); 
        $path         = $this->saveFile($file,$file->getClientOriginalName());
        $data['logo'] = $path;
        $data['slug'] = str_replace(" ","-",strtolower($data['name']));
        HailingCategory::create($data);
        return Redirect::back()->with('message','Category Added Successfully!');
    }

    private function saveFile($file,$orignalName)
    {
        $fileName = $file->storeAs('hailingCategory',$orignalName);
        if($fileName){
            $fileName = $orignalName;
        }
        return $fileName;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cars\HailingCategory  $hailingCategory
     * @return \Illuminate\Http\Response
     */
    public function show(HailingCategory $hailingCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cars\HailingCategory  $hailingCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(HailingCategory $hailingCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cars\HailingCategory  $hailingCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HailingCategory $hailingCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cars\HailingCategory  $hailingCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(HailingCategory $hailingCategory)
    {
        //
    }
}
