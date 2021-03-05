<?php

namespace common\models\StockWatch;

use common\entities\Products\ProductDescription;
use common\entities\SlugManager;
use Yii;

/**
 * This is the model class for table "stock_watch".
 *
 * @property int $id
 * @property string $email
 * @property string $created_at
 * @property int $status
 * @property int $product_id
 * @property int $language_id
 */
class StockWatch extends \yii\db\ActiveRecord
{
    // Ожидает рассылки, Уведомлен
    const STATUS_EXPECT = 0;
    const STATUS_ACTIVE = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stock_watch';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'product_id'], 'required'],
            [['created_at'], 'safe'],
            [['status', 'product_id', 'language_id'], 'integer'],
            ['email', 'email'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'E-mail',
            'created_at' => 'Дата создания',
            'status' => 'Статус',
            'product_id' => 'Название товара',
        ];
    }

    public function getUrl()
    {
        return SlugManager::find()
            ->select('keyword')
            ->where([
                'id' => $this->product_id,
                'url_alias.controller' => 'products',
                'action' => 'view'
            ]);
    }

    public function getDescription()
    {
        return ProductDescription::find()
            ->select('name')
            ->where([
                'product_id' => $this->product_id,
                'language_id' => 2
            ]);
    }

    public static function getActiveCount(): int
    {
        return (int) self::find()
            ->where(['status' => self::STATUS_EXPECT])
            ->count();
    }
}
