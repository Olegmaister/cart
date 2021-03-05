<?php
namespace frontend\forms\order;

use yii\base\Model;


class PaymentForm extends Model
{
    public $paymentMethod2;
    public $paymentMethod;
    private $_paymentMethod;
    public $typePayment;
    public $paymentInstallments;
    public $parts;
    public function rules()
    {




        $this->_paymentMethod = \Yii::$app->request->post('PaymentForm')['paymentMethod2'];

        return array_filter([
            ['paymentMethod', 'safe'],
            $this->_paymentMethod == 1 ? ['typePayment', 'required'] : false,
            $this->_paymentMethod == 3 ? ['parts', 'required'] : false,
        ]);

    }

    public function attributeLabels()
    {
        return [
            'paymentMethod2' => '',
            'typePayment' => '',
            'paymentMethod' => '',
            'parts' => ''
        ];
    }
}
