<?php

use yii\db\Migration;

class m220404_093017_create_note_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%note}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100),
            'effect_day' => $this->dateTime(),
            'file' => $this->text(),
        ], $tableOptions);
    }

    public function safeDown()
    {

        $this->dropTable('{{%note}}');
    }
}
