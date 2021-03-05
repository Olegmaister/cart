<?php

namespace core\services\cart;

use common\helpers\LanguageHelper;
use common\repositories\ProductRepository;

class CartService
{
    private $repository;
    private $cart;
    public function __construct(ProductRepository $repository, Cart $cart)
    {
        $this->repository = $repository;
        $this->cart = $cart;
    }

    public function getCart()
    {
        return $this->cart;
    }

    public function cost()
    {
        $this->cart->getCost();
    }

    public function add($productId, $quantity, $option, $optionName,$productColorImage)
    {
        $product = $this->repository->getByIdCart($productId);

        $this->cart->add(new CartItem($product, $quantity, $option, $optionName,$productColorImage));
    }

    public function set($productId, $optionId, $quantity): void
    {
        $this->cart->set($productId, $optionId, $quantity);
    }

    public function remove($productId, $optionId)
    {
        $this->cart->remove($productId, $optionId);
    }

}