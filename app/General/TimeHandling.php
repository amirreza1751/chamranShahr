<?php


namespace App\General;


use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Morilog\Jalali\Jalalian;

class TimeHandling
{
    public static function isDST(Carbon $date)
    {
        if($date->month == 3 && $date->day == 21 && $date->hour >= 0 && $date->hour < 1){
            return true;
        }
        return false;
    }

    public static function validateJalalian($year, $month, $day){

        if(!is_integer($year) || !is_integer($month) || !is_integer($day))
            return false;

        /** just parse years after 1000 of solar calendar
         * and before 1500.
         */

        /**
         * validate year, month and day fields
         */
        $validator = Validator::make(array('year' => $year, 'month' => $month, 'day' => $day), [
            'year' => 'required|integer|between:1000,1500',
            'month' => 'required|integer|between:1,12',
            'day' => 'required|integer|between:1,31',
        ]);
        if ($validator->fails())
            return false;

        $j = new Jalalian($year, 1, 1);

        if($day > 31)
            return false;

        if($month > 6 && $day > 30)
            return false;

        if ($month == 12 && $j->isLeapYear() && $day > 30 )
            return false;

        if ($month == 12 && !$j->isLeapYear() && $day > 29 )
            return false;

        return true;

    }

    public static function parseJalalian($year, $month, $day)
    {
        if(!is_integer($year))
            $year = 1000;
        if(!is_integer($month))
            $month = 1;
        if(!is_integer($day))
            $day = 1;

        if ($year < 1000)
            $year = 1000;

        if ($year >1500)
            $year = 1500;


        $j = new Jalalian($year, 1, 1);

        if ($month < 1 )
            $month = 1;

        if ($month > 12 )
            $month = 12;

        if ($day < 1 )
            $day = 1;

        if ($month > 6 && $day > 30 )
            $day = 30;

        if ($month < 6 && $day > 31 )
            $day = 31;

        if ($month == 12 && $j->isLeapYear() && $day > 30 )
            $day = 30;

        if ($month == 12 && !$j->isLeapYear() && $day > 29 )
            $day = 29;

        return new Jalalian($year, $month, $day);
    }
}
