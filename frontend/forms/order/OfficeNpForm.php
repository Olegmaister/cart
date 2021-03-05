<?php
namespace frontend\forms\order;

use frontend\forms\order\interfaces\DeliveryInterface;
use yii\base\Model;

class OfficeNpForm extends Model implements DeliveryInterface
{
    public $city;//город доставки
    public $branch;//отделение новой почты

    private $_method;


    public function __construct($customer = null,$config = [])
    {
        if(isset($customer) && isset($customer->profile)){
            $this->city = $customer->profile->city_id;
        }
        parent::__construct($config);
    }


    public function rules()
    {

        $this->_method = \Yii::$app->request->post('DeliveryForm')['method'];

        return array_filter([
            $this->_method == 2 ? ['city', 'required'] : false,
            $this->_method == 2 ? ['branch', 'required'] : false,
            $this->_method == 2 ? ['branch', 'safe'] : false,
        ]);
    }

    public function attributeLabels()
    {
        return [
            'city' => '',//Город
            'branch' => '',//Отделение новой почты
        ];
    }

}