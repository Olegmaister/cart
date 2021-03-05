<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%stock_description}}`.
 */
class m200728_093636_add_language_name_column_to_stock_description_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%stock_description}}', 'language_name', $this->string(4)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

    }
}
