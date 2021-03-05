<?php

namespace core\services\cart;

use common\entities\Products\Product;

class CartItem
{
    private $product;
    private $categoryId;
    private $quantity;
    private $option;
    private $optionName;
    private $productColorImage;

    public function __construct(
        Product $product,
        $quantity,
        $option,
        $optionName,
        $productColorImage
    )
    {

        $this->product = $product;
        $this->categoryId = $product->categoryId->category_id;
        $this->quantity = $quantity;
        $this->option = $option;
        $this->optionName = $optionName;
        $this->productColorImage = $productColorImage;
    }


    public function getId()
    {
        return md5($this->product->product_id.$this->option);
    }

    public function getCost()
    {
        return  $this->getPrice() * $this->quantity;
    }

    public function getPrice()
    {
        return $this->product->price;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function getProductId()
    {
        return $this->product->product_id;
    }


    public function plus(self $other)
    {
        return new static(
            $this->product,
            $this->quantity + $other->getQuantity(),
            $other->option,
            $other->optionName,
            $other->productColorImage
        );
    }

    public function detachPresent()
    {
        $this->present =  PresentItem::emptyBlank();
    }

    public function setPresent($presentItem)
    {
        $this->present = $presentItem;
    }


    public function getWeight(): int
    {
        return $this->product->weight * $this->quantity;
    }

    public function changeQuantity($quantity)
    {
        return new static($this->product, $quantity, $this->option, $this->optionName,$this->productColorImage);
    }


    public function getOptionName()
    {
        return $this->optionName;
    }

    public function getProductColorImage()
    {
        return $this->productColorImage;
    }


    public function getOption()
    {
        return $this->option;
    }

    public function getUniqueId()
    {
        return $this->getProduct()->product_id.$this->option;
    }

    public function getCategoryId()
    {
        return $this->categoryId;
    }


}