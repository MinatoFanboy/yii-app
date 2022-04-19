<?php

use yii\db\Migration;

class m220418_094516_create_slider_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%slider}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(100),
            'content' => $this->text(),
            'link' => $this->string(200),
            'representation' => $this->string(200),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%slider}}');
    }
}
