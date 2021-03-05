<?php
namespace frontend\services\order;

use common\entities\OrderItem;
use common\entities\Stock\StockPromo;
use core\services\cart\Cart;
use core\services\cart\CartItem;
use core\services\cart\cost\Cost;
use core\services\cart\cost\Discount;
use core\services\cart\PresentItem;

class OrderItemService
{
    public function moveProducts(Cart $cart, $form, $promo)
    {
        $products = [];

        $items = array_map(function (CartItem $item) use (&$products, $form, $cart, $promo) {
            //получем наш товар из объекта
            $product = $item->getProduct();
            $price = $item->getPrice();

            /**@var Cost $cost*/
            $cost = $cart->getCost($promo);

            $stockId = null;
            $stockPercent = null;
            $stockPrice = 0;
            $discountPrice = 0;

            /**@var Discount $discountValue*/
            if($discountValue = $cost->isIdEqualTo($product->product_id.$item->getOption())){
                if(isset($discountValue) && !empty($discountValue))
                    $stockPrice = $discountValue->getDiscountPrice();
                //получение размера скидки
                $discountPrice = $discountValue->getValue() / $item->getQuantity();
            }

            // todo : нужно изминить кол-во товара
            //в массив сохраняем товар, уже с уменьшеным количеством товара
            $products[] = $product;
            //заполняем наше представление OrderItem(хранить товары по заказу)
            $orderItem = OrderItem::create(
                $product,
                $item->getOption(),
                $item->getOptionName(),
                $item->getProductColorImage(),
                $product->price,
                $item->getQuantity(),
                $item->getPresent()
            );


            $orderItem->price = $stockPrice;
            $orderItem->discount_price = $discountPrice;


            return $orderItem;

        }, $cart->getItems());

        return $items;

    }
}