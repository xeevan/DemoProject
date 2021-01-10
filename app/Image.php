<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'img_url', 'img_description', 'user_id'
    ];

    public function user(){
    	return $this->belongsTo('App\User');
    }
}
