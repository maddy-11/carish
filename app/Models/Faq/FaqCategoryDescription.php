<?php
namespace App\Models\Faq;

use Illuminate\Database\Eloquent\Model;

class FaqCategoryDescription extends Model
{
    protected $table = "faq_categories_description";
    protected $fillable = ['faq_category_id','title','language_id'];

     public function FaqCategory()
    {
        return $this->belongsTo('App\Models\Faq\FaqCategory','faq_category_id','id');
    }
}
