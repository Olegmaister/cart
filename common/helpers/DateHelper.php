<?php
namespace common\helpers;

class DateHelper
{
    public static function getTimestampByDate($date)
    {

        if(!$date)
            return null;

        return strtotime($date);
    }

    public static function getTimestampByDateTo($date)
    {

        if(!$date)
            return null;

        return strtotime($date) + 86400;
    }

    public static function getCurrentTime()
    {
        return time();
    }

    public static function getFormatDate(int  $date, $format = 'Y-m-d')
    {
        return date('Y-m-d H:i:s',$date);
    }


    public static function downcounter($date){
        $checkTime = $date - time();

        if($checkTime <= 0){
            return false;
        }

        $days = floor($checkTime/86400);
        $hours = floor(($checkTime%86400)/3600);
        $minutes = floor(($checkTime%3600)/60);
        $seconds = $checkTime%60;

        return[
            'days' => $days,
            'hours' => $hours + ($days * 24),
            'minutes' => $minutes,
            'seconds' => $seconds
        ];
    }
}