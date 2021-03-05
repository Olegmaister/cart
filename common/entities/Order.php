<?php

namespace common\entities;


use common\entities\Order\Assistants\PaymentAssistant;
use common\entities\Order\DeliveryData;
use common\entities\Order\DeliveryMethod;
use common\entities\Order\OrderPresent;
use common\entities\Order\Payment;
use common\entities\Order\PaymentAddition;
use common\entities\Products\Product;
use common\entities\Stock\StockPromo;
use common\entities\Stores\Store;
use frontend\forms\product\FastForm;
use core\services\cart\Cart;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 * customer
 * @property int $id
 * @property int $customer_id
 * @property int $promo_id
 * @property string $order_guid
 * @property int $customer_group_id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property int $phone
 * recipient
 * @property string $recipient_first_name
 * @property string $recipient_last_name
 * @property string $recipient_phone
 * @property string $recipient_email
 * @property string $recipient_ttn
 * delivery
 * @property int $delivery_method_id
 * @property int $delivery_cost
 * @property int $weight
 * @property string $delivery_country
 * @property string $delivery_city
 * @property int $delivery_branch //
 * @property string $delivery_branch_name //
 * @property string $delivery_street //
 * @property string $delivery_house //
 * @property string $delivery_apartment //
 * @property string $delivery_porch //
 * @property string $delivery_index //
 * @property string $delivery_state //
 * @property int $delivery_store_id
 * payment
 * @property int $payment_id //
 * @property int $payment_addition_id //
 * @property string $payment_bank_card //
 * @property integer $parts //
 * other
 * @property float $cost //
 * @property float $funded_cost //
 * @property float $origin_cost //
 *
 * @property integer $current_status//
 * @property Json $statuses_json//
 *
 * @property string  $comment
 * @property string  $cancel_reason
 * @property integer $call_me
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $stock_percent
 * @property integer $stock_value

 * * @property OrderItem[] $items
 * * @property OrderPresent[] $presents
 * @property Status[] $statuses
 * @property Store $store
 *
 * @property Customer $customer
 * @property DeliveryMethod $delivery
 * @property Payment $payment
 */
class Order extends ActiveRecord
{
    //delivery method
    const COURIER_NP = 1;
    const OFFICE_NP = 2;
    const DELIVERY_URK_POCHTA = 3;
    const SELF_DELIVERY = 4;

    const DISPLAY_ON_PAGE = 10;

    public $deliveryData;
    public $recipientData;
    public $statuses = [];

    public static function create(
        $customer,
        $country,
        $deliveryMethod,
        $weight,
        $paymentMethod,
        $typePaymentId,
        $deliveryCost
    ): self
    {

        $order = new static();
        $order->customer_id = isset($customer->customer_id) ? $customer->customer_id : null;
        $order->customer_group_id = isset($customer->group_id) ? $customer->group_id : 1;
        $order->delivery_country = $country;
        $order->delivery_method_id = $deliveryMethod;
        $order->weight = $weight;
        $order->payment_id = $paymentMethod;
        $order->payment_addition_id = $typePaymentId;
        $order->delivery_cost = $deliveryCost;

        $order->addStatus(Status::NEW);

        return $order;
    }

    public function setCost($cost)
    {
        $this->cost = $cost;
    }


    public function test()
    {

        if($this->delivery_method_id == Order::DELIVERY_URK_POCHTA){
            $this->setPaymentUrkPochta();

        }

        if($this->payment_id == 1 || $this->payment_id == 3){
            //получить название карты
            $res = Order\PaymentAddition::find()->where(['id' => $this->payment_addition_id])->one();
            $this->payment_bank_card = $res->name;
        }


        return[
          'payment_id' => $this->payment_id,
          'addition_id' => $this->payment_addition_id,
          'bank_name' => $this->payment_bank_card,
          'parts' => $this->parts
        ];


    }

    /*
     * присваиваем информацию о покупателе
     **/
    public function setBuyer($firstName, $lastName, $email, $phone, $comment)
    {
        $this->first_name = $firstName;
        $this->last_name = $lastName;
        $this->email = $email;
        $this->phone = $phone;
        $this->comment = $comment;
    }

