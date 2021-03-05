<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%countries}}`.
 */
class m201012_103956_add_sort_column_to_countries_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn('{{%countries}}', 'sort', $this->integer()->defaultValue(0));
        
    }

    public function down()
    {
        $this->addColumn('countries', 'sort', $this->integer());
    }
}
