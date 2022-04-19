<?php

use yii\db\Migration;

class m220412_035847_create_activity_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%activity}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull(),
            'controller_action' => $this->string(100)->notNull(),
            'group' => $this->string(100)->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%activity}}');
    }
}
