<?php

use yii\db\Migration;

class m220418_093952_create_product_type_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%product_type}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50),
            'slug' => $this->string(50),
            'active' => $this->tinyInteger()->defaultValue(1),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%product_type}}');
    }
}
