<?php

namespace core\services\cart\cost\calculator;

use common\entities\Products\Product;
use core\services\cart\CartItem;
use core\services\cart\cost\Cost;
use core\services\cart\cost\Discount;
use core\services\cart\DiscountService;

class DiscountCalculator implements CalculatorInterface
{
    private $service;

    public function __construct(DiscountService $service)
    {
        $this->service = $service;
    }

    public function getCost(array $items, $promo = null): Cost
    {

        $customer = \Yii::$app->user->identity;
        $cost = 0;
        $discounts = [];
        /*получение скидки пользователя*/
        // - скидка сегмента в котором состоит пользователь
        // - скидка конкретно для пользователя
        // - накопительная система , если это розница


        if(!empty($items)){
            /**@var CartItem $item*/
            foreach ($items as $item) {
                $data = [];
                /**@var Product $product*/
                $product = $item->getProduct();
                $discounts[$product->product_id.$item->getOption()] = new Discount([], null);

            }
        }

        $objectCost =  new Cost($cost, $discounts);
        return $objectCost;
    }

}