<?php

namespace common\entities\queries;

use common\entities\Stock\Stock;
use common\helpers\DateHelper;
use yii\db\ActiveQuery;

class StockQuery extends ActiveQuery
{
    public function relevant()
    {
        return $this->andWhere(['and',
            ['stock.active' => Stock::STATUS_ACTIVE],
            ['<','stock.date_from', DateHelper::getCurrentTime()],
            ['>','stock.date_to', DateHelper::getCurrentTime()],
        ]);
    }

    public function relevantProduct($productId)
    {
        return $this->where(['and',
            ['stock_product.product_id' => $productId],
            ['stock.active' => Stock::STATUS_ACTIVE],
            ['<','stock.date_from', DateHelper::getCurrentTime()],
            ['>','stock.date_to', DateHelper::getCurrentTime()]
        ]);
    }

    public function relevantBrand($brandId)
    {
        return $this->where(['and',
            ['brand_id' => $brandId],
            ['stock.active' => Stock::STATUS_ACTIVE],
            ['<','stock.date_from', DateHelper::getCurrentTime()],
            ['>','stock.date_to', DateHelper::getCurrentTime()]
        ]);
    }

    public function relevantCategories($categorieIds)
    {
        return $this->where(['and',
            ['in','category_id',$categorieIds],
            ['stock.active' => Stock::STATUS_ACTIVE],
            ['<','stock.date_from', DateHelper::getCurrentTime()],
            ['>','stock.date_to', DateHelper::getCurrentTime()]
        ]);
    }
}

