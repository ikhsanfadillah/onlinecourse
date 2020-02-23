<?php

namespace App;

use Carbon\Carbon;

class Helper
{
    const STATUS_NO = 0;
    const STATUS_YES = 1;
    public static function IDR($amount){
        return "Rp " . number_format($amount,0,',','.');
    }
    public static function formatDate($value,$from = null, $to = null){
        $from = empty($from) ? config('app.datetime_format') : $from;
        $to = empty($to) ? config('app.datetime_format_sql') : $to;
        return Carbon::createFromFormat($from, $value)->format($to);
    }
}