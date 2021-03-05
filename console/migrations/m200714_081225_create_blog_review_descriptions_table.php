<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%blog_review_descriptions}}`.
 */
class m200714_081225_create_blog_review_descriptions_table extends Migration
{
    /**blog_review_descriptions
     * {@inheritdoc}
     */


    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%blog_review_descriptions}}',[
            'id' => $this->primaryKey(),
            'blog_review_id' => $this->integer()->notNull(),
            'author' => $this->string(255)->notNull(),
            'email' => $this->string(255)->notNull(),
            'rating' => $this->integer()->null(),
            'text' => $this->text()
        ], $tableOptions);

        $this->addForeignKey(
            '{{%fk-blog_review_descriptions-blog_review_id}}',
            '{{%blog_review_descriptions}}',
            'blog_review_id',
            '{{%blog_reviews}}',
            'id',
            'CASCADE',
            'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%blog_review_descriptions}}');
    }


}
