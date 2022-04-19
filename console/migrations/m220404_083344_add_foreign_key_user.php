<?php

use yii\db\Migration;

class m220404_083344_add_foreign_key_user extends Migration
{

    public function safeUp()
    {
        $this->addForeignKey('user_user_created_id_fk', 'user', 'user_created_id', 'user', 'id', 'NO ACTION', 'NO ACTION');
        $this->addForeignKey('user_user_updated_id_fk', 'user', 'user_updated_id', 'user', 'id', 'NO ACTION', 'NO ACTION');
        $this->addForeignKey('user_user_deleted_id_fk', 'user', 'user_deleted_id', 'user', 'id', 'NO ACTION', 'NO ACTION');

        $this->createIndex('user_user_created_id_fk', 'user', 'user_created_id');
        $this->createIndex('user_user_updated_id_fk', 'user', 'user_updated_id');
        $this->createIndex('user_user_deleted_id_fk', 'user', 'user_deleted_id');
    }

    public function safeDown()
    {
        $this->dropForeignKey('user_user_created_id_fk', 'user');
        $this->dropForeignKey('user_user_updated_id_fk', 'user');
        $this->dropForeignKey('user_user_deleted_id_fk', 'user');

        $this->dropIndex('user_user_created_id_fk', 'user');
        $this->dropIndex('user_user_updated_id_fk', 'user');
        $this->dropIndex('user_user_deleted_id_fk', 'user');
    }
}
