<?php

use yii\db\Migration;

/**
 * Class m200903_045458_alter_percent_column_to_stock_table
 */
class m200903_045458_alter_percent_column_to_stock_table extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('{{%stock}}', 'percent', $this->integer()->null());
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
