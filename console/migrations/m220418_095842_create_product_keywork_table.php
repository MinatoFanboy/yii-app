<?php

use yii\db\Migration;

class m220418_095842_create_product_keywork_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%product_keywork}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(),
            'keyword_id' => $this->integer(),
        ]);

        $this->addForeignKey('product_keywork_product_id_fk', 'product_keywork', 'product_id', 'product', 'id', 'NO ACTION', 'NO ACTION');
        $this->addForeignKey('product_keywork_keyword_id_fk', 'product_keywork', 'keyword_id', 'keyword', 'id', 'NO ACTION', 'NO ACTION');

        $this->createIndex('product_keywork_product_id_fk', 'product_keywork', 'product_id');
        $this->createIndex('product_keywork_keyword_id_fk', 'product_keywork', 'keyword_id');
    }

    public function safeDown()
    {
        $this->dropForeignKey('product_keywork_product_id_fk', 'product_keywork');
        $this->dropForeignKey('product_keywork_keyword_id_fk', 'product_keywork');

        $this->dropIndex('product_keywork_product_id_fk', 'product_keywork');
        $this->dropIndex('product_keywork_keyword_id_fk', 'product_keywork');

        $this->dropTable('{{%product_keywork}}');
    }
}
