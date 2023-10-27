<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SparePartCategory extends Model
{
    /* public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->belongsTo(self::class, 'parent_id','id');
    } {{@$sparePart->parent_category->title.'/'.@$sparePart->category->title}}*/
        /*public function parent_category(){
        return $this->belongsTo('App\SparePartCategory','parent_id','id');
    }*/




    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->hasOne(self::class, 'id', 'parent_id');
    }

     public function get_category_title(){
        return $this->hasMany('App\Models\SparePartCategoriesDescription', 'spare_part_category_id', 'id');
    }

   /*  public function childrenCategories()
    {
        return $this->hasMany(HailingCategory::class)->with('hailing_category');
    } */

}
