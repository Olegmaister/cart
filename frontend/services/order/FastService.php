<?php

namespace frontend\services\order;

use common\entities\Order;
use common\entities\Order\OrderPresent;
use common\entities\OrderItem;
use common\entities\Products\Product;
use common\helpers\ArrayHelper;
use common\repositories\CustomerRepository;
use common\repositories\OrderRepository;
use common\repositories\ProductRepository;
use common\services\customer\CustomerService;
use common\services\stock\DiscountsStockService;
use frontend\forms\product\FastForm;
use frontend\services\cart\cost\Discount;
use frontend\services\cart\DiscountService;
use frontend\services\cart\PresentItem;
use Yii;

class FastService
{
    private $customerService;
    private $repository;
    private $productRepository;
    private $customerRepository;
    private $discountService;

    private $service;

    public function __construct(
        CustomerService $customerService,
        OrderRepository $repository,
        ProductRepository $productRepository,
        CustomerRepository $customerRepository,
        DiscountService $discountService,
        DiscountsStockService  $service
        )
    {
        $this->customerService = $customerService;
        $this->repository = $repository;
        $this->productRepository = $productRepository;
        $this->customerRepository = $customerRepository;
        $this->discountService = $discountService;
        $this->service = $service;
    }

    public function checkout(FastForm $form, $weight, $cart)
    {
        //поиск пользователя
        $customer = $this->customerService->getProfile();
        $product = $this->productRepository->getId($form->productId);

        $stockPrice = 0;
        $discountPrice = 0;

        $discountValue = $this->service->getProductDiscount($product, $customer);


        $orderItem =  OrderItem::create(
            $product,
            $form->optionId,
            $form->optionName,
            $form->productColorImage,
            $product->price,
            1,
            $this->getPresent($form)
        );


        $orderItem->price = $stockPrice;
        $orderItem->discount_price = $discountPrice;

        if(isset($discountValue)){
            $orderItem->price = $discountValue->getDiscountPrice();
            $orderItem->discount_price = $discountValue->getValue();
        }

        $order = Order::fastCreate($customer, $orderItem, $form, $product);

        $order->setOriginCostReserv($product->price);

        $order->stock_percent = isset($discountValue) ? $discountValue->getPercent() : null;
        $order->stock_value = isset($discountValue) ? $discountValue->getValue() : null;

            /* @var PresentItem $presentItem**/
            $presentItem = $orderItem->present;


            if($presentItem->exists()){
                $present = OrderPresent::create($presentItem,$orderItem->parentKey());
                $order->assignPresent($present);
            }

        //установка способа оплаты
        $order->setPayment($form->paymentId);

        if($order->payment_id == 2){
            $order->setPaymentBankCard('wayForPay');
            $order->setPaymentAdditionId(2);
        }


        $delivery = Order\FastDeliveryData::create(
            2,
            804,
            $form->city,
            100,
            $form->branch);


        $order->setDeliveryInfo(
            $delivery
        );


        //получаем пользователя
        $customer = $this->customerRepository->getByIdGuest(Yii::$app->user->getId());

        $this->repository->save($order);
        return $order;

    }

    public function getPriceDiscount(int $productId)
    {

        //поиск пользователя
        $customer = $this->customerService->getProfile();
        $product = $this->productRepository->getId($productId);

        //если товар в распродаже , возвращаем price
        //вынести в отдельный метод , что бы был общий
        if($product->inSale()){
            return $product->getPrice();
        }

            //если пользователь auth получить возможную скидку для него
            $discountCustomer = [];
            if(isset($customer)){
                /*получение скидки пользователя*/
                // - скидка группы в которой состоит пользователь
                // - скидка конкретно для пользователя
                // - накопительная система
                $discountCustomer[] = $this->discountService->getUserGroupDiscount($customer);

            }

            //получение возможной скидки по товару
            $data[] = $this->discountService->getInfoDiscount($product, $discountCustomer, null);


            $discount = $this->discountService->getMaxValue(ArrayHelper::merge($discountCustomer, $data));

            if($discount){
                $value = floor(($product->getPrice() / 100) * $discount->percent) * 1;


                $discountValue = new Discount($discount,$product->getPrice(), $value);
                $stockPrice = $discountValue->getDiscountPrice();
                //получение размера скидки
                $discountPrice = $discountValue->getValue();

            }

            if(!isset($discountValue))
                return $product->getPrice();

            return $discountValue->getDiscountPrice();
    }

    public function getPriceDiscountCopy(int $productId)
    {

        $resArray = [];

        //поиск пользователя
        $customer = $this->customerService->getProfile();
        $product = $this->productRepository->getId($productId);

        //если товар в распродаже , возвращаем price
        //вынести в отдельный метод , что бы был общий
        if($product->inSale()){
            $resArray['price'] =  $product->getPrice();
            $resArray['discount'] = 0;
            return $resArray;
        }

            //если пользователь auth получить возможную скидку для него
            $discountCustomer = [];
            if(isset($customer)){
                /*получение скидки пользователя*/
                // - скидка группы в которой состоит пользователь
                // - скидка конкретно для пользователя
                // - накопительная система
                $discountCustomer[] = $this->discountService->getUserGroupDiscount($customer);

            }

            //получение возможной скидки по товару
            $data[] = $this->discountService->getInfoDiscount($product, $discountCustomer, null);


            $discount = $this->discountService->getMaxValue(ArrayHelper::merge($discountCustomer, $data));

            if($discount){
                $value = floor(($product->getPrice() / 100) * $discount->percent) * 1;


                $discountValue = new Discount($discount,$product->getPrice(), $value);
                $stockPrice = $discountValue->getDiscountPrice();
                //получение размера скидки
                $discountPrice = $discountValue->getValue();

            }




            if(!isset($discountValue)){
                $resArray['price'] =  $product->getPrice();
                $resArray['discount'] = 0;
            }else{
                $resArray['price'] =  $discountValue->getDiscountPrice();
                $resArray['discount'] = $discountValue->getValue();
            }


            return $resArray;
    }

        private function getPresent(FastForm $form)
        {
            if($form->existsPresent())
            {

                $product = Product::find()
                    ->select(['product_id','image','color'])
                    ->where(['product.product_id' => $form->presentId])
                    ->with(['url'],['description' => function($q){
                        $q->where(['language_id' => \Yii::$app->language]);
                        $q->select(['name']);
                    }])
                    ->one();

                return PresentItem::create(
                    $form->presentId,
                    $form->presentOptionId,
                    $form->presentOptionName,
                    $product
                );
            }

            return PresentItem::emptyBlank();
        }

}


