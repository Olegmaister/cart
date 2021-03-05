<?php

namespace common\entities\Stock;

use common\entities\Customer;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%stock_promo}}".
 *
 * @property int $id
 * @property int $stock_id
 * @property int $count
 * @property string $token

 *
 * @property Customer $customer
 * @property Promo $promo
 * @property Stock $stock
 */
class StockPromo extends ActiveRecord
{

    public static function create($promo)
    {

        $object = new self();
        $object->count = $promo['count'];
        $object->token = $promo['promoToken'];

        return $object;
    }

    public function reduceCount()
    {
        --$this->count;
    }


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%stock_promo}}';
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
     * Gets query for [[Promo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPromo()
    {
        return $this->hasMany(Promo::class, ['id' => 'promo_id']);
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

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
