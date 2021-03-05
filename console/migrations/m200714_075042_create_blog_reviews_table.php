<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%blog_reviews}}`.
 */
class m200714_075042_create_blog_reviews_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%blog_reviews}}',[
            'id' => $this->primaryKey(),
            'blog_id' => $this->integer()->notNull(),
            'customer_id' => $this->integer()->null(),
            'lft' => $this->integer()->notNull(),
            'rgt' => $this->integer()->notNull(),
            'depth' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'slug' => $this->string(255)->null(),
            'updated_at' => $this->integer()->null(),
            'status' => $this->tinyInteger()->defaultValue(0)
        ], $tableOptions);

        $this->addForeignKey(
            '{{%fk-blog_reviews-customer_id}}',
            '{{%blog_reviews}}',
            'customer_id',
            '{{%customers}}',
            'customer_id',
            'CASCADE',
            'RESTRICT');


        $this->insert('{{%blog_reviews}}',[
            'id' => 1,
            'blog_id' => 0,
            'slug' => 'root',
            'lft' => 1,
            'rgt' => 2,
            'depth' => 0,
            'created_at' => '1111111111'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%blog_reviews}}');
    }
}
