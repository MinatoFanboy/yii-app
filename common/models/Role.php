<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $name
 * @property int|null $status
 *
 * @property UserRole[] $userRoles
 */
class Role extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%role}}';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'duplicateName'],
            [['name'], 'string', 'max' => 50, 'message' => '{attribute} không vượt quá 50 ký tự'],
            [['status'], 'integer'],
        ];
    }

    public function duplicateName($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $role = self::find()->andFilterWhere(['name' => $this->$attribute])->andFilterWhere(['status' => myAPI::ACTIVE]);
            if(!$this->isNewRecord){
                $role->andFilterWhere(['<>', 'id', $this->id]);
            }

            if(!is_null($role->one())){
                $this->addError($attribute, "{$this->getAttributeLabel($attribute)} đã tồn tại");
            }
        }
    }

    public function getUserRoles()
    {
        return $this->hasMany(UserRole::className(), ['role_id' => 'id']);
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Tên',
            'status' => 'Trạng thái',
        ];
    }
}
