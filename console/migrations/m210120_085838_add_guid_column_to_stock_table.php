<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%stock}}`.
 */
class m210120_085838_add_guid_column_to_stock_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%stock}}', 'guid', $this->string(300)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropColumn('{{%stock}}', 'guid');
    }
}
