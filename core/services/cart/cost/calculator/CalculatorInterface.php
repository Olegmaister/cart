<?php

namespace core\services\cart\cost\calculator;

use core\services\cart\cost\Cost;
use core\services\cart\CartItem;
interface CalculatorInterface
{
    /**
     * @param CartItem[] $items
     * @return Cost
     */
    public function  getCost(array $items, $promo = null): Cost;
} 