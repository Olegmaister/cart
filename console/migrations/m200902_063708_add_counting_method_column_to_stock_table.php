<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%stock}}`.
 */
class m200902_063708_add_counting_method_column_to_stock_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%stock}}', 'counting_method', $this->tinyInteger()->defaultValue(2));
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
