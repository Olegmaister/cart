<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%blog_tag}}`.
 */
class m201006_115311_drop_name_column_from_blog_tag_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->dropColumn('blog_tag', 'name');
    }

    public function down()
    {
        $this->addColumn('blog_tag', 'name', $this->integer());
    }
}
