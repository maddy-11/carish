<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    public function users(){
    	return $this->belongsTo('App\User', 'updated_by', 'id');
    }

    public function emailTemplateDescription(){
    	return $this->hasMany('App\EmailTemplateDescription', 'email_template_id', 'id')->where('language_id',2);
    }

    public function emailType(){
    	return $this->belongsTo('App\EmailType', 'type', 'id');
    }
}
