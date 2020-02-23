<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    //
    protected $with = ['user'];
    public function user()
    {
        return $this->belongsTo('App\User','mentor_id');
    }
}
