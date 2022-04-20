<?php

use yii\db\Migration;

class m220418_094902_create_product_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100),
            'short_description' => $this->string(200),
            'description' => $this->text(),
            'cost' => $this->decimal(20, 3),
            'price' => $this->decimal(20, 3),
            'price_sale' => $this->decimal(20, 3),
            'exist_day' => $this->dateTime(),
            'features' => $this->tinyInteger(),
            'newest' => $this->tinyInteger(),
            'sellest' => $this->tinyInteger(),
            'trademark_id' => $this->integer(),
            'trademark' => $this->string(100),
            'user_created_id' => $this->integer(),
            'user_created' => $this->string(100),
            'user_updated_id' => $this->integer(),
            'user_updated' => $this->string(100),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%product}}');
    }
}
