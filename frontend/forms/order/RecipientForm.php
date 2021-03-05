<?php

namespace frontend\forms\order;

use borales\extensions\phoneInput\PhoneInputValidator;
use yii\base\Model;

class RecipientForm extends Model
{
    public $firstName;
    public $lastName;
    public $phone;
    public $email;
    public $ttn;

    private $_checkboxRecipient;

    public function rules(): array
    {
        $this->_checkboxRecipient = (int)\Yii::$app->request->post('OrderForm')['checkboxRecipient'];


        return array_filter([
            $this->_checkboxRecipient == 1 ? ['firstName', 'required'] : false,
            $this->_checkboxRecipient == 1 ? ['lastName', 'required'] : false,
            $this->_checkboxRecipient == 1 ? ['phone', 'required'] : false,
            $this->_checkboxRecipient == 1 ? ['phone', PhoneInputValidator::class] : false,
            $this->_checkboxRecipient == 1 ? ['email', 'safe'] : false,
            $this->_checkboxRecipient == 1 ? ['ttn', 'safe'] : false
        ]);
    }

    public function attributeLabels()
    {
        return [
            'firstName' => '',//Имя
            'lastName' => '',//Фамилия
            'phone' => '',//Телефон
            'email' => '',//E-mail
            'ttn' => ''
        ];
    }


}