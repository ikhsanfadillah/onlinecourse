<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;
    protected $with = ['user'];

    public static $createRules = [
        'user_id' => 'required|exists:users,id',
        'text' => 'required:max:500',
        'parent_id' => 'required',

    ];


    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }

    public function commentable()
    {
        return $this->morphTo();
    }
}