    /*
     * присваиваем информацию о платильщике
     **/
    public function setPayer($firstName, $lastName, $email, $phone)
    {
        $this->recipient_first_name = $firstName;
        $this->recipient_last_name = $lastName;
        $this->recipient_email = $email;
        $this->recipient_phone = $phone;
    }

    /*
     *
     *
     **/
    public function setDeliveryInformation(DeliveryData $deliveryData)
    {
        $this->delivery_city = $deliveryData->city;
        $this->delivery_street = $deliveryData->street;
        $this->delivery_house = $deliveryData->house;
        $this->delivery_apartment = $deliveryData->apartment;
        $this->delivery_porch = $deliveryData->porch;
        $this->delivery_branch = $deliveryData->branch;
        $this->delivery_branch_name = 'название отделения';
        $this->delivery_index = $deliveryData->index;
    }

    /*
     * привязываем товары в заказу
     **/
    public function setProducts($items)
    {
        $this->items = $items;
    }

    public function setPromoId(StockPromo $promo = null) : void
    {
        if(isset($promo) && !empty($promo))
            $this->promo_id = $promo->getId();
    }


	public static function fastCreate($customer, $items, FastForm $form, Product $product)
    {
        $order = new self();
        
        $order->items = $items;
        //customer
        $order->customer_id = isset($customer->customer_id) ? $customer->customer_id : null;
        $order->customer_group_id = isset($customer->group_id) ? $customer->group_id : 1;
        $order->email = isset($customer->email) ? $customer->email : null;

        $order->phone = $form->phone;
        $order->first_name = $form->firstName;
        $order->last_name = $form->lastName;

        //delivery
        $order->delivery_method_id = 2;
        $order->delivery_city = $form->city;
        $order->delivery_branch = $form->branch;
        $order->delivery_branch_name = 'Название';
        $order->delivery_cost = $form->deliveryCost;
        $order->delivery_country = Country::UKRAINE_CODE;

        // 1/4


        $order->cost = $form->productPrice + $form->deliveryCost;
        $order->funded_cost = $form->productPrice;
        $order->origin_cost = $form->productPrice;
        $order->weight = 1;

        $order->addStatus(Status::NEW);


        return $order;


    }


    /* @var OrderPresent $present**/
    public function assignPresent($present)
    {
        $presents = $this->presents;
        $presents[] = $present;

        $this->presents = $presents;

    }


    private function addStatus($value): void
    {

        $this->statuses[] = new Status($value, time());
        $this->current_status = $value;
    }

    public function addPaymentBankCard($cardName)
    {
        $this->payment_bank_card = $cardName;
    }

    public function addStatusPaid()
    {
        $this->addStatus(Status::PAID);
    }

    public function setDeliveryInfo( $deliveryData): void
    {
        $this->deliveryData = $deliveryData;
    }

    public function setRecipientInfo($recipientData): void
    {
        $this->recipientData = $recipientData;
    }

    public function setPayment($paymentId) : void
    {
        $this->payment_id = $paymentId;
    }

    public function setPaymentInfo(PaymentAssistant $paymentAssistant)
    {
        $this->payment_id = $paymentAssistant->getPaymentId();
        $this->payment_addition_id = $paymentAssistant->getPaymentAdditionId();
        $this->payment_bank_card = $paymentAssistant->getCardName();
        $this->parts = $paymentAssistant->getPrivatParts();
    }

    /*
     * установка названия банковской карты[LiqPay|wayForPay|privat_pp]
     * **/
    public function setPaymentBankCardName()
    {

        if($this->payment_id == Payment::PAYMENT_BY_CREDIT_CARD){
            $this->payment_bank_card = PaymentAddition::cardName($this->payment_addition_id);
        }elseif ($this->payment_id == Payment::PAYMENT_PRIVAT_BANK){

        }
    }

