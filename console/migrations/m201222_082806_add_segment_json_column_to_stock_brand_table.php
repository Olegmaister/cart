<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%stock_brand}}`.
 */
class m201222_082806_add_segment_json_column_to_stock_brand_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%stock_brand}}', 'segment_json', 'JSON NOT NULL');
    }

    public function down()
    {
        $this->dropColumn('{{%stock_brand}}', 'segment_json');
    }
}
