<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%blog_tag}}`.
 */
class m200426_203249_create_blog_tag_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%blog_tag}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull()
        ],$tableOptions);

        $this->createIndex(
            '{{%idx-blog_tag-slug}}',
            '{{%blog_tag}}',
            'slug', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%blog_tag}}');
    }
}