    /*
     * если доставка укр почтой
     * оплата банковской картой
     * карта wayForPay
     **/
    public function setPaymentUrkPochta()
    {
        $this->payment_id = Payment::PAYMENT_BY_CREDIT_CARD;
        $this->payment_addition_id = PaymentAddition::WAYFORPAY;
        $this->payment_bank_card = PaymentAddition::cardName($this->payment_addition_id);
    }

    public function setPaymentBankCard(string $card)
    {
        $this->payment_bank_card = $card;
    }

    public function setPaymentAdditionId(int $additionId)
    {
        $this->payment_addition_id = $additionId;
    }

    public function getNameBank()
    {
        return $this->payment_bank_card;
    }

    public function getParts()
    {
        return $this->parts;
    }


    public function setParts($form)
    {
        if(isset($form->parts))
        $this->parts = $form->parts;
    }

    public function setDeliveryStoreId($deliveryStoreId)
    {
        $this->delivery_store_id = $deliveryStoreId;
    }


    /*=====payer=====*/
    public function getFirstNamePayer()
    {
        return $this->first_name;
    }
    public function getLastNamePayer()
    {
        return $this->last_name;
    }

    public function getEmailPayer()
    {
        return $this->email;
    }

    public function setOriginCost(Cart $cart, $totalPresent = 1)
    {
        $this->origin_cost = $cart->getCost()->getOrigin() + $totalPresent;
    }
    public function setOriginCostReserv($price)
    {
        $this->origin_cost = $price;
    }

    public function setDeliveryCost($cost)
    {
        $this->delivery_cost = $cost;
    }

    public function getPhonePayer()
    {
        return $this->phone;
    }

    public function getCountryPayer()
    {
        return $this->email;
    }

    public function setFundedCost($cost)
    {
        $this->funded_cost = $cost;
    }


    public function behaviors(): array
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['items','presents'],
            ],
        ];
    }

    public function transactions(): array
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }


    //items
    public function assignItems($products)
    {
        $items = $this->items;
        foreach ($products as $item) {
            $items[] = OrderItem::createItem($item);
        }

        $this->items = $items;
    }

    public function toEstablishCost($cost)
    {
        $this->cost = $cost;
        $this->funded_cost = $cost;
    }

    //relations
    public function getItems(): ActiveQuery
    {
        return $this->hasMany(OrderItem::class, ['order_id' => 'id']);
    }
    //relations
    public function getOrder_items(): ActiveQuery
    {
        return $this->hasMany(OrderItem::class, ['order_id' => 'id']);
    }

    public function getDelivery(): ActiveQuery
    {
        return $this->hasOne(DeliveryMethod::class, ['id' => 'delivery_method_id']);
    }

    public function getPayment(): ActiveQuery
    {
        return $this->hasOne(Payment::class, ['id' => 'payment_id']);
    }

    public function getCustomer(): ActiveQuery
    {
        return $this->hasOne(Customer::class, ['customer_id' => 'customer_id']);
    }

    public function getPresents(): ActiveQuery
    {
        return $this->hasMany(OrderPresent::class, ['order_id' => 'id']);
    }

    public function getPresent(): ActiveQuery
    {
        return $this->hasOne(OrderPresent::class, ['order_id' => 'id']);
    }

    public function getStore(): ActiveQuery
    {
        return $this->hasOne(Store::class, ['store_id' => 'delivery_store_id']);
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%orders}}';
    }

    public function afterFind(): void
    {
        $this->statuses = array_map(function ($row) {
            return new Status(
                $row['value'],
                $row['created_at']
            );
        }, Json::decode($this->getAttribute('statuses_json')));

        parent::afterFind();
    }

    public function beforeSave($insert): bool
    {

        //$id = self::find()->count('*');
        //$this->id = $id + 600000;


        $this->setAttribute('statuses_json', Json::encode(array_map(function (Status $status) {
            return [
                'value' => $status->value,
                'created_at' => $status->created_at,
            ];
        }, $this->statuses)));

        return parent::beforeSave($insert);
    }

    /**
     * @param string $recipient_ttn
     * @return Order
     */
    public function setRecipientTtn(string $recipient_ttn): Order
    {
        $this->recipient_ttn = $recipient_ttn;
        return $this;
    }
}
