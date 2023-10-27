<?php

namespace App\Models\Cars;

use Illuminate\Database\Eloquent\Model;

class HailingCategory extends Model
{
    public    $timestamps  = true;
    protected $fillable = ['name', 'slug', 'status','hailing_category_id','logo'];
    protected $table    = "hailing_category";

     public function children(){
    	  return $this->hasMany( 'App\Models\Cars\HailingCategory', 'hailing_category_id', 'id' );
    	}

    public function parent(){
    	  return $this->hasOne( 'App\Models\Cars\HailingCategory', 'id', 'hailing_category_id' );
    	}

    	public function childrenCategories()
		{
		    return $this->hasMany(HailingCategory::class)->with('hailing_category');
		}
		/* if you call HailingCategory::with(hailing_category), it will get you one level of “children”, but HailingCategory::with(‘childrenCategories’) will give you as many levels as it could find.https://laraveldaily.com/eloquent-recursive-hasmany-relationship-with-unlimited-subcategories/*/
}
