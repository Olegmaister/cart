<?php

use yii\db\Migration;

/**
 * Class m201114_154046_remove_profile_country_name
 */
class m201114_154046_remove_profile_country_name extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('profile', 'country_name');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('profile', 'country_name', $this->string(255));
    }
}
