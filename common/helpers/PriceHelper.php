<?php

namespace common\helpers;

class PriceHelper
{
    public static function format($price): string
    {

        return  number_format(ceil($price), 0, '.', ' ');
    }
}
