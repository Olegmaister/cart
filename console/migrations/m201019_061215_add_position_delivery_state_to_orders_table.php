<?php

use yii\db\Migration;

/**
 * Class m201019_061215_add_position_delivery_state_to_orders_table
 */
class m201019_061215_add_position_delivery_state_to_orders_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%orders}}', 'delivery_state', $this->string(255)->null());

    }

    public function down()
    {
        $this->addColumn('{{%orders}}', 'delivery_state', $this->string());
    }
}
