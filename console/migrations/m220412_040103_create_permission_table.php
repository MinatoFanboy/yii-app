<?php

use yii\db\Migration;

class m220412_040103_create_permission_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%permission}}', [
            'id' => $this->primaryKey(),
            'activity_id' => $this->integer(),
            'role_id' => $this->integer(),
        ]);

        $this->addForeignKey('permission_activity_id_fk', 'permission', 'activity_id', 'activity', 'id', 'NO ACTION', 'NO ACTION');
        $this->addForeignKey('permission_role_id_fk', 'permission', 'role_id', 'role', 'id', 'NO ACTION', 'NO ACTION');

        $this->createIndex('permission_activity_id_fk', 'permission', 'activity_id');
        $this->createIndex('permission_role_id_fk', 'permission', 'role_id');
    }

    public function safeDown()
    {
        $this->dropForeignKey('permission_activity_id_fk', 'permission');
        $this->dropForeignKey('permission_role_id_fk', 'permission');

        $this->dropIndex('permission_activity_id_fk', 'permission');
        $this->dropIndex('permission_role_id_fk', 'permission');

        $this->dropTable('{{%permission}}');
    }
}
