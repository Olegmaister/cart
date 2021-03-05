<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order_items}}`.
 */
class m200310_123032_create_order_items_table extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%order_items}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'product_id' => $this->integer(),
            'product_name' => $this->string()->notNull(),
            'product_code' => $this->string()->notNull(),
            'option_id' => $this->integer()->null(),
            'option_name' => $this->string()->null(),
            'product_color_image' => $this->string()->null(),
            'price' => $this->integer()->notNull(),
            'quantity' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-order_items-order_id}}', '{{%order_items}}', 'order_id');
        $this->createIndex('{{%idx-order_items-product_id}}', '{{%order_items}}', 'product_id');


        $this->addForeignKey(
            '{{%fk-order_items-order_id}}',
            '{{%order_items}}',
            'order_id',
            '{{%orders}}',
            'id',
            'CASCADE',
            'RESTRICT');
    }

    public function down()
    {
        $this->dropTable('{{%order_items}}');
    }
}

