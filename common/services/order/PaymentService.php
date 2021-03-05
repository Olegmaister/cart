<?php
namespace common\services\order;

use common\entities\Order;
use common\entities\Order\Payment;
use common\entities\Order\PaymentAddition;
use common\entities\Order\Assistants\PaymentAssistant;

class PaymentService
{
    /*
     * получение всей информации об оплате
     * способ оплаты
     * какой сервис используется для оплаты
     * кол-во платежей(приват банк)
     **/
    public function getPaymentInfo(
        $deliveryMethodId,
        $paymentId,
        $paymentAdditionId,
        $privatParts
    )
    {

        if($deliveryMethodId == Order::DELIVERY_URK_POCHTA){
            return new PaymentAssistant(
                Payment::PAYMENT_BY_CREDIT_CARD,
                PaymentAddition::WAYFORPAY,
                PaymentAddition::cardName(PaymentAddition::WAYFORPAY),
                null
            );
        }

        if(Payment::isBankCard($paymentId)){
            return new PaymentAssistant(
                $paymentId,
                $paymentAdditionId,
                PaymentAddition::cardName($paymentAdditionId),
                $privatParts
            );
        }

        return new PaymentAssistant(
            $paymentId
        );

    }
}