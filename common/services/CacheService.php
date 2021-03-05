<?php


namespace common\services;

use frontend\services\CategoriesService;
use Yii;

class CacheService
{
    // Удаляем все валюты
    public static function clearCurrency()
    {
        Yii::$app->redis->del('EUR');
        Yii::$app->redis->del('USD');
    }

    // Удаляем кешь групп на главной и в карточке товаров на трех языках
    public static function clearGroupHomeAndProduct()
    {
        Yii::$app->redis->del('itemsGroupForProduct_ru-RU');
        Yii::$app->redis->del('itemsGroupForProduct_en-EN');
        Yii::$app->redis->del('itemsGroupForProduct_ua-UA');

        Yii::$app->redis->del('itemsGroupForHome_ru-RU');
        Yii::$app->redis->del('itemsGroupForHome_en-EN');
        Yii::$app->redis->del('itemsGroupForHome_ua-UA');
    }

    // Удаляем кешь видео на главной
    public static function clearVideoForHome()
    {
        Yii::$app->redis->del('videoForHome');
    }
}