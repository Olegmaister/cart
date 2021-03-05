<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cart_items}}`.
 */
class m200221_091543_create_cart_items_table extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%cart_items}}', [
            'cart_id' => $this->primaryKey(),
            'api_id' => $this->integer(),
            'customer_id' => $this->integer()->notNull(),
            'session_id' => $this->string(32),
            'category_id' => $this->integer()->null(),
            'product_id' => $this->integer(),
            'recurring_id' => $this->integer(),
            'option' => $this->string(255),
            'option_name' => $this->string(255)->null(),
            'product_color_image' => $this->string(255)->null(),
            'quantity' => $this->integer(5),
            'date_added' => $this->integer()->null()
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%cart_items}}');
    }
}
