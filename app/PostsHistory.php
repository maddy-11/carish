<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostsHistory extends Model
{
    protected $table = 'posts_histories';
    
    public function get_user(){
        return $this->belongsTo('App\Models\Customers\Customer', 'user_id', 'id');
    }

    public function get_staff(){
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
