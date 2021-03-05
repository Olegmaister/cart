<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%stock_brand}}`.
 */
class m200401_150218_create_stock_brand_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%stock_brand}}', [
            'id' => $this->primaryKey(),
            'stock_id' => $this->integer()->notNull(),
            'brand_id' => $this->integer()->notNull()
        ],$tableOptions);


        $this->addForeignKey(
            '{{%fk-stock_brand-stock_id}}',
            '{{%stock_brand}}',
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
        $this->dropTable('{{%stock_brand}}');
    }
}
