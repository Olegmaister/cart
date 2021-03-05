<?php
namespace common\repositories\Order;

use common\entities\Order\Payment;
use common\entities\Order\PaymentAddition;
use common\repositories\NotFoundException;


class PaymentRepository
{
    public function getById($id) : Payment
    {
        return $this->getBy(['id' => $id]);
    }


    public function getListMethodPayments($paymentId)
    {
        return Payment::find()
            ->where(['id' => $paymentId])
            ->with('paymentAdditions')
            ->one();
    }

    public function getCardById(int $id)
    {
        return PaymentAddition::find()->where(['id' => $id])->one();
    }

    private function getBy($condition)
    {
        if(!$stock = Payment::find()->where($condition)->one()){
            throw new NotFoundException('Payment not found.');
        }

        return $stock;
    }
}
