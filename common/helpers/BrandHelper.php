<?php

namespace common\helpers;

use common\entities\Brands\Brand;
use Yii;

class BrandHelper
{
    public static function getCountriesList()
    {
        $countries = Brand::find()->select('country_id')->distinct()->all();
        $list = [];
        foreach ($countries as $country) {
            $list[$country->country['id']] = $country->country[Yii::$app->language];
        }

        return $list;
    }

    /*public static function getImage($model)
    {
        if($model->image) {
            $img = "/images/brands/{$model->image}";
        } else {
            $img = "/images/no-image.png";
        }
        return "<img class=\"w100\" src=\"{$img}\">";
    }

    public static function getLink($model)
    {
        return "<a href=\"/{$model->link['keyword']}\">{$model->link['keyword']}</a>";
    }*/
}