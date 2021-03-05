<?php
namespace common\repositories;

use common\entities\Order\PaymentAddition;
use yii\web\NotFoundHttpException;

class PaymentAdditionRepository
{
    public function getById($id): PaymentAddition
    {
        if (!$order = PaymentAddition::findOne($id)) {
            throw new NotFoundHttpException('payment is not found.');
        }
        return $order;
    }

    public function save(PaymentAddition $payment): void
    {
        if (!$payment->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(PaymentAddition $payment): void
    {
        if (!$payment->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}