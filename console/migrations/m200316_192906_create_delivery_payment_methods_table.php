<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%delivery_payment_methods}}`.
 */
class m200316_192906_create_delivery_payment_methods_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%delivery_payment_methods}}', [
            'delivery_method_id' => $this->integer(),
            'payment_id' => $this->integer(),
        ],$tableOptions);


        $this->addPrimaryKey('{{%pk-delivery_payment_methods}}', '{{%delivery_payment_methods}}', ['delivery_method_id', 'payment_id']);

        $this->createIndex('{{%idx-delivery_payment_methods-delivery_method_id}}', '{{%delivery_payment_methods}}', 'delivery_method_id');
        $this->createIndex('{{%idx-delivery_payment_methods-payment_id}}', '{{%delivery_payment_methods}}', 'payment_id');

        $this->addForeignKey('{{%fk-delivery_payment_methods-delivery_method_id}}', '{{%delivery_payment_methods}}', 'delivery_method_id', '{{%delivery_methods}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-delivery_payment_methods-payment_id}}', '{{%delivery_payment_methods}}', 'payment_id', '{{%payments}}', 'id', 'CASCADE', 'RESTRICT');


        $this->insert('{{%delivery_payment_methods}}',[
            'delivery_method_id' => 1,
            'payment_id' => 1,
        ]);
        $this->insert('{{%delivery_payment_methods}}',[
            'delivery_method_id' => 1,
            'payment_id' => 2,
        ]);
        $this->insert('{{%delivery_payment_methods}}',[
            'delivery_method_id' => 1,
            'payment_id' => 3,
        ]);
        $this->insert('{{%delivery_payment_methods}}',[
            'delivery_method_id' => 2,
            'payment_id' => 1,
        ]);
        $this->insert('{{%delivery_payment_methods}}',[
            'delivery_method_id' => 2,
            'payment_id' => 2,
        ]);
        $this->insert('{{%delivery_payment_methods}}',[
            'delivery_method_id' => 2,
            'payment_id' => 3,
        ]);
        $this->insert('{{%delivery_payment_methods}}',[
            'delivery_method_id' => 2,
            'payment_id' => 4,
        ]);
        $this->insert('{{%delivery_payment_methods}}',[
            'delivery_method_id' => 3,
            'payment_id' => 1,
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%delivery_payment_methods}}');
    }
}
