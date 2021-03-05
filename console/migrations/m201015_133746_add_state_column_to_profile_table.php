<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%profile}}`.
 */
class m201015_133746_add_state_column_to_profile_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn('{{%profile}}', 'state', $this->string(255)->null());

    }

    public function down()
    {
        $this->addColumn('{{%profile}}', 'state', $this->string());
    }
}
