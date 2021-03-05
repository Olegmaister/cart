<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%blog_tag_assignment}}`.
 */
class m200426_203439_create_blog_tag_assignment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%blog_tag_assignment}}', [
            'blog_id' => $this->integer(),
            'tag_id' => $this->integer()
        ],$tableOptions);

        $this->addPrimaryKey(
            '{{%pk-blog_tag_assignment}}',
            '{{%blog_tag_assignment}}',
            ['blog_id', 'tag_id']
        );

        $this->createIndex(
            '{{%idx-blog_tag_assignment-blog_id}}',
            '{{%blog_tag_assignment}}',
            'blog_id');

        $this->createIndex(
            '{{%idx-blog_tag_assignment-tag_id}}',
            '{{%blog_tag_assignment}}',
            'tag_id');

        $this->addForeignKey(
            '{{%fk-blog_tag_assignment-blog_id}}',
            '{{%blog_tag_assignment}}',
            'blog_id',
            '{{%blog_category}}',
            'id',
            'CASCADE',
            'RESTRICT');

        $this->addForeignKey(
            '{{%fk-blog_tag_assignment-tag_id}}',
            '{{%blog_tag_assignment}}',
            'tag_id',
            '{{%blog_tag}}',
            'id',
            'CASCADE',
            'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%blog_tag_assignment}}');
    }
}
