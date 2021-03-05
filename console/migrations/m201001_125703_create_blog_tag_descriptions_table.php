<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%blog_tag_descriptions}}`.
 */
class m201001_125703_create_blog_tag_descriptions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%blog_tag_description}}',[
            'id' => $this->primaryKey(),
            'tag_id' => $this->integer(),
            'language_id' => $this->tinyInteger()->notNull(),
            'name' => $this->string()->null()
        ], $tableOptions);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%blog_tag_descriptions}}');
    }
}
