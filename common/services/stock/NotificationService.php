<?php
namespace common\services\stock;

use common\entities\Products\Product;
use common\entities\Stock\NotificationStock;
use core\services\cart\cost\Discount;
use core\services\cart\DiscountService;

class NotificationService
{

    private $discountService;

    public function __construct(DiscountService $discountService)
    {
        $this->discountService = $discountService;
    }


    public function notificationBayer(NotificationStock $notification)
    {
        //dd($notification->getProductIds());
    }

    public function getPriceProductDiscount(int $productId)
    {
            $product = Product::find()->where(['product_id' => $productId])->one();
            $stock = $this->discountService->getCurrentProductPrice($product);

            if(!isset($stock) || empty($stock))
                return null;

            return $this->discountService->getCurrentDiscountByProduct($product, $stock);
    }


    public function getPriceProduct(int $productId)
    {
            $product = Product::find()->where(['product_id' => $productId])->one();

            if(!$product)
                return false;

            $stock = $this->discountService->getCurrentProductPrice($product);

            if(!isset($stock) || empty($stock))
                return $product->price;

            /* @var Discount**/
            $discount = $this->discountService->getCurrentDiscountByProduct($product, $stock);

            return $discount->getDiscountPrice();


    }
}
