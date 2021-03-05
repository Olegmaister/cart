<?php
namespace common\forms\customer;

use borales\extensions\phoneInput\PhoneInputValidator;
use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $email;
    public $phone;
    public $password;
    public $rememberMe = true;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            [['phone'], PhoneInputValidator::class, 'region' => ['PL', 'UA']],
            [['password'], 'required'],
            ['rememberMe', 'boolean'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'email' => Yii::t('app', 'email'),
            'phone' => Yii::t('app', 'phone'),
            'password' => Yii::t('app', 'password'),
        ];
    }

}
