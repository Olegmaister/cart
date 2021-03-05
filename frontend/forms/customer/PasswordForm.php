<?php
namespace frontend\forms\customer;

use common\entities\Customer;
use yii\base\Model;



/**
 * @property ProfileForm $profile
 */

class PasswordForm extends Model
{
    public $password;
    public $repeatPassword;


    public function rules(): array
    {
        return [
            [['password','repeatPassword'], 'required'],
            ['repeatPassword', 'compare', 'compareAttribute' => 'password'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'password' => '',
            'repeatPassword' => ''
        ];
    }



}