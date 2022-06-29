<?php

namespace common\models;

use Yii;

/**
 * @property int $id
 * @property string|null $title
 * @property string|null $content
 * @property int|null $unread 0: Chưa đọc, 1: Đã đọc
 * @property string $created_at
 * @property string|null $updated_at
 * @property int|null $received_id
 * @property int|null $user_id
 *
 * @property User $received
 * @property User $user
 */
class Notification extends myActiveRecord
{
    public static function tableName()
    {
        return 'notification';
    }

    public function rules()
    {
        return [
            [['content'], 'string'],
            [['unread', 'received_id', 'user_id'], 'integer'],
            // [['created_at'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 100],
            [['received_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['received_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Tiêu đề',
            'content' => 'Nội dung',
            'unread' => 'Đã đọc',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'received_id' => 'Received ID',
            'user_id' => 'User ID',
        ];
    }

    public function getReceived()
    {
        return $this->hasOne(User::className(), ['id' => 'received_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->unread = 0;
        }

        return parent::beforeSave($insert);
    }
}
