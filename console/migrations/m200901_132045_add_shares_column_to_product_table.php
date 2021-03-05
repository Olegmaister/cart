<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%product}}`.
 */
class m200901_132045_add_shares_column_to_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product}}', 'shares', $this->tinyInteger()->defaultValue(0));
        $this->addColumn('{{%product}}', 'shares_date_to', $this->integer()->null());
        $this->addColumn('{{%product}}', 'shares_id', $this->integer()->null());
        $this->addColumn('{{%product}}', 'shares_temp', $this->text());

        $this->createIndex(
            '{{%idx-product-shares}}',
            '{{%product}}',
            'shares');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
