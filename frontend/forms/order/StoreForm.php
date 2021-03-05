<?php
namespace frontend\forms\order;

use common\entities\Customer;
use frontend\forms\order\interfaces\DeliveryInterface;
use yii\base\Model;

class StoreForm extends Model implements DeliveryInterface
{
    public $store;
    private $_method;


    public function rules()
    {

        dd('store');

        return [
          [['store' => 'required']]
        ];
    }

    public function attributeLabels()
    {
        return [
            'city' => '',
            'street' => '',
            'house' => '',
            'state' => '',
            'apartment' => '',
            'porch' => '',
            'index' => '',
            'cost' => ''
        ];
    }

}
