<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'img_url', 'img_description',
    ];

    protected $hidden = [
        'user_id'
    ];

}
