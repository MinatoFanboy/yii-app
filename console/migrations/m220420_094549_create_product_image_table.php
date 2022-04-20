<?php

use yii\db\Migration;

class m220420_094549_create_product_image_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%product_image}}', [
            'id' => $this->primaryKey(),
            'file' => $this->text(),
            'product_id' => $this->integer(),
        ]);

        $this->addForeignKey('product_image_product_id_fk', 'product_image', 'product_id', 'product', 'id', 'NO ACTION', 'NO ACTION');

        $this->createIndex('product_image_product_id_fk', 'product_image', 'product_id');
    }

    public function safeDown()
    {
        $this->dropForeignKey('product_image_product_id_fk', 'product_image');

        $this->dropIndex('product_image_product_id_fk', 'product_image');

        $this->dropTable('{{%product_image}}');
    }
}
