<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shop_delivery_methods}}`.
 */
class m200306_113624_create_shop_delivery_methods_table extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%delivery_methods}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'country' => $this->string()->notNull(),
            'sort' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->insert('{{%delivery_methods}}',[
            'name' => 'Доставка курьером Новой Почты',
            'country' => 'UA',
            'sort' => 1

        ]);

        $this->insert('{{%delivery_methods}}',[
            'name' => 'Доставка в отделение Новой Почты',
            'country' => 'UA',
            'sort' => 2

        ]);

        $this->insert('{{%delivery_methods}}',[
            'name' => 'Укр почта',
            'country' => 'OTHER',
            'sort' => 3

        ]);

    }

    public function down()
    {
        $this->dropTable('{{%delivery_methods}}');
    }
}
