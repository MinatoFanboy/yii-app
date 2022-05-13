<?php

use yii\db\Migration;

class m220418_094902_create_product_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100),
            'slug' => $this->string(100),
            'short_description' => $this->string(200),
            'description' => $this->text(),
            'cost' => $this->decimal(20, 3)->defaultValue(0),
            'price' => $this->decimal(20, 3)->defaultValue(0),
            'price_sale' => $this->decimal(20, 3)->defaultValue(0),
            'exist_day' => $this->dateTime(),
            'features' => $this->tinyInteger()->defaultValue(0),
            'newest' => $this->tinyInteger()->defaultValue(0),
            'sellest' => $this->tinyInteger()->defaultValue(0),
            'trademark_id' => $this->integer(),
            'trademark_name' => $this->string(100),
            'representation' => $this->text(),
            'class_type' => $this->text(),
            'active' => $this->tinyInteger()->defaultValue(1),
            'user_created_id' => $this->integer(),
            'user_created' => $this->string(100),
            'user_updated_id' => $this->integer(),
            'user_updated' => $this->string(100),
        ]);

        $this->addForeignKey('product_trademark_id_fk', 'product', 'trademark_id', 'trademark', 'id', 'NO ACTION', 'NO ACTION');

        $this->createIndex('product_trademark_id_fk', 'product', 'trademark_id');
    }

    public function safeDown()
    {
        $this->dropForeignKey('product_trademark_id_fk', 'product');

        $this->dropIndex('product_trademark_id_fk', 'product');

        $this->dropTable('{{%product}}');
    }
}
