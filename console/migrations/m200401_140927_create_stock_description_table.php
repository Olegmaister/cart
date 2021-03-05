<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%stock_description}}`.
 */
class m200401_140927_create_stock_description_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%stock_description}}', [
            'id' => $this->primaryKey(),
            'stock_id' => $this->integer(),
            'language_id' => $this->tinyInteger()->notNull(),
            'name' => $this->string(255),
            'heading' => $this->string(255),
            'description' => $this->string(255),
            'meta_title' => $this->string(255),
            'meta_description' => $this->string(255),
            'meta_keyword' => $this->string(255),
        ],$tableOptions);

        $this->addForeignKey(
            '{{%fk-stock_description-stock_id}}',
            '{{%stock_description}}',
            'stock_id',
            '{{%stock}}',
            'id',
            'CASCADE',
            'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%stock_description}}');
    }
}
