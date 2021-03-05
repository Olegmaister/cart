<?php
namespace common\services\api;

use common\api\oneC\SynchronizeOrder;
use common\entities\City;
use common\entities\Customer;
use common\entities\DataOrderOnec;
use common\entities\Order;
use common\entities\OrderItem;
use common\entities\Products\Product;
use common\entities\Products\ProductStoreOption;
use common\entities\Stock\StockPromo;
use common\entities\Stores\StoreDescription;
use common\entities\Warehouse;
use common\helpers\LanguageHelper;
use common\repositories\CustomerRepository;
use common\repositories\OrderRepository;
use Yii;

class OneCOrderService
{
    const GUEST_GUID = '4831dc8d-14ec-11e9-8126-bcaec5287e74';

    private $synchronizeOrder;
    private $customerRepository;
    private $orderRepository;

    public function __construct(
        SynchronizeOrder $synchronizeOrder,
        CustomerRepository $customerRepository,
        OrderRepository $orderRepository
    )
    {
        $this->synchronizeOrder = $synchronizeOrder;
        $this->customerRepository = $customerRepository;
        $this->orderRepository = $orderRepository;
    }

    //временное тестовое говно
    //paid - ответ платежной системы 0 - не оплачено 1 - оплачено
    //updatePayment - обновление ответа платежной системы
    public function sendOrder($orderId, $paid = 0 , $updatePayment = 0)
    {
        //если пользователь гость
        //отправляем набор даных по пользователю в ответ получаем guid

        //если пользователь auth , проверяем есть ли такой пользователь в системе 1с, как проверяем ?
        //если есть отправлем заказ
        //если нет хз
        $customerGuid = $this->getCustomerGuid();


        $order = $this->orderRepository->getById($orderId);

        $data = $this->formationRequest($order, $customerGuid,  $paid = 0, $updatePayment = 0);

        DataOrderOnec::create($data);

        $orderItems = OrderItem::find()
            ->with('product')
            ->select(['product_id','price','quantity','origin_price','discount_price','option_id'])
            ->where(['order_id' => $order['id']])
            ->asArray()
            ->all();


        foreach ($orderItems as &$orderItem) {

            $presentItem = [];

            $presents = Order\OrderPresent::find()
                ->where(['and',['order_id' => $order->id],['parent_key' => md5($orderItem['product_id'].$orderItem['option_id'])]])
                ->asArray()
                ->all();


            $presentsResArray = [];
            if(isset($presents) && !empty($presents)){
                foreach ($presents as $present) {

                    $productGuid = Product::find()
                        ->where(['product_id' => $present['product_id']])
                        ->asArray()
                        ->one();

                    /**@var ProductStoreOption $optionGuid*/
                    $optionGuidPresent = ProductStoreOption::find()
                        ->where(['and',['product_id' => $present['product_id']],['option_id' => $present['option_id']]])
                        ->one();

                    $presentItem = [
                        'product_id' => $optionGuidPresent->GUID_1C,
                        'price' => $present['price'],
                        'quantity' => $present['quantity'],
                        'origin_price' =>   $productGuid['price'],
                        'discount_price' => 0,
                        'option_id' => $present['option_id']
                    ];

                    $presentsResArray[] = $presentItem;


                }
            }

            $price = 0;
            if(empty($orderItem['price'])){
                $price = $orderItem['origin_price'];
                $orderItem['price'] = $price;
            }

            /**@var ProductStoreOption $optionGuid*/
            $optionGuid = ProductStoreOption::find()
                ->where(['and',['product_id' => $orderItem['product_id']],['option_id' => $orderItem['option_id']]])
                ->one();

            $orderItem['product_id'] = $optionGuid->GUID_1C;
            unset($orderItem['product']);

            $data['order_items'][] = $orderItem;
            $data['order_items'] = array_merge($data['order_items'] , $presentsResArray);


        }

        $result = $this->synchronizeOrder->sendOrderData($data);
        Order::updateAll(['order_guid' => $result['number']], ['id' => $order['id']]);

    }

    private function getCityUkraine($deliveryCity)
    {
        $city = City::find()->where(['id' => (int)$deliveryCity])->one();
        return isset($city->name) ? $city->name : '';
    }

    private function getCityReserve($deliveryStoreId)
    {
        $city = StoreDescription::find()
            ->where(['and',['store_id' => $deliveryStoreId],['language_id' => LanguageHelper::getCurrentId()]])->one();

        return isset($city->city) ? $city->city : '';
    }


    private function getCityName($order)
    {
        switch ($order->delivery_method_id){
            case 1 : return $this->getCityUkraine($order->delivery_city); break;
            case 2 : return $this->getCityUkraine($order->delivery_city); break;
            case 3 : return  isset($order->delivery_city) ? $order->delivery_city : '';break;
            case 4 : return $this->getCityReserve($order->delivery_store_id);break;
        }


    }

