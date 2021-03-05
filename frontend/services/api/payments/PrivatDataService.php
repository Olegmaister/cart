<?php

namespace frontend\services\api\payments;

use common\entities\Order;
use common\entities\Status;
use Yii;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\HttpException;

class PrivatDataService
{
    private const STORE_ID = '01841655274A4951BBAF';
    private const PASSWORD = '6b9ac727dae5484980db6a177537869f';

    public function getData($partsCount, $productsList, Order $order)
    {

        return [
            'ResponseUrl' => Url::home(true) . 'response-privat',
            'RedirectUrl' => Url::home(true) . 'checkout/empty',
            'PartsCount' => $partsCount,
            'OrderID' => $order->id,
            'merchantType' => 'PP',
            'ProductsList' => $productsList,

        ];
    }

    public function getStoreId()
    {
        return self::STORE_ID;
    }

    public function getPassword()
    {
        return self::PASSWORD;
    }

    /**
     * @param $data
     * @throws HttpException
     */
    public function responseProcessing($data): void
    {
        $orderId = (int)$data['order_id'];

        if (!$model = Order::findOne($orderId)) {
            throw new HttpException("Ошибка идентификации заказа при оплате частями: $orderId");
        }

        $this->logData($data, $orderId, $data['status']);

        if ($data['paymentState'] !== 'success') {
            return;
        }

        $model->current_status = Status::PAID;
        $model->save();
    }

    private function logData($request, $orderId, $status)
    {
        $sql = '
            INSERT INTO privat_bank_response 
            SET 
                response = :RESPONSE,
                order_id = :ORDER_ID,
                status = :STATUS
        ';

        Yii::$app->db->createCommand($sql)
            ->bindValue('RESPONSE', Json::encode($request))
            ->bindValue('ORDER_ID', $orderId)
            ->bindValue('STATUS', $status)
            ->execute();
    }
}
