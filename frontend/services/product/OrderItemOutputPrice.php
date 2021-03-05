<?php

namespace frontend\services\product;

use common\entities\OrderItem;

class OrderItemOutputPrice
{
    private $price;
    private $originPrice;
    private $discountPrice;
    private $quantity;

    public function __construct(OrderItem $item)
    {
        $this->price = $item->price;
        $this->originPrice = $item->origin_price;
        $this->discountPrice = $item->discount_price;
        $this->quantity = $item->quantity;
    }


    public function getPrice(): float
    {
        return $this->price / $this->quantity;
    }


    public function getOriginPrice(): int
    {
        return $this->originPrice;
    }


    public function getDiscountPrice(): float
    {
        return $this->discountPrice;
    }

    public function isExist()
    {
        return (int)$this->getPrice() !== 0;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

}