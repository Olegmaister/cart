<?php

namespace frontend\forms\customer;

use yii\base\Model;

/**
 * @property ProfileForm $profile
 */
class AvatarForm extends Model
{
    public $avatar;

    public function rules(): array
    {

         return [
             [['avatar'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'avatar' => '',
        ];
    }

}
