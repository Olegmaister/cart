<?php

namespace console\controllers;

use common\api\oneC\SynchronizeCustomer;
use yii\console\Controller;

class SynchronizeCustomerController  extends Controller
{
    public function actionIndex()
    {
        (new SynchronizeCustomer())->start();
    }
}
