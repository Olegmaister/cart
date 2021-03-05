<?php

use yii\db\Migration;

/**
 * Class m201231_121021_add_guid_group_price_column_brand
 */
class m201231_121021_add_guid_group_price_column_brand extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('brand', 'guid_group_price', $this->string(64));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('brand', 'guid_group_price');
    }
}
