<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%order_items}}`.
 */
class m200817_072705_add_discount_price_column_to_order_items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%order_items}}', 'discount_price', $this->float()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
