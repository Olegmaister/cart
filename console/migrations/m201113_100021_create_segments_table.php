<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%segments}}`.
 */
class m201113_100021_create_segments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%segments}}', [
            'id' => $this->primaryKey(),
            'guid' => $this->string(255)->notNull(),
            'name' => $this->string(255)->notNull(),
            'percent' => $this->integer()->null(),
            'opt' => $this->tinyInteger()->notNull()->defaultValue(0)
        ],$tableOptions);

        $result = explode(';',file_get_contents(Yii::getAlias('@frontend/web/segments.txt')));
        $resArray = [];
        foreach ($result as $item){
            $itemResult = explode('|',$item);
            if(empty($itemResult[0]) || empty($itemResult[1]))
                continue;
            $resArray[] = [trim($itemResult[1]),trim($itemResult[0]),trim($itemResult[2])];
        }

        $this->batchInsert('{{%segments}}',['guid','name','opt'],
            $resArray
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%segments}}');
    }
}
