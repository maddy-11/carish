<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\EmailTemplateDescription;
use App\PageDescription;
use App\Models\Faq\FaqsDescription;


class Language extends Model
{
    public function page_description($page_id , $lang_id)
    {	
    	$page_description = PageDescription::where('page_id' , $page_id)->where('language_id',$lang_id)->first();
        return $page_description;
    }

    public function email_description($email_template_id , $lang_id)
    {
    	$email_description = EmailTemplateDescription::where('email_template_id',$email_template_id)->where('language_id' , $lang_id)->first();
    	return $email_description;
    }

    public function faq_description($faq_id , $lang_id)
    {   
        $faq_description = FaqsDescription::where('faq_id' , $faq_id)->where('language_id',$lang_id)->first();
        return $faq_description;
    }
}
