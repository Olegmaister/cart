<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;

class SeedController extends Controller
{
    public function actionIndex()
    {
        $this->stdout('added products' . PHP_EOL); 
    }

    public function actionDropProducts()
    {
        Yii::$app->db->createCommand()->dropTable('product')->execute();
        Yii::$app->db->createCommand()->dropTable('product_description')->execute();
        Yii::$app->db->createCommand()->dropTable('product_image')->execute();
        Yii::$app->db->createCommand()->dropTable('product_in_category')->execute();
        Yii::$app->db->createCommand()->dropTable('product_review')->execute();
        Yii::$app->db->createCommand()->dropTable('product_stock_status')->execute();
    }
}