<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%payment_additions}}`.
 */
class m200316_193807_create_payment_additions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%payment_additions}}', [
            'id' => $this->primaryKey(),
            'payment_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'country' => $this->string()->null()
        ],$tableOptions);


        $this->addForeignKey('{{%fk-payment_additions-payment_id}}', '{{%payment_additions}}', 'payment_id', '{{%payments}}', 'id', 'CASCADE', 'RESTRICT');

        $this->insert('{{%payment_additions}}',[
            'payment_id' => 1,
            'name' => 'LiqPay',
            'country' => ''
        ]);
        $this->insert('{{%payment_additions}}',[
            'payment_id' => 1,
            'name' => 'wayForPay',
            'country' => 'other'
        ]);
        $this->insert('{{%payment_additions}}',[
            'payment_id' => 1,
            'name' => 'Apple Pay',
            'country' => ''
        ]);
        $this->insert('{{%payment_additions}}',[
            'payment_id' => 3,
            'name' => 'privat_pp',
            'country' => ''
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%payment_additions}}');
    }
}

