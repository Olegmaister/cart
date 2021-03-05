<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%stock_promo}}`.
 */
class m200415_082013_create_stock_promo_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%stock_promo}}', [
            'id' => $this->primaryKey(),
            'stock_id' => $this->integer()->notNull(),
            'count' => $this->integer()->null(),
            'token' => $this->string(255)
        ],$tableOptions);

        $this->addForeignKey(
            '{{%fk-stock_promo-stock_id}}',
            '{{%stock_promo}}',
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
        $this->dropTable('{{%stock_promo}}');
    }
}
