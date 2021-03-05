<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%blog_tag_description}}`.
 */
class m201006_120535_add_language_name_column_to_blog_tag_description_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn('blog_tag_description', 'language_name', $this->string());
    }

    public function down()
    {
        $this->dropColumn('blog_tag_description', 'language_name');
    }
}
