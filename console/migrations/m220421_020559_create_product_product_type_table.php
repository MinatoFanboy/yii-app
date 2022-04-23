<?php

use yii\db\Migration;

class m220421_020559_create_product_product_type_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%product_product_type}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(),
            'product_type_id' => $this->integer(),
        ]);

        $this->addForeignKey('product_product_type_product_id_fk', 'product_product_type', 'product_id', 'product', 'id', 'NO ACTION', 'NO ACTION');
        $this->addForeignKey('product_product_type_product_type_id_fk', 'product_product_type', 'product_type_id', 'product_type', 'id', 'NO ACTION', 'NO ACTION');

        $this->createIndex('product_product_type_product_id_fk', 'product_product_type', 'product_id');
        $this->createIndex('product_product_type_product_type_id_fk', 'product_product_type', 'product_type_id');
    }

    public function safeDown()
    {
        $this->dropForeignKey('product_product_type_product_id_fk', 'product_product_type');
        $this->dropForeignKey('product_product_type_product_type_id_fk', 'product_product_type');

        $this->dropIndex('product_product_type_product_id_fk', 'product_product_type');
        $this->dropIndex('product_product_type_product_type_id_fk', 'product_product_type');

        $this->dropTable('{{%product_product_type}}');
    }
}
