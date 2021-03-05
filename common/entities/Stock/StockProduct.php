<?php

namespace common\entities\Stock;

use common\entities\Products\Product;
use common\entities\Products\ProductDescription;
use common\entities\queries\StockQuery;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 * This is the model class for table "{{%stock_product}}".
 *
 * @property int $id
 * @property int $stock_id
 * @property int $product_id
 * @property Json $segment_json
 *
 * @property Product $product
 * @property Stock $stock
 */
class StockProduct extends ActiveRecord
{
    public static function create($productId,$segments)
    {
        $object = new self();
        $object->product_id = $productId;
        $object->segment_json = $segments;

        return $object;
    }


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%stock_product}}';
    }


    public function getProduct()
    {
        return $this->hasOne(Product::class, ['product_id' => 'product_id']);
    }

    public function getProductDescription()
    {
        return $this->hasOne(ProductDescription::class, ['product_id' => 'product_id'])->where(['language_id' => 2]);
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

    public static function find(): StockQuery
    {
        return new StockQuery(static::class);
    }
}
