<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%group}}`.
 */
class m200401_124858_create_group_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%group}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'type' => $this->string(255)->null(),
            'percent' => $this->integer()->notNull(),
            'sort' => $this->integer()->notNull()
        ],$tableOptions);

        $this->createIndex('{{%idx-group_name}}', '{{%group}}', 'name');

        $this->insert('{{%group}}',[
            'name' => 'Buyer',
            'percent' => '0',
            'sort' => 1
        ]);

        $this->insert('{{%group}}',[
            'name' => 'Wholesaler',
            'percent' => '5',
            'sort' => 2
        ]);

        $this->insert('{{%group}}',[
            'name' => 'Vip',
            'percent' => '8',
            'sort' => 3
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%group}}');
    }
}
