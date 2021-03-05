<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%blog_category_children_description}}`.
 */
class m200426_093623_create_blog_category_children_description_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%blog_category_children_description}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'language_id' => $this->integer()->notNull(),
            'language_name' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'subtitle_article' =>$this->string()->notNull(),
            'introduction' => $this->text()->null(),
            'heading' => $this->string()->null(),
            'description' => $this->text()->null(),
            'text' => $this->text()->null(),
            'meta_title'=> $this->text()->null(),
            'meta_description'=> $this->text()->null(),
            'meta_keyword'=> $this->text()->null(),
        ],$tableOptions);


        $this->addForeignKey(
            '{{%fk-blog_category_children_description-category_id}}',
            '{{%blog_category_children_description}}',
            'category_id',
            '{{%blog_category}}',
            'id',
            'CASCADE',
            'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%blog_category_children_description}}');
    }
}
