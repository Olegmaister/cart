<?php

namespace frontend\services\api\payments;

use common\entities\Order;
use common\entities\OrderItem;
use common\repositories\OrderItemRepository;
use DateTime;
use WayForPay\SDK\Collection\ProductCollection;
use WayForPay\SDK\Credential\AccountSecretCredential;
use WayForPay\SDK\Domain\Client;
use WayForPay\SDK\Domain\Product;
use WayForPay\SDK\Wizard\PurchaseWizard;
use yii\helpers\Url;

class WayForPayDataService
{
    private $itemRepository;

    public function __construct(OrderItemRepository $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    public function getData(Order $order)
    {
        $credential = new AccountSecretCredential('freelance_user_5e6f2b6754a7d', '1696debd418904d07b724faa285cec76daf8a3b3');

        $payerFirstName = $order->getFirstNamePayer();
        $payerLastName = $order->getLastNamePayer();
        $payerEmail = $order->getEmailPayer();
        $payerPhone = $order->getPhonePayer();
        $payerCountry = $order->getCountryPayer();

        $products = $this->getProducts($order);

        return PurchaseWizard::get($credential)
            ->setOrderReference($order->id)
            ->setAmount($order->cost)
            ->setCurrency('UAH')
            ->setOrderDate(new DateTime())
            ->setMerchantDomainName(Url::home(true))
            ->setClient(new Client(
                $payerFirstName,
                $payerLastName,
                $payerEmail,
                $payerPhone,
                $payerCountry
            ))
            ->setProducts(new ProductCollection(
                $products
            ))
            ->setReturnUrl(Url::home(true) . 'checkout/empty')
            ->setServiceUrl(Url::home(true) . 'response-wayforpay')
            ->getForm()
            ->getAsString();
    }

    private function getProducts(Order $order)
    {
        $products = [];

        $data = $this->itemRepository->getProducts($order->id);


        /** @var OrderItem $item */
        foreach ($data as $item) {
            //$products[] = new Product($item->product_name, $item->price, $item->quantity);
            //костыль
            $products[] = new Product($item->product_name, $item->origin_price, $item->quantity);
        }

        return $products;
    }
}
