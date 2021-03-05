<?php

namespace common\services;

use common\entities\Countries;
use Yii;
use yii\helpers\ArrayHelper;

class CountriesService
{
    public function getCountriesList(): array
    {
        $langName = 'name';

        if (Yii::$app->language === 'en-EN') {
            $langName = 'name_en';
        }

        if (Yii::$app->language === 'ua-UA') {
            $langName = 'name_ua';
        }

        return  ArrayHelper::map(
            Countries::find()
                ->asArray()
                ->orderBy(['sort' => SORT_DESC, 'code' => SORT_ASC])
                ->all()
            , 'code', $langName);
    }
}
