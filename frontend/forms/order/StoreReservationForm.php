<?php
namespace frontend\forms\order;

use common\entities\Stores\Store;
use common\entities\Stores\StoreDescription;
use common\helpers\LanguageHelper;
use frontend\forms\order\interfaces\DeliveryInterface;
use yii\base\Model;

class StoreReservationForm extends Model implements DeliveryInterface
{

    public $city;
    public $store;

    public function __construct($config = [])
    {
        parent::__construct($config);
    }


    public function rules()
    {
        return [
            [['store','city'], 'safe'],
        ];
    }

    public function getCityList()
    {
        $cities = StoreDescription::find()->select('city')->where(['language_id' => LanguageHelper::getCurrentId()])->groupBy('city')->all();
        $resArray = [];
        foreach ($cities as $city) {
            $resArray[$city->city] = $city->city;
        }


        return $resArray;
    }

    public function attributeLabels()
    {
        return [
            'city' => 'Город',
            'store' => 'Выбрать магазин'
        ];
    }
}
