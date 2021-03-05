<?php

namespace common\entities\Stock;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%stock_amount}}".
 *
 * @property int $id
 * @property int $stock_id
 * @property float $cost
 *
 * @property Stock $stock
 */
class StockCost extends ActiveRecord
{

    public static function create(int $cost)
    {
        $object = new self();
        $object->cost = $cost;


        return $object;

    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%stock_cost}}';
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
