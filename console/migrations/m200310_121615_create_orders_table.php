<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%orders}}`.
 */
class m200310_121615_create_orders_table extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%orders}}', [
            //customer
            'id' => $this->primaryKey(),
            'customer_id' => $this->integer()->notNull(),
            'customer_group_id' => $this->integer()->notNull(),
            'first_name' => $this->string(),
            'last_name' => $this->string(),
            'phone' => $this->string(),
            'email' => $this->string(),

            //Recipient
            'recipient_first_name' => $this->string(),
            'recipient_last_name' => $this->string(),
            'recipient_phone' => $this->string(),
            'recipient_email' => $this->string(),
            'recipient_ttn' => $this->string(),

            //delivery
            'delivery_method_id' => $this->integer()->notNull(),
            'delivery_cost' => $this->integer()->null(),
            'delivery_country' => $this->string(),// страна доставки
            'delivery_city' => $this->string(),// город доставки
            'delivery_branch' => $this->integer(),//отделение новой почты
            'delivery_branch_name' => $this->string(),//отделение новой почты
            'delivery_street' => $this->string(),// улица
            'delivery_house' => $this->string(), // дом
            'delivery_apartment' => $this->string(), // квартира
            'delivery_porch' => $this->string(), // подьезд
            'delivery_index' => $this->string(), // подьезд


            //payments
            'payment_id' => $this->integer()->notNull(),
            'payment_addition_id' => $this->integer()->null(),
            'payment_bank_card' => $this->string()->null(),
            'parts' => $this->integer()->null(),

            //other
            'cost' => $this->float()->notNull(),
            'funded_cost' => $this->float()->null(),
            'weight' => $this->integer()->null(),
            'current_status' => $this->integer()->notNull(),
            'statuses_json' => 'JSON NOT NULL',
            'comment' => $this->text(),
            'cancel_reason' => $this->text(),
            'call_me' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer(),

        ], $tableOptions);

        $this->createIndex('{{%idx-orders-customer_id}}', '{{%orders}}', 'customer_id');
        $this->createIndex('{{%idx-orders-delivery_method_id}}', '{{%orders}}', 'delivery_method_id');

    }

    public function down()
    {
        $this->dropTable('{{%orders}}');
    }
}

