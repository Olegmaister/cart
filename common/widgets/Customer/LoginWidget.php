<?php
namespace common\widgets\Customer;

use Yii;

use common\forms\customer\LoginForm;
use common\services\customer\LoginService;
use yii\base\Widget;
use function globalFunction\functions\dd;

class LoginWidget extends Widget
{

    private $service;


    public function __construct(
        LoginService  $service,
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

        $form = new LoginForm();

            if ($form->load(Yii::$app->request->post()) && $form->validate()) {
                try {

                    $customer = $this->service->auth($form);


                    Yii::$app->user->login($customer, $form->rememberMe ? 3600 * 24 * 30 : 0);


                } catch (\DomainException $exception) {
                    Yii::$app->session->setFlash('error', $exception->getMessage());

                }

            }


        return $this->render('login',[
            'model' => $form,
        ]);
    }

}