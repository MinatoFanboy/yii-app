<?php

use yii\db\Migration;

class m220418_094250_create_keyword_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%keyword}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50),
            'slug' => $this->string(50),
            'active' => $this->tinyInt(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%keyword}}');
    }
}
