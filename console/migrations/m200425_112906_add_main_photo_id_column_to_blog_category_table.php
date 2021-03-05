<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%blog_category}}`.
 */
class m200425_112906_add_main_photo_id_column_to_blog_category_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%blog_category}}', 'main_photo_id', $this->integer());
        $this->addForeignKey(
            '{{%fk-blog_category-main_photo_id}}',
            '{{%blog_category}}',
            'main_photo_id',
            '{{%blog_photos}}',
            'id',
            'SET NULL',
            'RESTRICT'
        );
    }

    public function down()
    {
        $this->dropForeignKey('{{%fk-blog_category-main_photo_id}}', '{{%blog_category}}');

        $this->dropColumn('{{%blog_category}}', 'main_photo_id');
    }
}
