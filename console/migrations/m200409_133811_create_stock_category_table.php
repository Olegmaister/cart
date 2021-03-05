<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%stock_category}}`.
 */
class m200409_133811_create_stock_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%stock_category}}', [
            'id' => $this->primaryKey(),
            'stock_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull()
        ],$tableOptions);

        $this->addForeignKey(
            '{{%fk-stock_category-stock_id}}',
            '{{%stock_category}}',
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
        $this->dropTable('{{%stock_category}}');
    }
}
