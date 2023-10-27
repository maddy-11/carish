<?php

namespace App\Http\Controllers\Admin;

use App\Ad;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    //
    public function index()
    {
    	$pending = Ad::where('status',0)->count();
    	$active = Ad::where('status',1)->orWhere('status',2)->count();
        return view('admin.index',compact('pending','active'));
    }
}
