<?php

namespace common\entities\Stock;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%stock_present}}".
 *
 * @property int $id
 * @property int $stock_id
 * @property int $product_id
 * @property int $present_id
 */
class StockPresent extends ActiveRecord
{
    public static function create($productId, $productPresent)
    {
        $object = new self();
        $object->product_id = $productId;
        $object->present_id = $productPresent;

        return $object;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%stock_present}}';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'stock_id' => 'Stock ID',
            'product_id' => 'Product ID',
            'present_id' => 'Present ID',
        ];
    }
}
