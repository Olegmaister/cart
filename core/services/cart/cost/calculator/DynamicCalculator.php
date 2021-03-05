<?php

namespace core\services\cart\cost\calculator;

use core\services\cart\cost\Cost;

class DynamicCalculator implements CalculatorInterface
{
    private $next;

    public function __construct(CalculatorInterface $next)
    {
        $this->next = $next;
    }

    public function getCost(array $items, $promo = null): Cost
    {
        $cost = $this->next->getCost(
            $items,
            $promo
        );

        return $cost;
    }


}