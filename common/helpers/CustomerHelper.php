<?php
namespace common\helpers;

use Yii;

class CustomerHelper
{
    public static function getIp()
    {
        return Yii::$app->request->userIP;
    }
}
