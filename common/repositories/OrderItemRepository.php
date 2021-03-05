<?php
namespace common\repositories;

use common\entities\Order;
use common\entities\OrderItem;
use yii\web\NotFoundHttpException;

class OrderItemRepository
{
    public function get($id): OrderItem
    {
        if (!$orderItem = OrderItem::findOne($id)) {
            throw new NotFoundHttpException('Order item is not found.');
        }
        return $orderItem;
    }

    public function save(OrderItem $orderItem): void
    {
        if (!$orderItem->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function getCost($orderId)
    {
        return OrderItem::find()
            ->where(['order_id' => $orderId])
            ->sum('price');
    }

    public function getProducts($orderId)
    {
        return OrderItem::find()->where(['order_id' => $orderId])->all();
    }

    public function removeAllByOrderId($orderId)
    {
        OrderItem::deleteAll(['order_id' => $orderId]);
    }

    public function remove(OrderItem $orderItem): void
    {
        if (!$orderItem->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}