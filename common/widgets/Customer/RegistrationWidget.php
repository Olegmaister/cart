<?php
namespace common\widgets\Customer;

use Yii;

use common\forms\customer\SignupForm;
use common\services\customer\SignupService;
use yii\base\Widget;
use function globalFunction\functions\dd;

class RegistrationWidget extends Widget
{

    private $service;

    public function __construct(
        SignupService $service,
        $config = [])
    {
        $this->service = $service;
        parent::__construct($config);
    }

    public function init()
    {
        parent::init();
    }

    public function run()
    {

        $form = new SignupForm();
        
        return $this->render('register',[
            'model' => $form,
        ]);
    }

}