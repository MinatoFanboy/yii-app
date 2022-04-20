<?php

use yii\db\Migration;

class m220418_094416_create_trademark_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%trademark}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50),
            'slug' => $this->string(50),
            'file' => $this->text(),
            'active' => $this->tinyInteger()->defaultValue(1),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%trademark}}');
    }
}
