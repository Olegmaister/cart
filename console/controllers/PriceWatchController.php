<?php

namespace console\controllers;

use backend\models\PriceWatch;
use common\services\mail\EmailSender;
use common\services\stock\NotificationService;
use Yii;
use yii\console\Controller;

final class PriceWatchController extends Controller
{
    /**
     * @var NotificationService
     */
    private $notificationService;

    public function __construct($id, $module, NotificationService $notificationService, $config = [])
    {
        $this->notificationService = $notificationService;

        parent::__construct($id, $module, $config);
    }

    public function actionIndex()
    {
        $this->setNewPrice();
        $priceWatchList = $this->getActivePriceWatchList();

        foreach ($priceWatchList as $item) {
            if((int)$item->price === 0 || (int)$item->price_new === 0) {
                continue;
            }

            (new EmailSender())->sendChangeProductPriceEmail($item);
        }

        $this->replacePrice();
    }

    private function setNewPrice()
    {
        $products = PriceWatch::findAll(['is_active' => 1]);

        foreach ($products as $product) {
            $newPrice = $this->notificationService->getPriceProduct($product->product_id);

            $product->price_new = $newPrice;
            $product->save();
        }
    }

    private function replacePrice()
    {
        $sql = '
            UPDATE price_watch pw
            INNER JOIN price_watch pw2 ON pw.id = pw2.id
            SET pw.price = pw2.price_new
            WHERE pw.is_active = TRUE
        ';

        Yii::$app->db->createCommand($sql)->execute();
    }

    private function getActivePriceWatchList(): array
    {
        $sql = '
            SELECT
                pw.*
            FROM price_watch pw
            WHERE pw.is_active = TRUE
                AND pw.price_new < pw.price
        ';

        return PriceWatch::findBySql($sql)->all();
    }
}
