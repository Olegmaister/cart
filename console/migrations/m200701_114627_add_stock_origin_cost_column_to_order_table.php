<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%order}}`.
 */
class m200701_114627_add_stock_origin_cost_column_to_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%orders}}', 'origin_cost', $this->float()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
