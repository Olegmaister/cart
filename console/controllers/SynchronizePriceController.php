<?php

namespace console\controllers;

use common\api\oneC\SynchronizePrice;
use yii\console\Controller;

class SynchronizePriceController  extends Controller
{
    public function actionIndex()
    {
        (new SynchronizePrice())->start();
    }
}
