<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
     protected $fillable = [
        'book_name',
        'author',
        'cover_image'        
    ];
}
