<?php

namespace App\Models\Faq;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $table = "faqs";

    public function faqs_description()
    {
        return $this->hasMany('App\Models\Faq\FaqsDescription', 'faq_id', 'id');
    }

    /* public function faqcategory(){
    	return $this->belongsTo('App\Models\Faq\FaqCategory','faq_category_id','id');
    }*/

      public function faqcategory($faq_category_id , $lang_id)
    {	
    	$faq_category = FaqCategoryDescription::where('faq_category_id' , $faq_category_id)->where('language_id',$lang_id)->first();
        return $faq_category->title;
    }



}
