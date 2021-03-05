<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%blog_likes}}`.
 */
class m200622_054846_create_blog_likes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%blog_likes}}', [
            'id' => $this->primaryKey(),
            'blog_id' => $this->integer(),
            'ip' => $this->string(),
            'like' => $this->integer()
        ],$tableOptions);


        $this->addForeignKey(
            '{{%fk-blog_likes-blog_id}}',
            '{{%blog_likes}}',
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
        $this->dropTable('{{%blog_likes}}');
    }
}
