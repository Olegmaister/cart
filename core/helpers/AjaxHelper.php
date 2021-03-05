<?php

namespace core\helpers;

use Yii;
use yii\web\Response;

class AjaxHelper
{
    public static function getParamPostInt($paramsName)
    {
        return (int)\Yii::$app->request->post($paramsName);
    }
    public static function getParamPost($paramsName)
    {
        return \Yii::$app->request->post($paramsName);
    }
    public static function getParamGet($paramsName)
    {
        return \Yii::$app->request->get($paramsName);
    }

    public static function answer($data)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $data;
    }
}


