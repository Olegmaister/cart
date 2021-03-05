<?php

declare(strict_types=1);

namespace common\models;

use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

/**
 * @property bool $id [tinyint(3) unsigned]
 * @property string $name_ua [varchar(255)]
 * @property string $name_ru [varchar(255)]
 * @property string $name_en [varchar(255)]
 */
class OrderStatus extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_ua', 'name_ru', 'name_en',], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_ua' => 'Название UA',
            'name_ru' => 'Название RU',
            'name_en' => 'Название EN',
        ];
    }

    public function search(): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => self::find(),
            'sort' => false,
        ]);
    }
}
