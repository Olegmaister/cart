<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%blog_category_assignment}}`.
 */
class m200426_192825_create_blog_category_assignment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%blog_category_assignment}}', [
            'blog_id' => $this->integer(),
            'main_id' => $this->integer(),
        ],$tableOptions);

        $this->addPrimaryKey(
            '{{%pk-blog_category_assignment}}',
            '{{%blog_category_assignment}}',
            ['blog_id', 'main_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%blog_category_assignment}}');
    }
}
