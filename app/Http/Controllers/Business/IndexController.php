<?php

namespace App\Http\Controllers\Business;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    //
    public function index()
    {
        dd('Hi I am Business User '.Auth::user()->name,'Place all my routes in the defined groups and create login and register page for me');
    }
}
