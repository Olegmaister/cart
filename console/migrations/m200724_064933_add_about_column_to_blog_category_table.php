<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%blog_category}}`.
 */
class m200724_064933_add_about_column_to_blog_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%blog_category}}', 'about', $this->tinyInteger(4)->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
