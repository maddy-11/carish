<?php
namespace App\Helpers;
use App\User;   
use DB;
use App\City;
use App\VehicleType;
use App\Models\Cars\BodyTypes;
use App\CustomerMessages;
use Auth;
use App\Models\TransmissionDescription;
class Helper
{  

public function getCategoryOf($parent_id)
    {  
       #return Category::where('parent_id',$parent_id)->get();
    }

public  function countUsers($parent_id)
	{
		return User::where('parent_id',$parent_id)->count();

	}

public  function countAllUsers()
	{
		return User::where('parent_id',0)->where('id','<>',1)->count();

	} 
public  function getProduct($id)
	{ 
		try { 
    // Closures include ->first(), ->get(), ->pluck(), etc.
		} catch(\Illuminate\Database\QueryException $ex){ 
		  dd($ex->getMessage()); 
			$products = 0;
		  // Note any method of class PDOException can be called on $ex.
		}
		return $products;
	} 

 
public function countries()
	{
		//return  DB::table('countries')->get();
	}

public function getStates($country_id)
	{ 
		return  DB::table('states')->where('country_id',$country_id)->get();
	}

public function getCities($state_id)
	{ 
		return DB::table('cities')->where('state_id',$state_id)->get();
	}
public function colors()
	{
		$colors = array("hall"        => "Gray",
						"helekollane" => "Yellow",
						"helepruun"   => "Brown",
						"lilla"       => "Purple",
						"pruun"       => "Brown",
						"punane"      => "Red",
						"kuldne"      => "Golden",
						"helesinine"  => "Blue",
						"roosa"       => "Pink",
						"must"        => "Black",
						"tumesinine"  => "Blue"
					); 
		return $colors;
	}

public function bodyTypes($api_code)
	{ 
		$bodyResult      = BodyTypes::where('api_code',$api_code)->where('api_code',"!=","NULL")->count(); 
        return $bodyResult;
	}


public function engineTypes()
	{
		$engineTypes = array(
			"bensiin_kataly saator"  => "Petrol",
			"cng"                    => "CNG",
			"diisel"                 => "Diesel",
			"hybrid"                 => "Hybrid",
			"lpg"                    => "LPG",
			"petrol"                 => "Petrol",
			'bensiin'                => "Petrol"
		);
        return $engineTypes;
	}
	public function permittedCategories(){ 
        $vehicles =array();
		$activeLanguage  = \Session::get('language');
		$db_categories     = VehicleType::query()->select("vehicle_type_id", "cd.title");
		$db_categories->join('vehicle_type_details AS cd', 'vehicle_types.id', '=', 'cd.vehicle_type_id')->where('vehicle_types.status', 1)->where('cd.language_id',1);
		$categories = $db_categories->get();
		foreach($categories as $cat){
			$vehicles[] = $cat->title;}
		return $vehicles;
	}

	public function customerMessages(){
		$messages = CustomerMessages::distinct('from_id')->where('to_id',Auth::guard('customer')->user()->id)->orderBy('created_at','DESC')->limit(5)->groupBy('from_id')->get();
		return $messages;
	}

	public function countMessages(){
		$messages = CustomerMessages::where('to_id',Auth::guard('customer')->user()->id)->where('read_status',0)->count();
		return $messages;
	}

	public function getAdsTransmission($transmission_id = null)
	{
		$activeLanguage  = \Session::get('language');
		$title           = '';
		if($transmission_id !=null){
		$transmission    = TransmissionDescription::select('title')->where('transmission_id',$transmission_id)->where('language_id',$activeLanguage['id'])->first();
		if($transmission !=null){
			$title = $transmission->title;
		}
	}
		return $title;
	}
	

}
