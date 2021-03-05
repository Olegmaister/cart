<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%stock_funded}}`.
 */
class m200413_081758_create_stock_funded_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%stock_funded}}', [
            'id' => $this->primaryKey(),
            'stock_id' => $this->integer()->notNull(),
            'customer_id' => $this->integer()->notNull(),
            'cost' => $this->float()->notNull()
        ],$tableOptions);

        $this->addForeignKey(
            '{{%fk-stock_funded-stock_id}}',
            '{{%stock_funded}}',
            'stock_id',
            '{{%stock}}',
            'id',
            'CASCADE',
            'RESTRICT');

        $this->addForeignKey(
            '{{%fk-stock_funded-customer_id}}',
            '{{%stock_funded}}',
            'customer_id',
            '{{%customers}}',
            'customer_id',
            'CASCADE',
            'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%stock_funded}}');
    }
}
