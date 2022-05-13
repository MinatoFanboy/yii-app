<?php

use yii\db\Migration;

class m220513_171007_create_customer_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%customer}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(100),
            'password_hash' => $this->string(100),
            'password_reset_token' => $this->string(100),
            'name' => $this->string(100),
            'phone' => $this->string(20),
            'email' => $this->string(100)->notNull(),
            'address' => $this->text(),
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%customer}}');
    }
}
