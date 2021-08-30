<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
     protected $fillable = [
        'user_id',
        'book_id',
        'rent_date',
        'return_date',
        'status'
    ];

    public function book() {
            return $this->belongsTo('App\Books');
        }
}
