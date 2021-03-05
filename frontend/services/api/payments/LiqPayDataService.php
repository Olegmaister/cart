<?php

namespace frontend\services\api\payments;

use common\api\PaymentSystems\LiqPay;
use common\entities\Order;
use common\entities\Status;
use Yii;
use yii\helpers\Url;

class LiqPayDataService
{
    public const PUBLIC_KEY = 'i27979535751';
    public const PRIVATE_KEY = 'zOcwl6MgStLzDjOxm4DW3JYaZm32hTHRBbq7RPVZ';

    public function getData(Order $order, $actionPay)
    {
        $liqpay = new LiqPay(self::PUBLIC_KEY, self::PRIVATE_KEY);

        return $liqpay->cnb_form([
            'action' => $actionPay,
            'result_url' => Url::home(true) . 'checkout/empty',
            'server_url' => Url::home(true) . 'response-liqpay',
            'amount' => $order->cost,
            'currency' => LiqPay::CURRENCY_UAH,
            'description' => 'Оплата товаров',
            'order_id' => $order->id,
            'version' => '3',
        ]);
    }

    /**
     * @param $data
     * @param $signatureResponse
     * @throws \Exception
     */
    public function responseProcessing($data, $signatureResponse): void
    {
        $request = base64_decode($data);
        $requestData = json_decode($request, true);
        $orderId = (int)$requestData['order_id'];
        $signatureServer = base64_encode(sha1(
            self::PRIVATE_KEY .
            $data .
            self::PRIVATE_KEY
            , 1));

        if ($signatureServer !== $signatureResponse) {
            throw new \Exception("Liqpay ошибка валидации данных ответа! Номер заказа: $orderId");
        }

        $this->logData($request, $orderId, $requestData['status']);

        if ($requestData['status'] !== 'success') {
            return;
        }

        if (!$model = Order::findOne($orderId)) {
            throw new \Exception("Ошибка идентификации заказа при оплате Liqpay: $orderId");
        }

        $model->current_status = Status::PAID;
        $model->save();
    }

    private function logData($request, $orderId, $status)
    {
        $sql = '
            INSERT INTO liqpay_response 
            SET 
                response = :RESPONSE,
                order_id = :ORDER_ID,
                status = :STATUS
        ';

        Yii::$app->db->createCommand($sql)
            ->bindValue('RESPONSE', $request)
            ->bindValue('ORDER_ID', $orderId)
            ->bindValue('STATUS', $status)
            ->execute();
    }
}
