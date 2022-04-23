<?php

use yii\db\Migration;

class m220418_095842_create_product_keyword_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%product_keyword}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(),
            'keyword_id' => $this->integer(),
        ]);

        $this->addForeignKey('product_keyword_product_id_fk', 'product_keyword', 'product_id', 'product', 'id', 'NO ACTION', 'NO ACTION');
        $this->addForeignKey('product_keyword_keyword_id_fk', 'product_keyword', 'keyword_id', 'keyword', 'id', 'NO ACTION', 'NO ACTION');

        $this->createIndex('product_keyword_product_id_fk', 'product_keyword', 'product_id');
        $this->createIndex('product_keyword_keyword_id_fk', 'product_keyword', 'keyword_id');
    }

    public function safeDown()
    {
        $this->dropForeignKey('product_keyword_product_id_fk', 'product_keyword');
        $this->dropForeignKey('product_keyword_keyword_id_fk', 'product_keyword');

        $this->dropIndex('product_keyword_product_id_fk', 'product_keyword');
        $this->dropIndex('product_keyword_keyword_id_fk', 'product_keyword');

        $this->dropTable('{{%product_keyword}}');
    }
}
