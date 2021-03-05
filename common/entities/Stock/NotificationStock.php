<?php
namespace common\entities\Stock;

class NotificationStock
{
    private $productIds;
    private $stock;

    public function __construct(array $productIds, Stock $stock)
    {
        $this->productIds = $productIds;
        $this->stock = $stock;
    }

    /**
     * @return array
     */
    public function getProductIds(): array
    {
        return $this->productIds;
    }

    /**
     * @return Stock
     */
    public function getStock(): Stock
    {
        return $this->stock;
    }
}