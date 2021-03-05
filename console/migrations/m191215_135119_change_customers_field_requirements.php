<?php

use yii\db\Migration;

/**
 * Class m191215_135119_change_customers_field_requirements
 */
class m191215_135119_change_customers_field_requirements extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->alterColumn('{{%customers}}','username',$this->string());
        $this->alterColumn('{{%customers}}','email',$this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m191215_135119_change_customers_field_requirements cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191215_135119_change_user_field_requirements cannot be reverted.\n";

        return false;
    }
    */
}
