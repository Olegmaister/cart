<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;

class ClearLogController extends Controller
{
    public function actionIndex()
    {
        $sql = '
            SET @date_to_delete := (NOW() - INTERVAL 7 DAY);

            DELETE FROM synchronize_log
            WHERE created_at < @date_to_delete;
            
            DELETE FROM report_price
            WHERE create_at < @date_to_delete;
            
            DELETE FROM error_log
            WHERE time < @date_to_delete;
            
            DELETE FROM log_errors
            WHERE created_at < @date_to_delete;
        ';

        Yii::$app->db->createCommand($sql)->execute();
    }
}
