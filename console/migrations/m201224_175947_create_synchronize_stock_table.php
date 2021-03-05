<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%synchronize_stock}}`.
 */
class m201224_175947_create_synchronize_stock_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%synchronize_stock}}', [
            'id' => $this->primaryKey(),
            'content' => $this->text()
        ],$tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%synchronize_stock}}');
    }



}
