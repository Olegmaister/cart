<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order_presents}}`.
 */
class m201109_081602_create_order_presents_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%order_presents}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'option_id' => $this->integer()->notNull(),
            'option_name' => $this->string(255),
            'quantity' => $this->integer()->notNull(),
            'price' => $this->integer(),
            'total_amount'=> $this->integer()
        ],$tableOptions);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%order_presents}}');
    }
}
