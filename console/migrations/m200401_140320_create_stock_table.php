<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%stock}}`.
 */
class m200401_140320_create_stock_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {   $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%stock}}', [
            'id' => $this->primaryKey(),
            'type' => $this->string(255)->notNull(),
            'percent' => $this->integer()->notNull(),
            'date_from' => $this->integer()->null(),
            'date_to' => $this->integer()->null(),
            'active' => $this->tinyInteger()->notNull()
        ],$tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%stock}}');
    }
}
