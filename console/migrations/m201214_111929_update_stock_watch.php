<?php

use yii\db\Migration;

/**
 * Class m201214_111929_update_stock_watch
 */
class m201214_111929_update_stock_watch extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('stock_watch', 'language_id', $this->integer()->notNull()->defaultValue(2));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('stock_watch', 'language_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201214_111929_update_stock_watch cannot be reverted.\n";

        return false;
    }
    */
}
