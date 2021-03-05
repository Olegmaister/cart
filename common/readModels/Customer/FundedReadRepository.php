<?php

namespace common\readModels\Customer;


use common\entities\Stock\Stock;
use common\entities\Stock\StockFunded;
use common\helpers\ArrayHelper;
use common\helpers\DateHelper;

class FundedReadRepository
{
    public function getAll()
    {
        return StockFunded::find()->joinWith('stock')->orderBy(['percent' => SORT_ASC])->all();
    }

    public function getPercentCustomer($customerCost)
    {
        $stocks = StockFunded::find()
            ->joinWith('stock')
            ->where(
                ['and',
                    ['<','cost',$customerCost],
                    ['stock.active' => Stock::STATUS_ACTIVE],
                    ['<','stock.date_from', DateHelper::getCurrentTime()],
                    ['>','stock.date_to', DateHelper::getCurrentTime()]])
            ->orderBy(['cost' => SORT_DESC])
            ->all();

        return $this->getAnswerDiscount($stocks);
    }

    private function getAnswerDiscount($discounts)
    {

        $items = ArrayHelper::getArrayByKey($discounts, 'stock');

        $stock = ArrayHelper::getMaxValue($items);

        if($stock)
            return $stock;

        return null;
    }
}
