<?php

namespace common\entities\Stock;

use common\entities\Products\Product;
use Yii;

/**
 * This is the model class for table "{{%stock_cumulative}}".
 *
 * @property int $id
 * @property int $stock_id
 * @property int $product_id
 *
 * @property Product $product
 * @property Stock $stock
 */
class StockCumulative extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%stock_cumulative}}';
    }


    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['product_id' => 'product_id']);
    }

    /**
     * Gets query for [[Stock]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStock()
    {
        return $this->hasOne(Stock::class, ['id' => 'stock_id']);
    }
}
