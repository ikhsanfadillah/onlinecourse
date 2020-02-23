<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
class SupportDesk extends Model
{
    //
    protected $fillable = ['topic', 'title', 'content', 'author'];
    protected $with = ['user'];
    public function User() {
      return $this->belongsTo('App\User', 'author');
    }
}
