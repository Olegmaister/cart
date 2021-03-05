<?php

namespace frontend\widgets;

use core\services\cart\Cart;
use yii\base\Widget;

class HeaderCartWidget extends Widget
{
    private $cart;

    public function __construct(Cart $cart, $config = [])
    {
        parent::__construct($config);
        $this->cart = $cart;
    }

    public function run(): string
    {

        return $this->render('header_cart', [
            'cart' => $this->cart,
        ]);
    }
}
