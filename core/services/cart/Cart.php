<?php

namespace core\services\cart;

use core\services\cart\cost\calculator\CalculatorInterface;
use core\services\cart\storage\StorageInterface;

class Cart
{
    private $storage;
    private $calculator;

    public function __construct(StorageInterface $storage, CalculatorInterface $calculator)
    {
        $this->storage = $storage;
        $this->calculator = $calculator;
    }

    /**@var $items CartItem[]**/
    private $items;

    /** @var $quntity - quantity product*/
    public function add(CartItem $item)
    {

        //get load elements
        $this->loadItems();

        foreach ($this->items as $i => $current) {
            if($current->getId() == $item->getId()){
                $this->items[$i] = $current->plus($item);
                $this->saveItems();
                return;
            }
        }
        $this->items[] = $item;

        //save elements
        $this->saveItems();

    }


    public function getItems()
    {
        $this->loadItems();
        return $this->items;
    }


    public function getQuantity()
    {
        return count($this->getItems());
    }

    public function isEmpty()
    {
        return empty($this->getItems());
    }

    public function set($productId, $optionId, $quantity): void
    {

        $this->loadItems();

        foreach ($this->items as $i=> &$current) {
            if($current->getId() == md5($productId.$optionId)){
                $this->items[$i] = $current->changeQuantity($quantity);
                $this->saveItems();
                return;
            }
        }

        throw new \DomainException('Item is not found');
    }


    public function getAmount()
    {
        $this->loadItems();
        return count($this->items);
    }

    public function getCost($promo = null)
    {
        $this->loadItems();
        return $this->calculator->getCost($this->items,$promo);
    }


    /** @var $id - id строки*/
    public function remove($productId, $optionId)
    {
        $this->loadItems();

        foreach ($this->items as $i=>$current) {
            if($current->getId() == md5($productId.$optionId)){
                unset($this->items[$i]);
                $this->saveItems();
                return;
            }
        }

        throw new \DomainException('Item is not found');
    }

    public function getWeight(): int
    {
        $this->loadItems();

        return array_sum(array_map(function (CartItem $item) {

            return $item->getWeight();
        }, $this->items));
    }


    public function getDiscount()
    {
        return $this->getCost()->getDiscount();
    }

    public function getPercentByDiscount()
    {

        $value =  $this->getDiscount();

        if($value == 0)
            return 0;

        return round(($value  * 100)/$this->getCost()->getOrigin());

    }


    public function clear()
    {
        $this->loadItems();
        $this->items = [];
        $this->saveItems();
    }


    private function loadItems()
    {
        if ($this->items === null) {
            $this->items = $this->storage->load();
        }
    }

    private function saveItems()
    {
        $items = $this->items;

        $this->storage->save($items);
    }
} 