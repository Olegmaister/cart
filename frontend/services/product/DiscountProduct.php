<?php

namespace frontend\services\product;


use common\entities\Products\Product;
use common\entities\Stock\Stock;

class DiscountProduct
{
    private $type;
    private $percent;
    private $money;
    private $price;
    private $discountPrice;
    private $countingMethod;

    private $_stock;

    public function __construct($product,$stock = null)
    {

        $this->price = $product['price'];

        if(isset($stock)){
            $this->_stock = $stock;
            $this->countingMethod = $stock['counting_method'];
            $this->money = $stock['money'];
            $this->percent = $stock['percent'];
            if($stock->counting_method == Stock::COUNTING_MONEY){
                $this->discountPrice = $this->calculateDiscountMoney();
            }else{
                $this->discountPrice = $this->calculateDiscount();
            }
        }

    }

    public function getPrice(): float
    {
        return $this->price;
    }


    public function getDiscountPrice()
    {
        return $this->discountPrice;
    }

    private function calculateDiscount()
    {
        return $this->getPrice() - (($this->percent * $this->price) / 100);
    }

    private function calculateDiscountMoney()
    {
        $result = $this->getPrice() - $this->money;
        if($result < 1){
            return 1;
        }


        return $result;

    }

    public function isExist()
    {
        return $this->_stock;
    }

}
