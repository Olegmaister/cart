<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%blog_category}}`.
 */
class m200622_072655_add_date_column_to_blog_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->addColumn('{{%blog_category}}', 'created_at', $this->integer()->null());
        $this->addColumn('{{%blog_category}}', 'updated_at', $this->integer()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

    }
}
