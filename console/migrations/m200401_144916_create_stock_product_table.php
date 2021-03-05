<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%stock_product}}`.
 */
class m200401_144916_create_stock_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%stock_product}}', [
            'id' => $this->primaryKey(),
            'stock_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull()
        ],$tableOptions);


        $this->addForeignKey(
            '{{%fk-stock_product-stock_id}}',
            '{{%stock_product}}',
            'stock_id',
            '{{%stock}}',
            'id',
            'CASCADE',
            'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%stock_product}}');
    }
}
