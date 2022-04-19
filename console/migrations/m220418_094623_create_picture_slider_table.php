<?php

use yii\db\Migration;

class m220418_094623_create_picture_slider_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%picture_slider}}', [
            'id' => $this->primaryKey(),
            'file' => $this->text(),
            'slider_id' => $this->integer(),
        ]);

        $this->addForeignKey('picture_slider_slider_id_fk', 'picture_slider', 'slider_id', 'slider', 'id', 'NO ACTION', 'NO ACTION');

        $this->createIndex('picture_slider_slider_id_fk', 'picture_slider', 'slider_id');
    }

    public function safeDown()
    {
        $this->dropForeignKey('picture_slider_slider_id_fk', 'picture_slider');

        $this->dropIndex('picture_slider_slider_id_fk', 'picture_slider');

        $this->dropTable('{{%picture_slider}}');
    }
}
