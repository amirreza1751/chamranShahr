<?php


namespace App\General;


use Carbon\Carbon;

class TimeHandling
{
    public static function isDST(Carbon $date)
    {
        if($date->month == 3 && $date->day == 21 && $date->hour >= 0 && $date->hour < 1){
            return true;
        }
        return false;
    }
}
