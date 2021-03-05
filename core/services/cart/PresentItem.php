<?php

namespace core\services\cart;
use common\entities\Options\OptionDescription;
use common\entities\Products\Product;

class PresentItem
{
    private $id;
    private $productId;
    public $quantity;
    private $productName;
    private $option;
    private $optionName;
    private $presentImage;
    private $product;

    public static function create($productId, $option, $optionName, $product, $quantity = 1)
    {
        $object = new self();
        $object->id = md5($productId.$option);
        $object->productId = $productId;
        $object->productName = self::getPresentNameProduct($productId);
        $object->option = $option;
        $object->optionName = $optionName;
        $object->presentImage = self::getPresentImageProduct($productId);
        $object->product = $product;
        $object->quantity = $quantity;

        return $object;
    }

    public static function createFast($productId, $option, $optionName, $product = null, $quantity = 1)
    {
        $object = new self();
        $object->id = md5($productId.$option);
        $object->productId = $productId;
        $object->productName = self::getPresentNameProduct($productId);
        $object->option = $option;
        $object->optionName = $optionName;
        $object->presentImage = self::getPresentImageProduct($productId);
        $object->product = $product;
        $object->quantity = $quantity;

        return $object;
    }

    public static function emptyBlank()
    {
        return new self();
    }

    public function exists()
    {
       return !empty($this->productId);
    }


    public function setQuantity($quantity)
    {
        $this->quantity  +=  $quantity;

    }

    public function getNameOption($optionId, $languageId)
    {
        $option = OptionDescription::find()
            ->where(['and',['option_id' => $optionId],['language_id' => 1]])
            ->one();

        return $option->name;

    }

    private static function getPresentImageProduct($productId)
    {
        $product = Product::find()->where(['product_id' => $productId])->one();
//        return $product->image;
        return '';
    }

    private static function getPresentNameProduct($productId)
    {
        $product = Product::find()->with('description')->where(['product_id' => $productId])->one();
//        return $product->description->name;
        return '';
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function getPresentImage()
    {
        return $this->presentImage;
    }

    /**
     * @return mixed
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * @return mixed
     */
    public function getOption()
    {
        return $this->option;
    }

    /**
     * @return mixed
     */
    public function getOptionName()
    {
        return $this->optionName;
    }

    /**
     * @return int
     */
    public function getId(): string
    {
        return $this->id;
    }

    public function getProductName(): string
    {
        return $this->productName;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }
}
