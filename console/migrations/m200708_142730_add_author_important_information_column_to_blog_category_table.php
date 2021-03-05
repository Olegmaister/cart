<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%blog_category}}`.
 */
class m200708_142730_add_author_important_information_column_to_blog_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%blog_category}}', 'author', $this->string(255)->defaultValue('Неизвестный'));
        $this->addColumn('{{%blog_category}}', 'important_information', $this->tinyInteger()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
