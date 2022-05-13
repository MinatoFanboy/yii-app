<?php

use yii\db\Migration;

class m220513_191701_create_order_detail_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%order_detail}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer(),
            'product_id' => $this->integer(),
            'price' => $this->decimal(20, 3)->defaultValue(0),
        ], $tableOptions);

        $this->addForeignKey('order_detail_order_id_fk', 'order_detail', 'order_id', 'order', 'id', 'NO ACTION', 'NO ACTION');

        $this->createIndex('order_detail_order_id_fk', 'order_detail', 'order_id');

        $this->addForeignKey('order_detail_product_id_fk', 'order_detail', 'product_id', 'product', 'id', 'NO ACTION', 'NO ACTION');

        $this->createIndex('order_detail_product_id_fk', 'order_detail', 'product_id');
    }

    public function safeDown()
    {
        $this->dropForeignKey('order_detail_order_id_fk', 'order_detail');

        $this->dropIndex('order_detail_order_id_fk', 'order_detail');

        $this->dropForeignKey('order_detail_product_id_fk', 'order_detail');

        $this->dropIndex('order_detail_product_id_fk', 'order_detail');

        $this->dropTable('{{%order_detail}}');
    }
}
