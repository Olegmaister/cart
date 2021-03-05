<?php
namespace common\widgets\Customer;

use frontend\forms\customer\PasswordRecoveryForm;
use Yii;

use yii\base\Widget;


class PasswordRecoveryWidget extends Widget
{


    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $form = new PasswordRecoveryForm();
        return $this->render('password-recovery',[
            'model' => $form
        ]);
    }

}
