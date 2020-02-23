<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    public $price = 0;
    public $percent = 0;

    const DISCOUNT_TYPE_PRICE = 1;
    const DISCOUNT_TYPE_PERCENT = 100;
    public static $rules = [
        'create' =>[
            'code' => 'required|unique:discounts',
            'type' => 'required',
            'desc' => 'required',
            'price' => 'numeric',
            'percent' => 'numeric|max:100',
            'max_price' => 'numeric',
            'discount_date_range' => 'required',
        ],
        'update' =>[
            'code' => 'sometimes|required|unique:discounts',
            'type' => 'required',
            'desc' => 'required',
            'price' => 'numeric',
            'percent' => 'numeric|max:100',
            'max_price' => 'numeric',
            'discount_date_range' => 'required',
        ]
    ];

    public static $type = [1 => 'price', 100 => 'percent'];
    public function mentors(){
        return $this->belongsToMany(Mentor::class,"discount_mentor",'discount_id','mentor_id')->withTimestamps();
    }

    public function setStartedDateAttribute($value){
        $this->attributes['started_dt'] = Carbon::createFromFormat(config('app.datetime_format'), $value)->format('Y-m-d H:i:s');
    }
    public function getStartedDate($value){
        return Carbon::parse($value)->format(config('app.datetime_format'));
    }
    public function setEndedDateAttribute($value){
        $this->attributes['ended_dt'] = Carbon::createFromFormat(config('app.datetime_format'), $value)->format('Y-m-d H:i:s');
    }
    public function getEndedDate($value){
        return Carbon::parse($value)->format(config('app.datetime_format'));
    }

    public function getValueTypeAttribute($value)
    {
        if ($this->type == self::DISCOUNT_TYPE_PRICE) {
            return Helper::IDR($this->value);
        } elseif ($this->type == self::DISCOUNT_TYPE_PERCENT){
            return $this->value . "%";
        }
    }
}
