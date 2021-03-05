<?php
namespace frontend\forms\customer;

use common\entities\Customer;
use yii\base\Model;



/**
 * @property ProfileForm $profile
 */

class PasswordRecoveryForm extends Model
{
    public $email;


    public function rules(): array
    {
        return [
            [['email'], 'required']
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => ''
        ];
    }



}
