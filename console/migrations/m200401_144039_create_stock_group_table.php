<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%stock_group}}`.
 */
class m200401_144039_create_stock_group_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%stock_group}}', [
            'id' => $this->primaryKey(),
            'stock_id' => $this->integer(),
            'group_id' => $this->integer()
        ],$tableOptions);


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%stock_group}}');
    }
}
