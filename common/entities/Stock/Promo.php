<?php

namespace common\entities\Stock;


use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%promo}}".
 *
 * @property int $id
 * @property int $count
 * @property string $promo_token
 *
 * @property StockPromo[] $stockPromos
 */
class Promo extends ActiveRecord
{

    public static function create(array $data)
    {

        $object = new self();
        $object->count = $data['count'];
        $object->promo_token = $data['promoToken'];

        return $object;

    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%promo}}';
    }

    public function getStockPromos()
    {
        return $this->hasMany(StockPromo::class, ['promo_id' => 'id']);
    }

    public function getStock()
    {
        return $this->hasMany(Stock::class, ['id' => 'stock_id']);
    }
}
