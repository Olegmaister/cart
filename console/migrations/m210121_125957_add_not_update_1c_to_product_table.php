<?php

use yii\db\Migration;

/**
 * Class m210121_125957_add_not_update_1c_to_product_table
 */
class m210121_125957_add_not_update_1c_to_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product}}', 'not_update_1c', $this->integer(1)->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
