<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cart_item_presents}}`.
 */
class m201018_165606_create_cart_item_presents_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%cart_item_presents}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'cart_item_id' => $this->integer()->notNull(),
            'option' => $this->integer()->null(),
            'option_name' => $this->string()->null(),
            'quantity' => $this->integer()->null()
        ],$tableOptions);

        $this->addForeignKey(
            '{{%fk-cart_item_presents-cart_item_id}}',
            '{{%cart_item_presents}}',
            'cart_item_id',
            '{{%cart_items}}',
            'cart_id',
            'CASCADE',
            'RESTRICT');


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%cart_item_presents}}');
    }
}
