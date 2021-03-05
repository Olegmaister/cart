<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%stock_product}}`.
 */
class m201221_165017_add_segment_json_column_to_stock_product_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%stock_product}}', 'segment_json', 'JSON NOT NULL');
    }

    public function down()
    {
        $this->dropColumn('{{%stock_product}}', 'segment_json');
    }
}
