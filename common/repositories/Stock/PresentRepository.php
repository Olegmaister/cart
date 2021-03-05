<?php
namespace common\repositories\Stock;

use common\entities\Stock\StockPresent;

class PresentRepository
{
    public function deleteAllStockId(int $stockId)
    {
        StockPresent::deleteAll(['stock_id' => $stockId]);
    }
}
