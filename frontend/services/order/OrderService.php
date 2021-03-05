<?php

namespace frontend\services\order;

use common\entities\Customer;
use common\entities\Order;
use common\entities\Order\DeliveryData;
use common\entities\Order\OrderPresent;
use common\entities\OrderItem;
use common\repositories\CustomerRepository;
use common\repositories\DeliveryMethodRepository;
use common\repositories\OrderRepository;
use common\repositories\PaymentAdditionRepository;
use common\repositories\ProductRepository;
use common\services\order\PaymentService;
use common\services\TransactionManager;
use frontend\forms\order\OrderForm;
use core\services\cart\Cart;
use core\services\cart\PresentItem;
use Yii;

class OrderService
{
    private $cart;
    private $orders;
    private $orderItemService;
    private $products;
    private $customers;
    private $deliveryMethods;
    private $additionRepository;
    private $paymentService;
    private $transaction;

    public function __construct(
        Cart $cart,
        OrderRepository $orders,
        OrderItemService $orderItemService,
        ProductRepository $products,
        CustomerRepository $customers,
        DeliveryMethodRepository $deliveryMethods,
        PaymentAdditionRepository $additionRepository,
        PaymentService $paymentService,
        TransactionManager $transaction
    )
    {
        $this->cart = $cart;
        $this->orders = $orders;
        $this->orderItemService = $orderItemService;
        $this->products = $products;
        $this->customers = $customers;
        $this->deliveryMethods = $deliveryMethods;
        $this->additionRepository = $additionRepository;
        $this->paymentService = $paymentService;
        $this->transaction = $transaction;
    }


    /**@var Cart $cart*/
    public function checkout($userId, OrderForm $form, $weight, $cart, $promo): Order
    {

        //если пользователь(гость) и хочет зарегистрироваться,
        //отметил checkbox в форме
        if($form->ifCustomerRegisters()){
            //вынести в customerService
            $userId = $this->quickRegistration($form);
        }

        //получаем пользователя
        $customer = $this->customers->getByIdGuest($userId);

        //перебрасываем товары из корзины в orderItem(entities)
        $items = $this->orderItemService->moveProducts($this->cart, $form, $promo);

        //получение скидки (money скидки)
        $discountMoney = $this->cart->getCost($promo)->getDiscount();
        //получение скидки (% скидки)
        //$discountPercent = $this->cart->getCost($promo)->getPercentByDiscount($discountMoney);old version
        $discountPercent = $this->cart->getCost($promo)->getDiscountPercent($discountMoney);



        //создание заказа
        $order = Order::create
        (
            $customer,
            $form->delivery->country,
            $form->delivery->method,
            $weight,
            $form->paymentForm->paymentMethod,
            $form->paymentForm->typePayment,
            $form->cost
        );

        //set promo
        if(isset($promo) && !empty($promo)){
            $order->setPromoId($promo);
        }


        $order->parts = $form->paymentForm->parts;
        $order->comment = $form->comment;
        $order->call_me = (int)($form->noCallMe !== 'on');
        $order->delivery_state = $form->foreignersUp->state;

        if(isset($form->recipient->ttn) && is_string($form->recipient->ttn)){
            $order->setRecipientTtn($form->recipient->ttn);
        }

        //привязываем всю информацию по оплате
        $order->setPaymentInfo(
            /** @var Order\Assistants\PaymentAssistant*/
            $this->paymentService->getPaymentInfo(
                $form->delivery->method,
                $form->paymentForm->paymentMethod,
                $form->paymentForm->typePayment,
                $form->paymentForm->parts
            )
        );

        /*======еще методы=====*/
        $order->setCost($this->cart->getCost($promo)->getTotal() + $form->cost + $this->cart->getPresentPrice());


        //установка оригинальной цены
        $order->setOriginCost($cart, $this->cart->getPresentPrice());


        //если оплата банковской картой,
        //присваиваем имя [LiqPay|wayForPay|privat_pp]
        //$order->setPaymentBankCardName();

        $order->stock_percent = $discountPercent;
        $order->stock_value = $discountMoney;

        //привязываем товары к заказу
        $order->setProducts($items);

        //устанавливаем информацию о покупателе
        $order->setBuyer(
            $form->firstName,
            $form->lastName,
            $form->email,
            $form->phone,
            $form->comment
        );

        //устанавливаем информацию о платильщике
        $order->setPayer(
            $form->recipient->firstName,
            $form->recipient->lastName,
            $form->recipient->email,
            $form->recipient->phone
        );

        $order->delivery_store_id = $form->storeReservation->store;

        $deliveryData = null;

        switch ($form->delivery->method){
            case 1:
                $deliveryData = new DeliveryData($form->courierNp);
                break;
            case 2:
                $deliveryData = new DeliveryData($form->officeNp);
                break;
            case 3:
                $deliveryData = new DeliveryData($form->foreignersUp);
                break;
            case 4:
                $deliveryData = new DeliveryData($form->storeReservation);
                break;
        }

        $order->setDeliveryInformation($deliveryData);

        $this->transaction->wrap(function () use ($order, $customer, $items) {

            /* @var OrderItem $item**/
            foreach ($items as $item) {
                /* @var PresentItem[] $presentItem**/
                $presentItems = $item->present;


                if(is_array($presentItems)){
                    foreach ($presentItems as $presentItem) {
                        $present = OrderPresent::create($presentItem,$item->parentKey());
                        $order->assignPresent($present);
                    }
                }

            }

            //работа с суммой
            //1 участвует пользователь в накопительной системе уктуальной
            $order->setFundedCost($this->cart->getCost()->getTotal());

//            if(isset($customer->profile)){
//                /**@var Customer\Profile $profile*/
//                $profile = $customer->profile;
//                $customer->assignProfileAccumulation($order->funded_cost, $this->cart->getPresentPrice());
//                $this->customers->save($customer);
//            }

            $this->orders->save($order);

            $this->cart->clear();
        });

        return $order;
    }

    public function getPaymentMethods(int $deliveryId,$languageId)
    {

        //TODO вынести в репо
        $result = (new \yii\db\Query())
            ->select(['payments.id','payment_descriptions.name','payment_descriptions.description','payments.sort'])
            ->from('delivery_methods')
            ->innerJoin('delivery_payment_methods','delivery_methods.id = delivery_payment_methods.delivery_method_id')
            ->innerJoin('payments','delivery_payment_methods.payment_id = payments.id')
            ->innerJoin('payment_descriptions','payment_descriptions.payment_id = payments.id')
            ->where(['and',['delivery_methods.id' => $deliveryId],['payment_descriptions.language_id' => $languageId]])
            ->orderBy(['payments.sort' => SORT_ASC])
            ->all();


        //TODO : вынести и переделать
        $payments = [];
        foreach ($result as $item) {
            $payments[] = ['id' => $item['id'],'name' => $item['name'],'description' => $item['description'],'sort' => $item['sort']];
        }

        return $payments;

    }


    private function quickRegistration(OrderForm $form)
    {

        $auth = Yii::$app->authManager;
        $roleCustomer = $auth->getRole('customer');


        $customer = Customer::signup(
            $form->firstName,
            $form->email,
            $form->phone,
            $form->password
        );

        $profile = $customer->assignProfileSignup($form);


        if(!$customer->save()){
            throw new \RuntimeException('Saving error.');
        }

        Yii::$app->user->login($customer,3600 * 24 * 30);


        //set role default
        $auth->assign($roleCustomer, $customer->customer_id);

        return $customer->customer_id;
    }
}

