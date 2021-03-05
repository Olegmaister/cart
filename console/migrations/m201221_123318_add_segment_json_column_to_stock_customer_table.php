<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%stock_customer}}`.
 */
class m201221_123318_add_segment_json_column_to_stock_customer_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%stock_customer}}', 'segment_json', 'JSON NOT NULL');
    }

    public function down()
    {
        $this->dropColumn('{{%stock_customer}}', 'segment_json');
    }
}
