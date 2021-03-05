<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%stock}}`.
 */
class m200903_045208_add_money_column_to_stock_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%stock}}', 'money', $this->double()->null());
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
