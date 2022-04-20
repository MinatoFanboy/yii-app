<?php

use yii\db\Migration;

class m220418_094623_create_slider_image_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%slider_image}}', [
            'id' => $this->primaryKey(),
            'file' => $this->text(),
            'slider_id' => $this->integer(),
        ]);

        $this->addForeignKey('slider_image_slider_id_fk', 'slider_image', 'slider_id', 'slider', 'id', 'NO ACTION', 'NO ACTION');

        $this->createIndex('slider_image_slider_id_fk', 'slider_image', 'slider_id');
    }

    public function safeDown()
    {
        $this->dropForeignKey('slider_image_slider_id_fk', 'slider_image');

        $this->dropIndex('slider_image_slider_id_fk', 'slider_image');

        $this->dropTable('{{%slider_image}}');
    }
}
