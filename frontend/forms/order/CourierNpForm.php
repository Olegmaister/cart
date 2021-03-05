<?php
namespace frontend\forms\order;

use common\entities\Customer;
use frontend\forms\order\interfaces\DeliveryInterface;
use yii\base\Model;

class CourierNpForm extends Model implements DeliveryInterface
{
    public $city;
    public $street;
    public $house;
    public $apartment;//квартира
    public $porch;//подьезд

    private $_method;


    /**@var Customer $customer*/
    public function __construct($customer = null,$config = [])
    {
        if(isset($customer) && isset($customer->profile)){
            $this->city = $customer->profile->city_id;
            $this->street = $customer->profile->street;
            $this->house = $customer->profile->house;
            $this->apartment = $customer->profile->apartment;
            $this->porch = $customer->profile->porch;
        }
        parent::__construct($config);
    }

    public function attributeLabels()
    {
        return [
            'city' => '',//Город
            'street' => '',//Улица
            'house' => '',//Дом
            'apartment' => '',//Квартира
            'porch' => ''//Подъезд
        ];
    }



    public function rules()
    {

        $this->_method = \Yii::$app->request->post('DeliveryForm')['method'];

        return array_filter([
            $this->_method == 1 ? ['city', 'required'] : false,
            $this->_method == 1 ? ['street', 'required'] : false,
            $this->_method == 1 ? ['house', 'required'] : false,
            $this->_method == 1 ? ['apartment', 'safe'] : false,
            $this->_method == 1 ? ['porch', 'safe'] : false,
        ]);
    }


}


