<?php
namespace frontend\widgets\Customer;

use frontend\forms\customer\AvatarForm;
use yii\base\Widget;

class AvatarWidget extends Widget
{

    public $item;

    public function init()
    {
        parent::init();
    }

    public function run(): string
    {
        $form = new AvatarForm();
        return $this->render('avatar',[
            'model' => $form
        ]);
    }
}
