<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MentorRating extends Model
{
    protected $with = ['user'];

    public function getAvatar(){
        $user = User::find($this->user_id);
        return $user->getFirstMediaUrl('avatar-photo');
    }
    public function user(){
        return $this->belongsTo('App\User','mentor_id');
    }
}
