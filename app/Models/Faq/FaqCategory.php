<?php

namespace App\Models\Faq;

use Illuminate\Database\Eloquent\Model;

class FaqCategory extends Model
{
     protected $table = 'faq_categories';

      public function get_category_title(){
        return $this->hasMany('App\Models\Faq\FaqCategoryDescription', 'faq_category_id', 'id');
    }
}
