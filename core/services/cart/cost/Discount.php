<?php

namespace core\services\cart\cost;

use common\helpers\CheckHelper;


final class Discount
{
    public $stockId;
    private $value;
    private $name;
    private $percent;
    private $type;
    private $currentPrice;
    private $discountPrice;
    private $stock;

    public function __construct(
        $info,
        $price,
        $value = null,
        $quantity = 1
    )
    {
        $this->value = round($value);
        $this->name = isset($info['type']) ? $info['type'] : '';
        $this->currentPrice = $price;
        $this->discountPrice = (($price * $quantity) - $this->value)/ $quantity;
        $this->percent = CheckHelper::isNotEmpty($info) ? $info->percent : null;
        $this->stock = $this->isExist($info);

    }

    public static function createCumulative($cumulatives)
    {
        return new self($cumulatives);
    }

    public function getStock()
    {
        return $this->stock;
    }




    private function isExist($info)
    {
        return CheckHelper::isNotEmpty($info);
    }


    public function getStockId()
    {
        return $this->stockId;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getName()
    {
        return $this->name;
    }


    public function getPercent()
    {
        return $this->percent;
    }

    public function getType()
    {
        return $this->type;
    }

    /**
     * @return false|float
     */
    public function getDiscountPrice()
    {
        return $this->discountPrice;
    }
}
