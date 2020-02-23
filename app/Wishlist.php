<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wishlist extends Model
{
    const TYPE_MENTOR = Mentor::class;
    const TYPE_LESSON = Lessonw::class;
    protected $primaryKey = 'id';
    // protected $with = ['mentor','lesson'];
    function getUserWishlists($user_id) {
      $result = DB::table('wihslists')->where('user_id', '==', $user_id)->get();
      return $result;
    }
    // public function mentor() {
    //   return $this->belongsTo(User::class);
    // }
    public function wishable () {
      return $this->morphTo();
    }
}
