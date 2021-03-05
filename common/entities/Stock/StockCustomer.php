<?php

namespace common\entities\Stock;

use common\entities\Customer;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 * This is the model class for table "{{%stock_customer}}".
 *
 * @property int $id
 * @property int|null $stock_id
 * @property int|null $customer_id
 * @property Json $segment_json
 *
 * @property Customer $customer
 * @property Stock $stock
 */
class StockCustomer extends ActiveRecord
{

    public static function create($customerId, $segments)
    {
        $object = new self();
        $object->customer_id = $customerId;
        $object->segment_json = $segments;
        return $object;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%stock_customer}}';
    }

    /**
     * Gets query for [[Customer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::class, ['customer_id' => 'customer_id']);
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
