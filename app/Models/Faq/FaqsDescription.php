<?php

namespace App\Models\Faq;

use Illuminate\Database\Eloquent\Model;

class FaqsDescription extends Model
{
    protected $table = "faqs_description";

    public function faq(){
    	return $this->belongsTo('App\Models\Faq\Faq','faq_id','id');
    }

    public function language()
    {
        return $this->belongsTo('App\Models\Language','language_id','id');
    }
}
