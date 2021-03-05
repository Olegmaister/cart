<?php

namespace console\controllers;

use common\api\oneC\SynchronizeGood;
use yii\console\Controller;

class SynchronizeGoodController  extends Controller
{
    public function actionIndex()
    {
        (new SynchronizeGood())->start();
    }
}
