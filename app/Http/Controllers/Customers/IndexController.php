<?php

namespace App\Http\Controllers\Customers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function __construct()
   {
       $this->middleware('auth:customer');
   }

    public function index(){
    	 return view('home');
    }
}
