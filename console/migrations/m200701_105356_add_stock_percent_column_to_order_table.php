<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%order}}`.
 */
class m200701_105356_add_stock_percent_column_to_order_table extends Migration
{
    public function safeUp()
    {

        $this->addColumn('{{%orders}}', 'stock_percent', $this->integer()->null());
        $this->addColumn('{{%orders}}', 'stock_value', $this->integer()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

    }
}
