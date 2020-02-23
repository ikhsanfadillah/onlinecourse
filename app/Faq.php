<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
  protected $primaryKey = 'id';
  protected $fillable = ['question', 'answer', 'order'];
}
