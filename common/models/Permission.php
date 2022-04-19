<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $activity_id
 * @property int $role_id
 */
class Permission extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%permission}}';
    }

    public function rules()
    {
        return [
            [['activity_id', 'role_id'], 'required', 'message' => '{attribute} không được để trống'],
            [['activity_id', 'role_id'], 'integer'],
            [['activity_id'], 'exist', 'skipOnError' => true, 'targetClass' => Activity::className(), 'targetAttribute' => ['activity_id' => 'id']],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Role::className(), 'targetAttribute' => ['role_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'activity_id' => 'Activity ID',
            'role_id' => 'Role ID',
        ];
    }
}
