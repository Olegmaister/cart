<?php

namespace common\entities\queries;

use yii\db\ActiveQuery;

class StockDescriptionQuery extends ActiveQuery
{
    public function description ($stockId, $languageId)
    {
        return $this->andWhere(['and',
            ['and',['stock_id' => $stockId],['language_id' => $languageId] ],
        ]);
    }
}
