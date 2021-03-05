<?php

namespace core\services\cart\cost;

final class Cost
{
    private $value;
    private $discounts = [];

    public function __construct(float $value, array $discounts = [])
    {
        $this->value = $value;
        $this->discounts = $discounts;
    }

    public function withDiscount(Discount $discount): self
    {
        return new static($this->value, array_merge($this->discounts, [$discount]));
    }

    public function getOrigin(): float
    {
        return $this->value;
    }

    public function getDiscount()
    {
        $value = 0;
        foreach ($this->discounts as $discount) {
            $value += $discount->getValue();
        }

        return (int)$value;
    }

    public function getDiscountPercent($value)
    {
        if($value == 0)
            return false;
        return intval(($value  * 100)/$this->getOrigin());

    }


    public function getTotal(): float
    {
        $value = $this->value - array_sum(array_map(function (Discount $discount) {
            return $discount->getValue();
        }, $this->discounts));

        return (int)$value;
    }

    /**
     * @return Discount[]
     */
    public function getDiscounts(): array
    {
        return $this->discounts;
    }

    public function getDiscountProduct($productId)
    {
        return $this->discounts[$productId];

    }

    public function getValue()
    {
        return $this->value;
    }

    public function isIdEqualTo($productId)
    {
        if(isset($this->discounts[$productId])){
            $discount =  $this->discounts[$productId];
            return $discount;
        }

        return null;
    }



    public function getName()
    {
        return $this->name;
    }


}