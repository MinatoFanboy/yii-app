<?php

use yii\db\Migration;

class m220404_092229_create_user_role_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user_role}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'role_id' => $this->integer(),
        ], $tableOptions);

        $this->addForeignKey('user_role_user_id_fk', 'user_role', 'user_id', 'user', 'id', 'NO ACTION', 'NO ACTION');
        $this->addForeignKey('user_role_role_id_fk', 'user_role', 'role_id', 'role', 'id', 'NO ACTION', 'NO ACTION');

        $this->createIndex('user_role_user_id_fk', 'user_role', 'user_id');
        $this->createIndex('user_role_role_id_fk', 'user_role', 'role_id');
    }

    public function safeDown()
    {
        $this->dropForeignKey('user_role_user_id_fk', 'user_role');
        $this->dropForeignKey('user_role_role_id_fk', 'user_role');

        $this->dropIndex('user_role_user_id_fk', 'user_role');
        $this->dropIndex('user_role_role_id_fk', 'user_role');

        $this->dropTable('{{%user_role}}');
    }
}
