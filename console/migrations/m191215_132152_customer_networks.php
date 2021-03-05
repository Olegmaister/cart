<?php

use yii\db\Migration;

/**
 * Class m191215_132152_user_networks
 */
class m191215_132152_customer_networks extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%customer_networks}}', [
            'id' => $this->primaryKey(),
            'customer_id' => $this->integer()->notNull(),
            'identity' => $this->string()->notNull(),
            'network' => $this->string(16)->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-customer_networks-identity-name}}', '{{%customer_networks}}', ['identity', 'network'], true);

        $this->createIndex('{{%idx-customer_networks-customer_id}}', '{{%customer_networks}}', 'customer_id');

        $this->addForeignKey('{{%fk-customer_networks-customer_id}}', '{{%customer_networks}}', 'customer_id', '{{%customers}}', 'customer_id', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%customer_networks}}');
    }
}
