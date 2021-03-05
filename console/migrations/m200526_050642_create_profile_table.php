<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%profile}}`.
 */
class m200526_050642_create_profile_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%profile}}', [
            'id' => $this->primaryKey(),
            'customer_id' => $this->integer(),
            'avatar' => $this->string(),
            'first_name' => $this->string()->null(),
            'last_name' => $this->string()->null(),
            'father_name' => $this->string()->null(),
            'phone' => $this->string()->null(),
            'country_id' => $this->integer()->null(),
            'city_id' => $this->integer(),
            'city_name' => $this->string()->null(),
            'street' => $this->string()->null(),
            'house' => $this->string()->null(),
            'apartment' => $this->string()->null(),
            'porch' => $this->string()->null(),
            'index' => $this->string()->null(),
            'date_birth' => $this->integer()->null()

        ],$tableOptions);

        $this->addForeignKey(
            '{{%fk-profile-customer_id}}',
            '{{%profile}}',
            'customer_id',
            '{{%customers}}',
            'customer_id',
            'CASCADE',
            'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%profile}}');
    }
}
