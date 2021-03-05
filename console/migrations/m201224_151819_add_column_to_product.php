<?php

use yii\db\Migration;

/**
 * Class m201224_151819_add_column_to_product
 */
class m201224_151819_add_column_to_product extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product}}', 'new_expires', $this->date()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201224_151819_add_column_to_product cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201224_151819_add_column_to_product cannot be reverted.\n";

        return false;
    }
    */
}
