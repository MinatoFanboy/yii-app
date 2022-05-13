<?php

use yii\db\Migration;

class m220513_191256_create_order_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey(),
            'customer_id' => $this->integer(),
            'total' => $this->decimal(20, 3)->defaultValue(0),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime(),
        ], $tableOptions);

        $this->addForeignKey('order_customer_id_fk', 'order', 'customer_id', 'user', 'id', 'NO ACTION', 'NO ACTION');

        $this->createIndex('order_customer_id_fk', 'order', 'customer_id');
    }

    public function safeDown()
    {
        $this->dropForeignKey('order_customer_id_fk', 'order');

        $this->dropIndex('order_customer_id_fk', 'order');

        $this->dropTable('{{%order}}');
    }
}
