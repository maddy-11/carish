<?php // Code within app\Helpers\Helper.php Mutahir Shah
namespace App\Helpers; 
use DB; 
use Redirect;
use App\City;
use App\Car;
use App\Year;
use App\Color;

class StaticHelpers
{ 
    public static function getCities($state = null){
        $cities = '';
        if($state == null){
            $cities = City::where('status',1)->get();
        } else {
            $cities = City::where('state_id', $state)->where('status',1)->get();
        }
        return $cities;        
    }

    public static function getCars($parent_id = 0)
    { 
        $cars = Car::where('parent_id', $parent_id)->get(); 
        return $cars;
    }

    public static function getColors()
    {
        $colors = Color::all();
        return $colors;
    }

    public static function getYears()
    {
        $years = Year::all();
        return $years;
    }

    
}
?>