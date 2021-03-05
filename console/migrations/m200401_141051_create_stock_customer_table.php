<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%stock_customer}}`.
 */
class m200401_141051_create_stock_customer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%stock_customer}}', [
            'id' => $this->primaryKey(),
            'stock_id' => $this->integer(),
            'customer_id' => $this->integer()
        ],$tableOptions);


        $this->addForeignKey(
            '{{%fk-stock_customer-stock_id}}',
            '{{%stock_customer}}',
            'stock_id',
            '{{%stock}}',
            'id',
            'CASCADE',
            'RESTRICT');

        $this->addForeignKey(
            '{{%fk-stock_customer-customer_id}}',
            '{{%stock_customer}}',
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
        $this->dropTable('{{%stock_customer}}');
    }
}
