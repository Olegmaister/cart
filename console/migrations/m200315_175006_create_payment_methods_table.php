<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%payment_methods}}`.
 */
class m200315_175006_create_payment_methods_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%payments}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'description' => $this->text()->null(),
            'sort' => $this->tinyInteger()->notNull()
        ],$tableOptions);

        //add row sort
        $this->insert('{{%payments}}',[
            'name' => 'Оплата банковской картой',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet.',
            'sort' => 2
        ]);
        $this->insert('{{%payments}}',[
            'name' => 'Без наличный расчет (Счет фактура)',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet.',
            'sort' => 4
        ]);
        $this->insert('{{%payments}}',[
            'name' => 'Оплата частями',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet.',
            'sort' => 3
        ]);
        $this->insert('{{%payments}}',[
            'name' => 'Наложным платежем в отделении Новой Почты',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet.',
            'sort' => 1
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%payments}}');
    }
}

