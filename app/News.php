<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $primaryKey = 'id';
    protected $fillable = ['author','title', 'desc', 'visit_count'];
}
