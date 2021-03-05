<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%customers}}`.
 */
class m201113_161450_add_segment_column_to_customers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%customers}}','group_id');
        $this->addColumn('{{%customers}}','segment_id',$this->integer()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
