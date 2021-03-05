<?php

namespace console\controllers;

use backend\models\MailStocks;
use backend\models\MailStocksList;
use backend\models\PriceWatch;
use backend\models\Subscribe;
use common\services\mail\EmailSender;
use common\services\stock\NotificationService;
use Yii;
use yii\console\Controller;

/**
 * @property-read array $stockList
 * @property-read array $subscribeList
 */
final class MailStocksController extends Controller
{
    public function actionIndex()
    {
        $stockListRegular = $this->getRegularStockList();
        $stockListDate = $this->getDateStockList();
        $subscribeList = $this->getSubscribeList();

        foreach ($stockListRegular as $stock) {
            foreach ($subscribeList as $subscribe) {
                (new EmailSender())->sendStocksEmail($subscribe, $stock);
            }
        }

        foreach ($stockListDate as $stock) {
            foreach ($subscribeList as $subscribe) {
                (new EmailSender())->sendStocksEmail($subscribe, $stock);
            }
        }
    }

    private function getRegularStockList(): array
    {
        Yii::$app->db->createCommand('SET @current_day := WEEKDAY(CURDATE());')->execute();

        $sql = "
            SELECT * FROM mail_stocks
            WHERE type = 'regular'
                AND period LIKE CONCAT('%', @current_day, '%');
        ";

        return MailStocks::findBySql($sql)->all();
    }

    private function getDateStockList(): array
    {
        Yii::$app->db->createCommand('SET @current_day := DATE_FORMAT(CURDATE(), "%m.%d.%Y");')->execute();

        $sql = "
            SELECT * FROM mail_stocks
            WHERE type = 'date'
                AND period LIKE CONCAT('%', @current_day, '%');
        ";

        return MailStocks::findBySql($sql)->all();
    }

    private function getSubscribeList(): array
    {
        $sql = "
            SELECT * FROM subscribe
            WHERE share = 1
        ";

        return Subscribe::findBySql($sql)->all();
    }
}
