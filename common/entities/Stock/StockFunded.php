<?php

namespace common\entities\Stock;

use backend\forms\Stocks\StockCreateForm;
use backend\forms\Stocks\StockFundedForm;
use Yii;

/**
 * This is the model class for table "{{%stock_funded}}".
 *
 * @property int $id
 * @property int $stock_id
 * @property string $name
 * @property int $cost
 *
 *
 *  * @property Stock $stock
 */
class StockFunded extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%stock_funded}}';
    }

    public function create(StockCreateForm $form)
    {
        $object = new self();
        $object->name = $form->ru->name;
        $object->cost = $form->funded->cost;

        return $object;
    }

    public function edit($cost)
    {
        $this->cost = $cost;

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
