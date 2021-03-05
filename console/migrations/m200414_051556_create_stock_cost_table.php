<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%stock_cost}}`.
 */
class m200414_051556_create_stock_cost_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%stock_cost}}', [
            'id' => $this->primaryKey(),
            'stock_id' => $this->integer()->notNull(),
            'cost' =>$this->float()->notNull()
        ],$tableOptions);

        $this->addForeignKey(
            '{{%fk-stock_cost-stock_id}}',
            '{{%stock_cost}}',
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
        $this->dropTable('{{%stock_cost}}');
    }
}
