<?php
namespace common\helpers;

class CheckHelper
{
    public static function isEmpty($data)
    {
        if(empty($data))
            return true;

        return false;
    }

    public static function isIsset($data)
    {

    }

    public static function isNotEmpty($data)
    {
        if(!empty($data))
            return true;

        return false;
    }
}