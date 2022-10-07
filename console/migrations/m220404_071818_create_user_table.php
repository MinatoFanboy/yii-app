<?php

use yii\db\Migration;

class m220404_071818_create_user_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(100),
            'auth_key' => $this->string(100),
            'password_hash' => $this->string(100),
            'password_reset_token' => $this->string(100),
            'name' => $this->string(100),
            'sex' => "enum('Nam', 'Nữ')",
            'date_of_birth' => $this->date(),
            'phone' => $this->string(20),
            'email' => $this->string(100)->notNull(),
            'address' => $this->text(),
            'status' => $this->tinyInteger()->defaultValue(10),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime(),
            'deleted_at' => $this->dateTime(),
            'verification' => $this->string(100),
            'type' => "enum('Thành viên', 'Khách hàng')",
            'role' => $this->text(),
            'user_created_id' => $this->integer(),
            'user_created' => $this->string(100),
            'user_updated_id' => $this->integer(),
            'user_updated' => $this->string(100),
            'user_deleted_id' => $this->integer(),
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
