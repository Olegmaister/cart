<?php
namespace frontend\forms\order;

use common\entities\Customer;
use frontend\forms\order\interfaces\DeliveryInterface;
use yii\base\Model;

class ForeignersUpForm extends Model implements DeliveryInterface
{
    public $city;
    public $state;//штат
    public $street;
    public $house;//дом
    public $apartment;//квартира
    public $porch;//подьезд
    public $index;

    private $_method;

    /**@var Customer $customer*/
    public function __construct($customer = null,$config = [])
    {
        if(isset($customer) && isset($customer->profile)){
            $profile = $customer->profile;
            $this->city = $profile->city_name;
            $this->street = $profile->street;
            $this->house = $profile->house;
            $this->state = $profile->state;
            $this->apartment = $profile->apartment;
            $this->porch = $profile->porch;
            $this->index = $profile->index;
        }
        parent::__construct($config);
    }

    public function rules()
    {

        $this->_method = \Yii::$app->request->post('DeliveryForm')['method'];

        return array_filter([
            $this->_method == 3 ? ['city', 'required'] : false,
            $this->_method == 3 ? ['street', 'required'] : false,
            $this->_method == 3 ? ['house', 'required'] : false,
            $this->_method == 3 ? ['apartment', 'safe'] : false,
            $this->_method == 3 ? ['porch', 'safe'] : false,
            $this->_method == 3 ? ['index', 'required'] : false,
            $this->_method == 3 ? ['state', 'required'] : false,
        ]);
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
            'index' => ''
        ];
    }

}
