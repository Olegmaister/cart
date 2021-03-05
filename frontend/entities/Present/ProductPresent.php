<?php
namespace frontend\entities\Present;

class ProductPresent
{
    private $productId;
    private $name;
    private $image;
    private $options;

    public function __construct($product, $options)
    {
        $this->productId = $product->product_id;
        $this->image = $product->image;
        $this->name = $product->description->name;
        $this->options = $this->getOptionsInfo($options);
    }


    private function getOptionsInfo($options)
    {
        $resOptions = [];
        foreach ($options as $option) {
            $description = $option->description;
            $resOptions[] = ['option_id' => $description['option_id'],'name' => $description['name']];
        }

        return $resOptions;

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

}