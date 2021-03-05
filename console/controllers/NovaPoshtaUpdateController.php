<?php

namespace console\controllers;

use common\entities\Cities;
use common\entities\City;
use common\helpers\StringHelper;
use Exception;
use LisDev\Delivery\NovaPoshtaApi2;
use yii\console\Controller;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class NovaPoshtaUpdateController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @throws Exception
     */
    public function actionIndex()
    {
        $np = new NovaPoshtaApi2(
            'daadb6b9870ce414e54656600fba6ebe',
            'ru', // Язык возвращаемых данных: ru (default) | ua | en
            true, // При ошибке в запросе выбрасывать Exception: FALSE (default) | TRUE
            'curl' // Используемый механизм запроса: curl (defalut) | file_get_content
        );

        $cities = $np->getCities('');

        if (!$cities) {
            throw new Exception('Ошибка получения данных новой почты');
        }

        echo 'START UPDATE CITIES NP' . PHP_EOL;

        foreach ($cities['data'] as $city) {
            $model = Cities::findOne(['reff' => $city['Ref']]);

            if ($model) {
                continue;
            }

            $model = new Cities();
            $model->reff = $city['Ref'];
            $model->name = $city['DescriptionRu'];
            $model->region = $city['DescriptionRu'];
            $model->city_id = $city['CityID'];
            $model->name_ua = $city['Description'];
            $model->name_en = StringHelper::cyrillic2translit($model->name);
            $model->save();
        }

        echo 'FINISH UPDATE NP' . PHP_EOL;
    }
}
