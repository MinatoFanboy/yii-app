<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $content
 */
class CauHinh extends myActiveRecord
{
    public static function tableName()
    {
        return '{{%cau_hinh}}';
    }

    public function rules()
    {
        return [
            [['name', 'content'], 'required', 'message' => '{attribute} không được để trống'],
            [['content'], 'string'],
            [['name', 'code'], 'string', 'max' => 100, 'message' => '{attribute} vượt quá 100 kí tự'],
            [['code'], 'unique', 'message' => 'Cấu hình đã được sử dụng'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'code' => 'Slug',
            'content' => 'Content',
        ];
    }
}
