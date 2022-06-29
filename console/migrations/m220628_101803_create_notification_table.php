<?php

use yii\db\Migration;

class m220628_101803_create_notification_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%notification}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(100),
            'content' => $this->text(),
            'unread' => $this->tinyInteger()->defaultValue(0),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime(),
            'received_id' => $this->integer(),
            'user_id' => $this->integer(),
        ], $tableOptions);

        $this->addForeignKey('notification_received_id_fk', 'notification', 'received_id', 'user', 'id', 'NO ACTION', 'NO ACTION');

        $this->createIndex('notification_received_id_fk', 'notification', 'received_id');

        $this->addForeignKey('notification_user_id_fk', 'notification', 'user_id', 'user', 'id', 'NO ACTION', 'NO ACTION');

        $this->createIndex('notification_user_id_fk', 'notification', 'user_id');

        $this->addCommentOnColumn('notification', 'unread', '0: Chưa đọc, 1: Đã đọc');
    }

    public function safeDown()
    {
        $this->dropForeignKey('notification_received_id_fk', 'notification');

        $this->dropIndex('notification_received_id_fk', 'notification');

        $this->dropForeignKey('notification_user_id_fk', 'notification');

        $this->dropIndex('notification_user_id_fk', 'notification');

        $this->dropCommentFromColumn('notification', 'unread');

        $this->dropTable('{{%notification}}');
    }
}
