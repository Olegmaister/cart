<?php
namespace common\repositories;


use backend\entities\Order\Order as OrderBackend;
use common\entities\Order;
use yii\web\NotFoundHttpException;

class OrderRepository
{
    public function get($id): Order
    {
        if (!$order = Order::findOne($id)) {
            throw new NotFoundHttpException('Order is not found.');
        }
        return $order;
    }

    public function getById($id) : OrderBackend
    {
        if (!$order = OrderBackend::findOne($id)) {
            throw new NotFoundHttpException('Order is not found.');
        }
        return $order;
    }

    public function save($order): void
    {
        if (!$order->save()) {
            throw new \RuntimeException('Saving error.');
        }

    }

    public function updateCost($orderId, $cost)
    {
        Order::updateAll(['cost' => $cost,'funded_cost' => $cost],['id' => $orderId]);
    }

    public function remove(Order $order): void
    {
        if (!$order->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }

    public function updateStatus(Order $order, int $status): bool
    {
        $order->current_status = $status;

        return $order->save();
    }

    /**
     * @param string $number
     * @return Order
     * @throws NotFoundHttpException
     */
    public function getByGuid(string $number): ?Order
    {
        return Order::findOne(['order_guid' => $number]);
    }
}