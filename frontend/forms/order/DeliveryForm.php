<?php

namespace frontend\forms\order;

use common\entities\City;
use common\entities\Customer;
use common\entities\Order\DeliveryMethod;
use common\helpers\LanguageHelper;
use frontend\forms\order\interfaces\DeliveryInterface;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class DeliveryForm extends Model implements DeliveryInterface
{

    public $method;
    public $country;//страна доставки
    private $_weight;

    public function __construct(int $weight,$customer = null, array $config = [])
    {
        $this->_weight = $weight;
        $this->country = isset($customer->profile->country_id) ? $customer->profile->country_id : null;
        parent::__construct($config);
    }

    public function rules()
    {

        return array_filter([
           [['country','method'], 'required'],
           [['store'], 'safe'],

        ]);
    }


    public function attributeLabels()
    {
        return [
            'method' => '',//Выбор способа доставки Украина
            'methodOther' => '',//Выбор способа доставки другие страны
            'country' => '',//Страна
            'store' => ''// Магазин

        ];
    }

    public function getCities()
    {

        $languageName = 'name';

        if (Yii::$app->language === 'en-EN' || Yii::$app->language === 'en-US') {
            $languageName = 'name_en';
        }

        if (Yii::$app->language === 'ua-UA') {
            $languageName = 'name_ua';
        }


        return ArrayHelper::map(City::find()
            ->asArray()
            ->orderBy(['name' => SORT_ASC])
            ->where(['status' => 1,])
            ->andWhere(['<>', $languageName, ''])
            ->all(), 'id', function (array $city) use ($languageName) {

            return $city[$languageName];
        });
    }

    public function deliveryMethodsListUkraine(): array
    {
        $methods = DeliveryMethod::find()->where(['country' => 'UA'])->orderBy('sort')->all();

        return ArrayHelper::map($methods, 'id', 'name');
    }

    public function deliveryMethodsListOther(): array
    {
        $methods = DeliveryMethod::find()->where(['country' => 'OTHER'])->orderBy('sort')->all();

        return ArrayHelper::map($methods, 'id', 'name');
    }

}
