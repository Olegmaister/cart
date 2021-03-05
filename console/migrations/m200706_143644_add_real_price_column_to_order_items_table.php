<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%order_items}}`.
 */
class m200706_143644_add_real_price_column_to_order_items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%order_items}}', 'origin_price', $this->float()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
