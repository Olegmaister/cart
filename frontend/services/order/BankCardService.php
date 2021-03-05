<?php
namespace frontend\services\order;

use common\entities\Order;
use common\entities\OrderItem;
use common\repositories\OrderItemRepository;
use common\repositories\OrderRepository;
use frontend\services\api\payments\LiqPayDataService;
use frontend\services\api\payments\PrivatDataService;
use frontend\services\api\payments\WayForPayDataService;

class BankCardService
{
    private $orderRepository;
    private $liqPayService;
    private $privatService;
    private $wayForPayService;
    private $itemRepository;

    public function __construct(
        OrderRepository $orderRepository,
        LiqPayDataService $liqPayService,
        PrivatDataService $privatService,
        WayForPayDataService $wayForPayService,
        OrderItemRepository $itemRepository
        )
    {
        $this->orderRepository = $orderRepository;
        $this->liqPayService = $liqPayService;
        $this->privatService = $privatService;
        $this->wayForPayService = $wayForPayService;
        $this->itemRepository = $itemRepository;
    }

    public function creditCardPaymentLiqPay($orderId)
    {
        $order = $this->getOrder($orderId);

        return $this->liqPayService->getData($order, 'pay');
    }

    public function creditCardPaymentPrivat($orderId)
    {
        $order = $this->getOrder($orderId);

        $partsCount = $order->getParts();
        $productsList = $this->getProductListPrivat($order->id);

        //формирование товаров

        //вызов метода формирования запроса к api
        return $this->privatService->getData($partsCount, $productsList, $order);
    }

    public function creditCardPaymentWay($orderId)
    {
        $order = $this->getOrder($orderId);

        return $this->wayForPayService->getData($order);
    }


    public function getProductListPrivat($orderId)
    {

        $data = $this->itemRepository->getProducts($orderId);
        $products = [];

        /**@var OrderItem $item*/
        foreach ($data as $item) {
            $products[] = [
                "name" => $item->product_name,
                "count" => $item->quantity,
                "price" => $item->origin_price - $item->discount_price
            ];
        }


        $order = Order::find()->where(['id' => $orderId])->one();

        $products[] = [
            "name" => 'Доставка',
            "count" => 1,
            "price" => $order->delivery_cost
        ];


        return $products;
    }

    public function getStoreIdPrivat()
    {
        return $this->privatService->getStoreId();
    }

    public function getPasswordPrivat()
    {
        return $this->privatService->getPassword();
    }

    private function getOrder($orderId)
    {
        return $this->orderRepository->get($orderId);
    }
}