    /**
     * @param Order $order
     * @param $customerGuid
     * @param int $paid
     * @param int $updatePayment
     * @return array
     */
    private function formationRequest($order, $customerGuid, $paid = 0, $updatePayment = 0)
    {
        $deliveryBranch = Warehouse::find()
            ->where(['SiteKey' => $order->delivery_branch])
            ->one();

        $promo = StockPromo::find()->where(['id' => $order->promo_id])->one();

        $cityName = $this->getCityName($order);
        $comment = $order->comment ?? '';

        if ($order->call_me === 0 && (int)$order->delivery_method_id !== Order::DELIVERY_URK_POCHTA) {
            $comment .= ' <br>Я уверен в своем заказе, мне можно не перезванивать';
        }


        return [
            "id" => $order->id,
            "customer_id" => $customerGuid,
            "customer_group_id" => null,
            "first_name" => $order->first_name,
            "last_name" => $order->last_name,
            "phone" => str_replace('+', '', $order->phone),
            "email" => $order->email,
            "recipient_first_name" => $order->recipient_first_name,
            "recipient_last_name" => $order->recipient_last_name,
            "recipient_phone" => str_replace('+', '', $order->recipient_phone),
            "recipient_email" => $order->recipient_email,
            "recipient_ttn" => $order->recipient_ttn,
            "delivery_method_id" => (int)$order->delivery_method_id,
            "delivery_cost" => $order->delivery_cost,
            "delivery_country" => $order->delivery_country ? (int)$order->delivery_country : null,
            "delivery_city" => $cityName,
            "delivery_branch" => $deliveryBranch->Ref ?? null,
            "delivery_street" => $order->delivery_street,
            "delivery_house" => $order->delivery_house,
            "delivery_apartment" => $order->delivery_apartment,
            "delivery_porch" => $order->delivery_porch,
            "delivery_state" => $order->delivery_state,
            "delivery_index" => $order->delivery_index,
            "update_payment" => $updatePayment,
            "paid" => $paid,
            "payment_id" => (int)$order->payment_id,
            "payment_addition_id" => $order->payment_addition_id,
            "payment_bank_card" => $order->payment_bank_card,
            "parts" => $order->parts,
            "cost" => $order->cost,
            "funded_cost" => $order->funded_cost,
            "weight" => $order->weight,
            "current_status" => $order->current_status,
            "comment" => $comment,
            "cancel_reason" => $order->cancel_reason,
            "call_me" => $order->call_me,
            "created_at" => $order->created_at,
            "updated_at" => $order->updated_at,
            "delivery_store_id" => isset($order->store) ? $order->store->guid : '',
            "stock_percent" => $order->stock_percent,
            "stock_value" => $order->stock_value,
            "origin_cost" => $order->origin_cost,
            "promo_token" => isset($promo->token) ? $promo->token  : '',
            "order_items" => [],
        ];
    }

    private function getCustomerGuid()
    {
        //если это гость , возвращаем guid по умолчанию
        if(Yii::$app->user->isGuest)
            return self::GUEST_GUID;

        //пробуем найти пользователя
        /**@var Customer $customer*/
        $customer = $this->customerRepository->getProfile(Yii::$app->user->getId());


        //если есть guid, возвращаем guid
        if($customer->checkNotEmptyGuid()){
            return $customer->getGuid();
        }

            //new
        $data = [
            'guid' => $customer->guid,
            'type' => '',
            'type_id' => $customer->type_id,
            'contragent' => $customer->fullName(),
            'first_name' => $customer->profile->first_name,
            'last_name' => $customer->profile->last_name,
            'father_name' => $customer->profile->first_name,
            'country' =>  $customer->profile->country_id,
            'region' => $customer->profile->state,
            'index' => $customer->profile->index,
            'city_id' => null,
            'city_name' => $customer->profile->city_name,
            'street' => $customer->profile->street,
            'house' => $customer->profile->house,
            'apartment' => $customer->profile->apartment,
            'entrance' => $customer->profile->porch,
            'email' => $customer->email,
            'phone' => str_replace('+', '', $customer->phone),
            'phone2' => str_replace('+', '', $customer->profile->phone),
            'born' => $customer->profile->date_birth,
            'gender' => $customer->profile->gender,
            'accumulatedsales' => $customer->profile->accumulation_system,
            'discount' => '',
            'card' => '',
        ];



        //делаем запрос в 1с на получение guid для пользователя
        $result = $this->synchronizeOrder->getGuid($data);

        //обновляем пользователя возвращаем guid
        Customer::updateAll(['guid' => $result['guid']], ['customer_id' => $customer['customer_id']]);

        return $result['guid'];

    }

}


