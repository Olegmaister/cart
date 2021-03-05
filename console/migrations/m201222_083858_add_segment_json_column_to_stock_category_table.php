<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%stock_category}}`.
 */
class m201222_083858_add_segment_json_column_to_stock_category_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%stock_category}}', 'segment_json', 'JSON NOT NULL');
    }

    public function down()
    {
        $this->dropColumn('{{%stock_category}}', 'segment_json');
    }
}
