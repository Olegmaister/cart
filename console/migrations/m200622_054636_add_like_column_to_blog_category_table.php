<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%blog_category}}`.
 */
class m200622_054636_add_like_column_to_blog_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {


        $this->addColumn('{{%blog_category}}', 'like', $this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
