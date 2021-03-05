<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%blog_photos}}`.
 */
class m200423_143653_create_blog_photos_table extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%blog_photos}}', [
            'id' => $this->primaryKey(),
            'blog_id' => $this->integer()->notNull(),
            'file' => $this->string()->notNull(),
            'sort' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex(
            '{{%idx-blog_photos-blog_id}}',
            '{{%blog_photos}}',
            'blog_id');

        $this->addForeignKey(
            '{{%fk-blog_photos-blog_id}}',
            '{{%blog_photos}}',
            'blog_id',
            '{{%blog_category}}',
            'id',
            'CASCADE',
            'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%blog_photos}}');
    }
}
